<?php
/**
 * Created by PhpStorm.
 * User: davidannebicque
 * Date: 06/08/2018
 * Time: 13:23
 */

namespace App\MesClasses;


use App\Entity\Etudiant;
use App\Entity\StageEtudiant;
use App\Entity\StagePeriode;
use App\Repository\EtudiantRepository;
use App\Repository\StageEtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;

class MyStage
{

    /** @var EntityManagerInterface */
    protected $entityManger;

    /** @var StageEtudiantRepository */
    protected $stageEtudiantRepository;

    /** @var EtudiantRepository */
    protected $etudiantRepository;

    protected $dataEtudiants = array();

    protected $propositionsAValider = array();
    protected $conventionAEnvoyer = array();
    protected $conventionEnAttente = array();
    protected $conventionComplete = array();


    /**
     * MyStage constructor.
     *
     * @param EntityManagerInterface  $entityManger
     * @param StageEtudiantRepository $stageEtudiantRepository
     * @param EtudiantRepository      $etudiantRepository
     */
    public function __construct(
        EntityManagerInterface $entityManger,
        StageEtudiantRepository $stageEtudiantRepository,
        EtudiantRepository $etudiantRepository
    ) {
        $this->entityManger = $entityManger;
        $this->stageEtudiantRepository = $stageEtudiantRepository;
        $this->etudiantRepository = $etudiantRepository;
    }


    public function getDataPeriode(StagePeriode $stagePeriode, int $getAnneeUniversitaire)
    {
        $etudiants = $this->etudiantRepository->findBySemestre($stagePeriode->getSemestre());

        /** @var Etudiant $etudiant */
        foreach ($etudiants as $etudiant) {
            $this->dataEtudiants[$etudiant->getId()]['etudiant'] = $etudiant;
        }

        /** @var StageEtudiant $stageEtudiant */
        foreach ($stagePeriode->getStageEtudiants() as $stageEtudiant) {
            if ($stageEtudiant->getEtudiant() !== null) {
                $this->dataEtudiants[$etudiant->getId()]['stage'] = $stageEtudiant;

                switch ($stageEtudiant->getEtatStage()) {
                    case StageEtudiant::ETAT_STAGE_DEPOSE:
                        $this->propositionsAValider[$stageEtudiant->getEtudiant()->getId()] = $stageEtudiant;
                        break;
                    case StageEtudiant::ETAT_STAGE_VALIDE:
                        $this->conventionAEnvoyer[$stageEtudiant->getEtudiant()->getId()] = $stageEtudiant;
                        break;
                    case StageEtudiant::ETAT_STAGE_CONVENTION_ENVOYEE;
                        $this->conventionEnAttente[$stageEtudiant->getEtudiant()->getId()] = $stageEtudiant;
                        break;
                    case StageEtudiant::ETAT_STAGE_CONVENTION_RECUE;
                        $this->conventionComplete[$stageEtudiant->getEtudiant()->getId()] = $stageEtudiant;
                        break;
                }
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getDataEtudiants(): array
    {
        return $this->dataEtudiants;
    }

    /**
     * @return array
     */
    public function getPropositionsAValider(): array
    {
        return $this->propositionsAValider;
    }

    /**
     * @return array
     */
    public function getConventionAEnvoyer(): array
    {
        return $this->conventionAEnvoyer;
    }

    /**
     * @return array
     */
    public function getConventionEnAttente(): array
    {
        return $this->conventionEnAttente;
    }

    /**
     * @return array
     */
    public function getConventionComplete(): array
    {
        return $this->conventionComplete;
    }


}