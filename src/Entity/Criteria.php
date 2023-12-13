<?php

namespace App\Entity;

use App\Repository\CriteriaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CriteriaRepository::class)]
class Criteria
{
    public const CONTRACT_TYPE = [
        1 => 'CDI',
        2 => 'CDD',
        3 => 'Intérim',
        4 => 'Freelance',
        5 => 'Stage',
        6 => 'Alternance',
        7 => 'Bénévolat',
    ];

    public const REMOTE_CONDITIONS = [
        0 => 'No Remote',
        1 => '1j remote',
        2 => '2j remote',
        3 => '3j remote',
        4 => '4j remote',
        5 => 'Full Remote',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $salary = null;

    #[ORM\Column(length: 255)]
    private ?string $profil = null;

    #[ORM\Column]
    private ?int $contract = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\Column]
    private ?int $remote = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSalary(): ?string
    {
        return $this->salary;
    }

    public function setSalary(string $salary): static
    {
        $this->salary = $salary;

        return $this;
    }

    public function getProfil(): ?string
    {
        return $this->profil;
    }

    public function setProfil(string $profil): static
    {
        $this->profil = $profil;

        return $this;
    }

    public function getContract(): ?int
    {
        return $this->contract;
    }

    public function setContract(int $contract): static
    {
        if (!array_key_exists($contract, self::CONTRACT_TYPE)) {
            return $this;
        }

        $this->contract = $contract;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getRemote(): ?int
    {
        return $this->remote;
    }

    public function setRemote(int $remote): static
    {
        if (!array_key_exists($remote, self::REMOTE_CONDITIONS)) {
            return $this;
        }

        $this->remote = $remote;

        return $this;
    }
}
