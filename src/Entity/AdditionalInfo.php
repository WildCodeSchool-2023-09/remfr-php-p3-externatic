<?php

namespace App\Entity;

use App\Repository\AdditionalInfoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdditionalInfoRepository::class)]
class AdditionalInfo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthdate = null;

    #[ORM\Column(length: 255)]
    private ?string $nationality = null;

    #[ORM\Column]
    private ?int $gender = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $license = null;

    #[ORM\OneToOne(mappedBy: 'AdditionalInfos', cascade: ['persist', 'remove'])]
    private ?CurriculumVitae $curriculumVitae = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): static
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getGender(): ?int
    {
        return $this->gender;
    }

    public function setGender(int $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getLicense(): ?string
    {
        return $this->license;
    }

    public function setLicense(?string $license): static
    {
        $this->license = $license;

        return $this;
    }

    public function getCurriculumVitae(): ?CurriculumVitae
    {
        return $this->curriculumVitae;
    }

    public function setCurriculumVitae(?CurriculumVitae $curriculumVitae): static
    {
        // unset the owning side of the relation if necessary
        if ($curriculumVitae === null && $this->curriculumVitae !== null) {
            $this->curriculumVitae->setAdditionalInfos(null);
        }

        // set the owning side of the relation if necessary
        if ($curriculumVitae !== null && $curriculumVitae->getAdditionalInfos() !== $this) {
            $curriculumVitae->setAdditionalInfos($this);
        }

        $this->curriculumVitae = $curriculumVitae;

        return $this;
    }
}
