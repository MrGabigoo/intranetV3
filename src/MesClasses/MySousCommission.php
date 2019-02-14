<?php
/**
 * Created by PhpStorm.
 * User: davidannebicque
 * Date: 24/12/2018
 * Time: 14:41
 */

namespace App\MesClasses;

use App\Entity\Etudiant;
use App\Entity\Matiere;
use App\Entity\Semestre;
use App\Entity\Ue;
use App\Repository\EtudiantRepository;
use App\Repository\MatiereRepository;
use App\Repository\NoteRepository;
use App\Repository\SemestreRepository;
use App\Repository\UeRepository;

/**
 * @property \App\Entity\Ue[] ues
 */
class MySousCommission
{

    /** @var EtudiantRepository */
    private $etudiantRepository;

    /** @var MatiereRepository */
    private $matiereRepository;

    /** @var UeRepository */
    private $ueRepository;

    /** @var SemestreRepository */
    private $semestreRepository;

    /** @var NoteRepository */
    private $noteRepository;

    /** @var Etudiant[] */
    private $etudiants = [];

    /** @var Ue[] */
    private $ues = [];

    /** @var Matiere[] */
    private $matieres = [];

    /** @var Semestre[] */
    private $semestres = [];

    /** @var Semestre */
    private $semestre;

    /** @var MyEtudiantSousCommission[] */
    private $sousCommissionEtudiants = [];

    /**
     * SousComissionController constructor.
     *
     * @param EtudiantRepository $etudiantRepository
     * @param MatiereRepository  $matiereRepository
     * @param SemestreRepository $semestreRepository
     * @param UeRepository       $ueRepository
     * @param NoteRepository     $noteRepository
     */
    public function __construct(
        EtudiantRepository $etudiantRepository,
        MatiereRepository $matiereRepository,
        SemestreRepository $semestreRepository,
        UeRepository $ueRepository,
        NoteRepository $noteRepository
    ) {
        $this->etudiantRepository = $etudiantRepository;
        $this->matiereRepository = $matiereRepository;
        $this->ueRepository = $ueRepository;
        $this->semestreRepository = $semestreRepository;
        $this->noteRepository = $noteRepository;
    }

    /**
     * @param Semestre $semestre
     * @param          $annee
     */
    public function init(Semestre $semestre, $annee)
    {
        //récupérer les notes du semestre.
        //faire un tableau etudiant/matieres/notes
        $this->semestre = $semestre;
        $this->etudiants = $this->etudiantRepository->findBySemestre($semestre);
        $this->matieres = $this->matiereRepository->findBySemestre($semestre);
        $this->ues = $this->ueRepository->findBySemestre($semestre);
        $this->semestres = $this->semestreRepository->findByDiplome($semestre->getDiplome());
        $notes = $this->noteRepository->findNotesByEtudiantsSemestre($semestre, $annee, $this->etudiants);

        foreach ($this->etudiants as $etudiant) {
            $etuId = $etudiant->getId();
            $this->sousCommissionEtudiants[$etuId] = new MyEtudiantSousCommission($etudiant, $semestre, $this->matieres, $notes[$etuId]);
        }
    }

    /**
     * @return Ue[]
     */
    public function getUes(): array
    {
        return $this->ues;
    }

    /**
     * @return Etudiant[]
     */
    public function getEtudiants(): array
    {
        return $this->etudiants;
    }

    /**
     * @return Matiere[]
     */
    public function getMatieres(): array
    {
        return $this->matieres;
    }

    /**
     * @return Semestre[]
     */
    public function getSemestres(): array
    {
        return $this->semestres;
    }

    /**
     * @return MyEtudiantSousCommission[]
     */
    public function getSousCommissionEtudiants(): array
    {
        return $this->sousCommissionEtudiants;
    }




}