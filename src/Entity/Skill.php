<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill
{
    public const LEVELS = [
        1 => 'Débutant',
        2 => 'Intermédiaire',
        3 => 'Confirmé',
        4 => 'Expert'
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $level = null;

    #[ORM\ManyToMany(targetEntity: CurriculumVitae::class, mappedBy: 'skills')]
    private Collection $curriculumVitaes;

    public function __construct()
    {
        $this->curriculumVitaes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        if (!array_key_exists($level, self::LEVELS)) {
            return $this;
        }

        $this->level = $level;

        return $this;
    }

    public function getCurriculumVitaes(): Collection
    {
        return $this->curriculumVitaes;
    }

    public function setCurriculumVitaes(Collection $curriculumVitaes): static
    {
        $this->curriculumVitaes = $curriculumVitaes;

        return $this;
    }

    public function addCurriculumVitae(CurriculumVitae $curriculumVitae): static
    {
        if (!$this->curriculumVitaes->contains($curriculumVitae)) {
            $this->curriculumVitaes->add($curriculumVitae);
        }

        return $this;
    }

    public function removeCurriculumVitae(CurriculumVitae $curriculumVitae): static
    {
        $this->curriculumVitaes->removeElement($curriculumVitae);
        return $this;
    }
}
