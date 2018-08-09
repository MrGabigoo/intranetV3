<?php
/**
 * Created by PhpStorm.
 * User: davidannebicque
 * Date: 25/07/2018
 * Time: 16:33
 */

namespace App\MesClasses;

use App\Entity\Constantes;
use App\Entity\Etudiant;
use App\Entity\Groupe;
use App\Entity\Matiere;
use App\Entity\SalleExamen;
use App\Entity\TypeGroupe;
use App\MesClasses\Pdf\MyPDF;
use App\Repository\EtudiantRepository;
use App\Repository\GroupeRepository;
use App\Repository\MatiereRepository;
use App\Repository\PersonnelRepository;
use App\Repository\SalleExamenRepository;
use App\Repository\TypeGroupeRepository;

class MySalleExamen
{
    /** @var MatiereRepository */
    protected $matiereRepository;
    /** @var TypeGroupeRepository */
    protected $typeGroupeRepository;
    /** @var PersonnelRepository */
    protected $personnelRepository;
    /** @var SalleExamenRepository */
    protected $salleExamenRepository;
    /** @var GroupeRepository */
    protected $groupeRepository;

    /** @var EtudiantRepository */
    protected $etudiantRepository;

    /** @var SalleExamen */
    protected $salle;
    /** @var TypeGroupe */
    protected $typeGroupe;
    /** @var Matiere */
    protected $matiere;

    /**
     * MySalleExamen constructor.
     *
     * @param MatiereRepository     $matiereRepository
     * @param TypeGroupeRepository  $typeGroupeRepository
     * @param PersonnelRepository   $personnelRepository
     * @param SalleExamenRepository $salleExamenRepository
     * @param GroupeRepository      $groupeRepository
     */
    public function __construct(
        MatiereRepository $matiereRepository,
        TypeGroupeRepository $typeGroupeRepository,
        PersonnelRepository $personnelRepository,
        SalleExamenRepository $salleExamenRepository,
        GroupeRepository $groupeRepository,
        EtudiantRepository $etudiantRepository
    ) {
        $this->matiereRepository = $matiereRepository;
        $this->typeGroupeRepository = $typeGroupeRepository;
        $this->personnelRepository = $personnelRepository;
        $this->salleExamenRepository = $salleExamenRepository;
        $this->groupeRepository = $groupeRepository;
        $this->etudiantRepository = $etudiantRepository;
    }

    /**
     * @param $requestdateeval
     * @param $requestsalle
     * @param $requestmatiere
     * @param $requesttypegroupe
     * @param $requestgroupes
     * @param $requestenseignant1
     * @param $requestenseignant2
     */
    public function genereDocument(
        $requestdateeval,
        $requestsalle,
        $requestmatiere,
        $requesttypegroupe,
        $requestgroupes,
        $requestenseignant1,
        $requestenseignant2
    ) {
        $this->salle = $this->salleExamenRepository->find($requestsalle);
        $this->matiere = $this->matiereRepository->find($requestmatiere);


        if ($this->salle !== null && $this->matiere !== null) {
            if ($requesttypegroupe !== '') {
                $this->typeGroupe = $this->typeGroupeRepository->find($requesttypegroupe);
                $groupes = $this->typeGroupe->getGroupes();

                $typeg = $groupes[0]->getTypegroupe();
                $grdetail = array();
                $etudiants = array();
                /** @var Groupe $gr */
                foreach ($groupes as $gr) {
                    foreach ($requestgroupes as $dgr) {
                        if ($gr->getId() === $dgr) {
                            $grdetail[] = $gr;
                            foreach ($gr->getEtudiants() as $etu) {
                                $etudiants[] = $etu;
                            }
                        }
                    }
                }
            } else {
                $grdetail = $this->groupeDefaut($this->matiere->getSemestre());
                $typeg = $grdetail[0]->getTypegroupe();
                $etudiants = $this->etudiantRepository->findBySemestre($this->matiere->getSemestre());
            }


            if (count($etudiants) <= $this->salle->getCapacite()) {
                $tabplace = $this->calculPlaces();

                /* document 1 par groupe */
                $data = array(
                    'matiere'   => $this->matiere,
                    'etudiants' => $etudiants,
                    'tabplace'  => $this->placement($etudiants, $tabplace),
                    'typeg'     => $typeg,
                    'salle'     => $this->salle,
                    'ens1'      => $requestenseignant1 !== '' ? $this->personnelRepository->find($requestenseignant1) : null,
                    'ens2'      => $requestenseignant2 !== '' ? $this->personnelRepository->find($requestenseignant2) : null,
                    'groupes'   => $grdetail,
                    'depreuve'  => (string)$requestdateeval,
                    'linuxpath' => Constantes::BASE_URL
                );

                MyPDF::generePdf('pdf/placement.html.twig', $data, 'placement');
            }
            $this->container->get('session')->getFlashBag()->add(
                'warning',
                'Salle Trop petite Veuillez choisir une autre salle !'
            );
        }
    }

    /**
     * @param $semestre
     *
     * @return \App\Entity\Groupe[]|bool|\Doctrine\Common\Collections\Collection
     */
    private function groupeDefaut($semestre)
    {
        $typegroupe = $this->typeGroupeRepository->findBySemestre($semestre);

        /** @var TypeGroupe $tg */
        foreach ($typegroupe as $tg) {
            if ($tg->getDefaut() === true) {
                return $tg->getGroupes();
            }
        }

        return false;
    }

    /**
     * @return array
     */
    private function calculPlaces()
    {
        $k = 0;
        $tabinterdit = explode(';', $this->salle->getPlacesInterdites());
        $tabplace = array();

        $nbCol = $this->salle->getNbColonnes();
        $nbRang = $this->salle->getNbRangs();
        for ($i = 0; $i < $nbCol; $i++) {
            for ($j = 0; $j < $nbRang; $j++) {
                if ($j + 1 < 10) {
                    $place = chr(65 + $i) . '0' . ($j + 1);
                } else {
                    $place = chr(65 + $i) . ($j + 1);
                }

                if (!in_array($place, $tabinterdit)) {
                    $tabplace[$k] = $place;
                }
                $k++;
            }
        }

        shuffle($tabplace);

        return $tabplace;
    }

    /**
     * @param array $etudiants
     * @param array $tabplace
     *
     * @return array
     */
    private function placement($etudiants, $tabplace)
    {
        $placementetu = array();
        $placement = array();
        $i = 0;

        /** @var Etudiant $etu */
        foreach ($etudiants as $etu) {
            $placementetu[$etu->getId()] = $tabplace[$i];
            $placement[$tabplace[$i]] = $etu;
            $i++;
        }
        ksort($placement);
        $pl = array();
        $pl['etudiant'] = $placementetu;
        $pl['place'] = $placement;

        return $pl;
    }
}
