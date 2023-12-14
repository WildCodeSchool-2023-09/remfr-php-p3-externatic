<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LanguageRepository::class)]
class Language
{
    public const LEVELS = [
        1 => 'A1',
        2 => 'A2',
        3 => 'B1',
        4 => 'B2',
        5 => 'C1',
        6 => 'C2',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $language = null;

    #[ORM\Column]
    private ?int $level = null;

    #[ORM\ManyToOne(inversedBy: 'Languages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CurriculumVitae $curriculumVitae = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): static
    {
        $this->language = $language;

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

    public function getCurriculumVitae(): ?CurriculumVitae
    {
        return $this->curriculumVitae;
    }

    public function setCurriculumVitae(?CurriculumVitae $curriculumVitae): static
    {
        $this->curriculumVitae = $curriculumVitae;

        return $this;
    }
}
