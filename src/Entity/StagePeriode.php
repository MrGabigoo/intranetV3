<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StagePeriodeRepository")
 * @Vich\Uploadable
 */
class StagePeriode extends BaseEntity
{

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     */
    private $documentName;

    /**
     * @var UploadedFile
     *
     * @Vich\UploadableField(mapping="ficheRenseignement", fileNameProperty="documentName")
     */
    private $documentFile;

    /**
     * @ORM\Column(type="integer")
     */
    private $numeroPeriode;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $libelle;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbSemaines;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbJours;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFin;

    /**
     * @ORM\Column(type="text")
     */
    private $competencesVisees;

    /**
     * @ORM\Column(type="text")
     */
    private $modaliteEvaluation;

    /**
     * @ORM\Column(type="text")
     */
    private $modaliteEvaluationPedagogique;

    /**
     * @ORM\Column(type="text")
     */
    private $modaliteEncadrement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $documentRendre;

    /**
     * @ORM\Column(type="float")
     */
    private $nbEcts;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Semestre", inversedBy="stagePeriodes")
     */
    private $semestre;

    /**
     * @ORM\Column(type="boolean")
     */
    private $datesFlexibles;

    /**
     * @ORM\Column(type="boolean")
     */
    private $copieAssistant;

    /**
     * @ORM\OneToMany(targetEntity="StagePeriodeInterruption", mappedBy="stagePeriode")
     */
    private $stagePeriodeInterruptions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StagePeriodeSoutenance", mappedBy="stagePeriode")
     */
    private $stagePeriodeSoutenances;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Personnel", inversedBy="stagePeriodes")
     */
    private $responsables;

    /**
     * @var \Ramsey\Uuid\UuidInterface
     *
     * @ORM\Column(type="uuid_binary", unique=true)
     */
    protected $uuid;

    /**
     * @ORM\Column(type="integer")
     */
    private $anneeUniversitaire;

    /**
     * @ORM\Column(type="text")
     */
    private $texteLibre;

    /**
     * @return \Ramsey\Uuid\UuidInterface
     */
    public function getUuid(): \Ramsey\Uuid\UuidInterface
    {
        return $this->uuid;
    }

    /**
     * @return \Ramsey\Uuid\UuidInterface
     */
    public function getUuidString(): string
    {
        return $this->getUuid()->toString();
    }

    /**
     * StagePeriode constructor.
     * @throws \Exception
     */
    public function __construct($anneeUniversitaire)
    {
        $this->stagePeriodeInterruptions = new ArrayCollection();
        $this->stagePeriodeSoutenances = new ArrayCollection();
        $this->responsables = new ArrayCollection();
        $this->uuid = Uuid::uuid4();
        $this->setAnneeUniversitaire($anneeUniversitaire);
    }

    public function getNumeroPeriode(): ?int
    {
        return $this->numeroPeriode;
    }

    public function setNumeroPeriode(int $numeroPeriode): self
    {
        $this->numeroPeriode = $numeroPeriode;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getNbSemaines(): ?int
    {
        return $this->nbSemaines;
    }

    public function setNbSemaines(int $nbSemaines): self
    {
        $this->nbSemaines = $nbSemaines;

        return $this;
    }

    public function getNbJours(): ?int
    {
        return $this->nbJours;
    }

    public function setNbJours(int $nbJours): self
    {
        $this->nbJours = $nbJours;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getCompetencesVisees(): ?string
    {
        return $this->competencesVisees;
    }

    public function setCompetencesVisees(string $competencesVisees): self
    {
        $this->competencesVisees = $competencesVisees;

        return $this;
    }

    public function getModaliteEvaluation(): ?string
    {
        return $this->modaliteEvaluation;
    }

    public function setModaliteEvaluation(string $modaliteEvaluation): self
    {
        $this->modaliteEvaluation = $modaliteEvaluation;

        return $this;
    }

    public function getModaliteEvaluationPedagogique(): ?string
    {
        return $this->modaliteEvaluationPedagogique;
    }

    public function setModaliteEvaluationPedagogique(string $modaliteEvaluationPedagogique): self
    {
        $this->modaliteEvaluationPedagogique = $modaliteEvaluationPedagogique;

        return $this;
    }

    public function getModaliteEncadrement(): ?string
    {
        return $this->modaliteEncadrement;
    }

    public function setModaliteEncadrement(string $modaliteEncadrement): self
    {
        $this->modaliteEncadrement = $modaliteEncadrement;

        return $this;
    }

    public function getDocumentRendre(): ?string
    {
        return $this->documentRendre;
    }

    public function setDocumentRendre(string $documentRendre): self
    {
        $this->documentRendre = $documentRendre;

        return $this;
    }

    public function getNbEcts(): ?float
    {
        return $this->nbEcts;
    }

    public function setNbEcts(float $nbEcts): self
    {
        $this->nbEcts = $nbEcts;

        return $this;
    }

    public function getSemestre(): ?Semestre
    {
        return $this->semestre;
    }

    public function setSemestre(?Semestre $semestre): self
    {
        $this->semestre = $semestre;

        return $this;
    }

    public function getDatesFlexibles(): ?bool
    {
        return $this->datesFlexibles;
    }

    public function setDatesFlexibles(bool $datesFlexibles): self
    {
        $this->datesFlexibles = $datesFlexibles;

        return $this;
    }

    public function getCopieAssistant(): ?bool
    {
        return $this->copieAssistant;
    }

    public function setCopieAssistant(bool $copieAssistant): self
    {
        $this->copieAssistant = $copieAssistant;

        return $this;
    }

    /**
     * @return Collection|StagePeriodeInterruption[]
     */
    public function getStagePeriodeInterruptions(): Collection
    {
        return $this->stagePeriodeInterruptions;
    }

    public function addPeriodeInterruptionStage(StagePeriodeInterruption $periodeInterruptionStage): self
    {
        if (!$this->stagePeriodeInterruptions->contains($periodeInterruptionStage)) {
            $this->stagePeriodeInterruptions[] = $periodeInterruptionStage;
            $periodeInterruptionStage->setStagePeriode($this);
        }

        return $this;
    }

    public function removePeriodeInterruptionStage(StagePeriodeInterruption $periodeInterruptionStage): self
    {
        if ($this->stagePeriodeInterruptions->contains($periodeInterruptionStage)) {
            $this->stagePeriodeInterruptions->removeElement($periodeInterruptionStage);
            // set the owning side to null (unless already changed)
            if ($periodeInterruptionStage->getStagePeriode() === $this) {
                $periodeInterruptionStage->setStagePeriode(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|StagePeriodeSoutenance[]
     */
    public function getStagePeriodeSoutenances(): Collection
    {
        return $this->stagePeriodeSoutenances;
    }

    public function addStagePeriodeSoutenance(StagePeriodeSoutenance $stagePeriodeSoutenance): self
    {
        if (!$this->stagePeriodeSoutenances->contains($stagePeriodeSoutenance)) {
            $this->stagePeriodeSoutenances[] = $stagePeriodeSoutenance;
            $stagePeriodeSoutenance->setStagePeriode($this);
        }

        return $this;
    }

    public function removeStagePeriodeSoutenance(StagePeriodeSoutenance $stagePeriodeSoutenance): self
    {
        if ($this->stagePeriodeSoutenances->contains($stagePeriodeSoutenance)) {
            $this->stagePeriodeSoutenances->removeElement($stagePeriodeSoutenance);
            // set the owning side to null (unless already changed)
            if ($stagePeriodeSoutenance->getStagePeriode() === $this) {
                $stagePeriodeSoutenance->setStagePeriode(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Personnel[]
     */
    public function getResponsables(): Collection
    {
        return $this->responsables;
    }

    public function addResponsable(Personnel $responsable): self
    {
        if (!$this->responsables->contains($responsable)) {
            $this->responsables[] = $responsable;
        }

        return $this;
    }

    public function removeResponsable(Personnel $responsable): self
    {
        if ($this->responsables->contains($responsable)) {
            $this->responsables->removeElement($responsable);
        }

        return $this;
    }

    public function getAnneeUniversitaire(): ?int
    {
        return $this->anneeUniversitaire;
    }

    public function setAnneeUniversitaire(?int $anneeUniversitaire): self
    {
        $this->anneeUniversitaire = $anneeUniversitaire;

        return $this;
    }

    public function getTexteLibre(): ?string
    {
        return $this->texteLibre;
    }

    public function setTexteLibre(string $texteLibre): self
    {
        $this->texteLibre = $texteLibre;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $document
     */
    public function setDocumentFile(?File $document = null): void
    {
        $this->documentFile = $document;

        if (null !== $document) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdated(new \DateTime());
        }
    }

    /**
     * @return null|File
     */
    public function getDocumentFile(): ?File
    {
        return $this->documentFile;
    }

    /**
     * @return string
     */
    public function getDocumentName(): ?string
    {
        return $this->documentName;
    }

    /**
     * @param string $documentName
     */
    public function setDocumentName(string $documentName): void
    {
        $this->documentName = $documentName;
    }
}
