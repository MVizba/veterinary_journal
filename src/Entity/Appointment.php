<?php

namespace App\Entity;

use App\Repository\AppointmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: AppointmentRepository::class)]
class Appointment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Patient $patient = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $registrationDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $symptomDate = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $status = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $diagnosis = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $services = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $endResult = null;

    #[ORM\OneToMany(targetEntity: AppointmentExamination::class, mappedBy: 'appointment', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $examinations;

    #[ORM\OneToMany(targetEntity: AppointmentDrug::class, mappedBy: 'appointment', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $drugs;

    public function __construct()
    {
        $this->examinations = new ArrayCollection();
        $this->drugs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): static
    {
        $this->patient = $patient;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(\DateTimeInterface $registrationDate): static
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    public function getSymptomDate(): ?\DateTimeInterface
    {
        return $this->symptomDate;
    }

    public function setSymptomDate(\DateTimeInterface $symptomDate): static
    {
        $this->symptomDate = $symptomDate;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getDiagnosis(): ?string
    {
        return $this->diagnosis;
    }

    public function setDiagnosis(string $diagnosis): static
    {
        $this->diagnosis = $diagnosis;

        return $this;
    }

    public function getServices(): ?string
    {
        return $this->services;
    }

    public function setServices(string $services): static
    {
        $this->services = $services;

        return $this;
    }

    public function getEndResult(): ?string
    {
        return $this->endResult;
    }

    public function setEndResult(string $endResult): static
    {
        $this->endResult = $endResult;

        return $this;
    }

    public function getExaminations(): Collection
    {
        return $this->examinations;
    }

    public function addExamination(AppointmentExamination $examination): static
    {
        if (!$this->examinations->contains($examination)) {
            $this->examinations->add($examination);
            $examination->setAppointment($this);
        }

        return $this;
    }

    public function removeExamination(AppointmentExamination $examination): static
    {
        if ($this->examinations->removeElement($examination)) {
            if ($examination->getAppointment() === $this) {
                $examination->setAppointment(null);
            }
        }

        return $this;
    }

    public function getDrugs(): Collection
    {
        return $this->drugs;
    }

    public function addDrug(AppointmentDrug $drug): static
    {
        if (!$this->drugs->contains($drug)) {
            $this->drugs->add($drug);
            $drug->setAppointment($this);
        }

        return $this;
    }

    public function removeDrug(AppointmentDrug $drug): static
    {
        if ($this->drugs->removeElement($drug)) {
            if ($drug->getAppointment() === $this) {
                $drug->setAppointment(null);
            }
        }

        return $this;
    }
}
