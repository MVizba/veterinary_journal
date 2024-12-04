<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Drug
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $dateOfReceipt = null;

    #[ORM\Column(length: 255)]
    private ?string $documentName = null;

    #[ORM\Column]
    private ?int $amount = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $manufactureDate = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $expirationDate = null;

    #[ORM\Column(length: 255)]
    private ?string $series = null;

    #[ORM\Column(length: 255)]
    private ?string $whereObtainedFrom = null;

    #[ORM\ManyToMany(targetEntity: Patient::class, inversedBy: 'drugs')]
    private Collection $patients;

    public function __construct()
    {
        $this->patients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateOfReceipt(): ?\DateTimeInterface
    {
        return $this->dateOfReceipt;
    }

    public function setDateOfReceipt(\DateTimeInterface $dateOfReceipt): static
    {
        $this->dateOfReceipt = $dateOfReceipt;
        return $this;
    }

    public function getDocumentName(): ?string
    {
        return $this->documentName;
    }

    public function setDocumentName(string $documentName): static
    {
        $this->documentName = $documentName;
        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): static
    {
        $this->amount = $amount;
        return $this;
    }

    public function getManufactureDate(): ?\DateTimeInterface
    {
        return $this->manufactureDate;
    }

    public function setManufactureDate(\DateTimeInterface $manufactureDate): static
    {
        $this->manufactureDate = $manufactureDate;
        return $this;
    }

    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(\DateTimeInterface $expirationDate): static
    {
        $this->expirationDate = $expirationDate;
        return $this;
    }

    public function getSeries(): ?string
    {
        return $this->series;
    }

    public function setSeries(string $series): static
    {
        $this->series = $series;
        return $this;
    }

    public function getWhereObtainedFrom(): ?string
    {
        return $this->whereObtainedFrom;
    }

    public function setWhereObtainedFrom(string $whereObtainedFrom): static
    {
        $this->whereObtainedFrom = $whereObtainedFrom;
        return $this;
    }

    public function getPatients(): Collection
    {
        return $this->patients;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function addPatient(Patient $patient): static
    {
        if (!$this->patients->contains($patient)) {
            $this->patients->add($patient);
            $patient->addDrug($this);
        }
        return $this;
    }

    public function removePatient(Patient $patient): static
    {
        if ($this->patients->removeElement($patient)) {
            $patient->removeDrug($this);
        }
        return $this;
    }
}
