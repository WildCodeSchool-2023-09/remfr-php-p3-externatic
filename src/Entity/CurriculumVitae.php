<?php

namespace App\Entity;

use App\Repository\CurriculumVitaeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CurriculumVitaeRepository::class)]
class CurriculumVitae
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $interests = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInterests(): ?string
    {
        return $this->interests;
    }

    public function setInterests(string $interests): static
    {
        $this->interests = $interests;

        return $this;
    }
}
