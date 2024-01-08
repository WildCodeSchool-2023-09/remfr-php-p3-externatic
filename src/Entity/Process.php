<?php

namespace App\Entity;

use App\Repository\ProcessRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProcessRepository::class)]
class Process
{
    public const PROCESS = [
        1 => 'En cours',
        2 => 'Terminé',
    ];

    public const STATUT = [
        1 => 'Candidature envoyée',
        2 => 'Candidature récéptionnée',
        3 => 'Candidature en cours d\'examen',
        4 => 'Entretien en cours',
        5 => 'Candidat retenu pour le poste',
        6 => 'Candidat non retenu pour le poste',
        7 => 'Réponse reçue',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $process = null;

    #[ORM\Column]
    private ?int $statut = null;
    #[ORM\ManyToOne(inversedBy: 'process')]
    private ?Offer $offer = null;
    #[ORM\ManyToOne(inversedBy: 'process')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'processes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $collaborateur = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this-> id;
    }

    public function getProcess(): ?int
    {
        return $this-> process;
    }

    public function setProcess(int $process): static
    {
        if (!array_key_exists($process, self::PROCESS)) {
            return $this;
        }
        $this->process = $process;

        return $this;
    }

    public function getStatut(): ?int
    {
        return $this-> statut;
    }

    public function setStatut(int $statut): static
    {
        if (!array_key_exists($statut, self::STATUT)) {
            return $this;
        }
        $this-> statut = $statut;

        return $this;
    }

    public function getOffer(): ?Offer
    {
        return $this->offer;
    }

    public function setOffer(?Offer $offer): static
    {
        $this->offer = $offer;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getCollaborateur(): ?User
    {
        return $this->collaborateur;
    }

    public function setCollaborateur(?User $collaborateur): static
    {
        $this->collaborateur = $collaborateur;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getProcessName(): string
    {
        if (array_key_exists($this->process, self::PROCESS)) {
            return self::PROCESS[$this->process];
        }

        return "Non défini";
    }

    public function getStatutName(): string
    {
        if (array_key_exists($this->statut, self::STATUT)) {
            return self::STATUT[$this->statut];
        }

        return "Non défini";
    }
}
