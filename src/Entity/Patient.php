<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $gender = null;

    #[ORM\Column(length: 255)]
    private ?string $age = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $markingNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $passportNumber = null;

    #[ORM\Column(type: 'text')]
    private ?string $appearance = null;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'patients')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\ManyToMany(targetEntity: Drug::class, mappedBy: 'patients')]
    private Collection $drugs;

    #[ORM\OneToMany(targetEntity: PatientExamination::class, mappedBy: 'patient')]
    private Collection $patientExaminations;

    public function __construct()
    {
        $this->drugs = new ArrayCollection();
        $this->patientExaminations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;
        return $this;
    }

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(string $age): self
    {
        $this->age = $age;
        return $this;
    }

    public function getMarkingNumber(): ?string
    {
        return $this->markingNumber;
    }

    public function setMarkingNumber(?string $markingNumber): self
    {
        $this->markingNumber = $markingNumber;
        return $this;
    }

    public function getPassportNumber(): ?string
    {
        return $this->passportNumber;
    }

    public function setPassportNumber(?string $passportNumber): self
    {
        $this->passportNumber = $passportNumber;
        return $this;
    }

    public function getAppearance(): ?string
    {
        return $this->appearance;
    }

    public function setAppearance(string $appearance): self
    {
        $this->appearance = $appearance;
        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;
        return $this;
    }

    public function getDrugs(): Collection
    {
        return $this->drugs;
    }

    public function addDrug(Drug $drug): self
    {
        if (!$this->drugs->contains($drug)) {
            $this->drugs->add($drug);
            $drug->addPatient($this);
        }
        return $this;
    }

    public function removeDrug(Drug $drug): self
    {
        if ($this->drugs->removeElement($drug)) {
            $drug->removePatient($this);
        }
        return $this;
    }

    public function getPatientExaminations(): Collection
    {
        return $this->patientExaminations;
    }

    public function addPatientExamination(PatientExamination $patientExamination): self
    {
        if (!$this->patientExaminations->contains($patientExamination)) {
            $this->patientExaminations->add($patientExamination);
            $patientExamination->setPatient($this);
        }
        return $this;
    }

    public function removePatientExamination(PatientExamination $patientExamination): self
    {
        if ($this->patientExaminations->removeElement($patientExamination)) {
            if ($patientExamination->getPatient() === $this) {
                $patientExamination->setPatient(null);
            }
        }
        return $this;
    }
}
