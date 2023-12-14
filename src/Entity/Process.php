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
}
