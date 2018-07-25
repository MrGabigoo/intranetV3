<?php
/**
 * Created by PhpStorm.
 * User: davidannebicque
 * Date: 25/07/2018
 * Time: 16:33
 */

namespace App\MesClasses;


use App\Entity\Matiere;
use App\Entity\SalleExamen;
use App\Entity\TypeGroupe;
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


    public function genereAction(
        $requestdateeval,
            $requestsalle,
            $requestmatiere,
            $requesttypegroupe,
            $requestgroupes
    )
    {
        $this->salle = $this->salleExamenRepository->find($requestsalle);
        $this->matiere = $this->matiereRepository->find($requestmatiere);


        if ($this->salle !== null && $this->matiere !== null) {

            if ($requesttypegroupe !== '') {
                $this->typeGroupe = $this->typeGroupeRepository->find($requesttypegroupe);
                $groupes = $this->typeGroupe->getGroupes();

                $typeg = $groupes[0]->getTypegroupe()->getTypegroupe();
                $grdetail = array();
                $etudiants = array();
                /** @var Groupes $gr */
                foreach ($groupes as $gr) {
                    foreach ($request->request->get('detail_groupes') as $dgr) {
                        if ($gr->getId() == $dgr) {
                            $grdetail[] = $gr;
                            foreach ($gr->getEtudiants() as $etu) {
                                $etudiants[] = $etu;
                            }
                        }
                    }
                }
            } else {
                $grdetail = $this->groupeDefaut($this->matiere->getSemestre());
                $typeg = $grdetail[0]->getTypegroupe()->getTypegroupe();
                $etudiants = $this->etudiantRepository->findBySemestre($this->matiere->getSemestre());
            }


            if (count($etudiants) <= $this->salle->getCapacite()) {

                $tabplace = $this->calculPlaces();

                /* document 1 par groupe */
                $html = $this->renderView('DAKernelBundle:PDF:placement.html.twig', array(
                    'matiere'   => $this->matiere,
                    'etudiants' => $etudiants,
                    'tabplace'  => $this->placement($etudiants, $tabplace),
                    'typeg'     => $typeg,
                    'salle'     => $this->salle,
                    'ens1'      => $this->recupereEnseignant($request->request->get('enseignant1')),
                    'ens2'      => $this->recupereEnseignant($request->request->get('enseignant2')),
                    'groupes'   => $grdetail,
                    'depreuve'  => (string)$requestdateeval,
                    'linuxpath' => Configuration::BASE_URL
                ));

                $options = new Options();
                $options->set('isRemoteEnabled', true);
                $options->set('isPhpEnabled', true);

                $dompdf = new Dompdf($options);
                $dompdf->loadHtml($html);
                $dompdf->render();

                return new Response ($dompdf->stream('Placement', array('Attachment' => 1)));
            }
            $this->container->get('session')->getFlashBag()->add('warning',
                'Salle Trop petite Veuillez choisir une autre salle !');

        }
    }


    private function groupeDefaut($semestre)
    {
        $typegroupe = $this->getDoctrine()->getRepository('DAKernelBundle:TypeGroupe')->findBy(array('semestre' => $semestre));
        foreach ($typegroupe as $tg) {
            if ($tg->getDefaut() === true) {
                return $this->getDoctrine()->getRepository('DAKernelBundle:Groupes')->findBy(array('typegroupe' => $tg->getId()));
            }
        }

        return false;
    }

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
        /** @var Etudiants $etu */
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