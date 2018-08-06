<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StageMailTemplateRepository")
 */
class StageMailTemplate
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\StagePeriode", inversedBy="stageMailTemplates")
     */
    private $stagePeriode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $subject;

    /**
     * @ORM\Column(type="text")
     */
    private $template;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $event;

    public function getId()
    {
        return $this->id;
    }

    public function getStagePeriode(): ?StagePeriode
    {
        return $this->stagePeriode;
    }

    public function setStagePeriode(?StagePeriode $stagePeriode): self
    {
        $this->stagePeriode = $stagePeriode;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function setTemplate(string $template): self
    {
        $this->template = $template;

        return $this;
    }

    public function getEvent(): ?string
    {
        return $this->event;
    }

    public function setEvent(string $event): self
    {
        $this->event = $event;

        return $this;
    }
}
