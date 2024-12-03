<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Examination
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $shortcut = null;

    #[ORM\Column(length: 255)]
    private ?string $examinationName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $norms = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $machine = null;

    #[ORM\OneToMany(targetEntity: PatientExamination::class, mappedBy: 'examination')]
    private Collection $patientExaminations;

    public function __construct()
    {
        $this->patientExaminations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShortcut(): ?string
    {
        return $this->shortcut;
    }

    public function setShortcut(string $shortcut): self
    {
        $this->shortcut = $shortcut;
        return $this;
    }

    public function getExaminationName(): ?string
    {
        return $this->examinationName;
    }

    public function setExaminationName(string $examinationName): self
    {
        $this->examinationName = $examinationName;
        return $this;
    }

    public function getNorms(): ?string
    {
        return $this->norms;
    }

    public function setNorms(?string $norms): self
    {
        $this->norms = $norms;
        return $this;
    }

    public function getMachine(): ?string
    {
        return $this->machine;
    }

    public function setMachine(?string $machine): self
    {
        $this->machine = $machine;
        return $this;
    }

    public function getPatientExaminations(): Collection
    {
        return $this->patientExaminations;
    }
}
