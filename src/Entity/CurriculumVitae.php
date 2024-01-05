<?php

namespace App\Entity;

use App\Repository\CurriculumVitaeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CurriculumVitaeRepository::class)]
#[Vich\Uploadable]
class CurriculumVitae
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(inversedBy: 'curriculumVitaes', targetEntity: Education::class)]
    private Collection $educations;

    #[ORM\ManyToMany(inversedBy: 'curriculumVitaes', targetEntity: Language::class)]
    private Collection $languages;

    #[ORM\ManyToMany(inversedBy: 'curriculumVitaes', targetEntity: Skill::class)]
    private Collection $skills;

    #[ORM\ManyToMany(inversedBy: 'curriculumVitaes', targetEntity: Links::class)]
    private Collection $links;

    #[ORM\ManyToMany(inversedBy: 'curriculumVitaes', targetEntity: Experience::class)]
    private Collection $experiences;

    #[ORM\OneToOne(mappedBy: 'curriculum', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\Column(nullable: true)]
    private ?string $curriculum = null;

    #[Vich\UploadableField(mapping: 'cv_file', fileNameProperty: 'curriculum')]
    // #[Assert\File(
    //     maxSize: '2M',
    //     mimeTypes: ['file/pdf', 'file/doc', 'file/docx'],
    // )]
    private ?File $cvFile = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DatetimeInterface $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?string $cvFilePath = null;

    public function setCvFilePath(?string $cvFilePath): void
    {
        $this->cvFilePath = $cvFilePath;
    }

    public function getCvFilePath(): ?string
    {
        return $this->cvFilePath;
    }

    public function __construct()
    {
        $this->educations = new ArrayCollection();
        $this->languages = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->links = new ArrayCollection();
        $this->experiences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Education>
     */
    public function getEducations(): Collection
    {
        return $this->educations;
    }

    public function addEducation(Education $education): static
    {
        if (!$this->educations->contains($education)) {
            $this->educations->add($education);
            $education->addCurriculumVitae($this);
        }

        return $this;
    }

    public function removeEducation(Education $education): static
    {
        if ($this->educations->removeElement($education)) {
            // set the owning side to null (unless already changed)
                $education->removeCurriculumVitae($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Language>
     */
    public function getLanguages(): Collection
    {
        return $this->languages;
    }

    public function addLanguage(Language $language): static
    {
        if (!$this->languages->contains($language)) {
            $this->languages->add($language);
            $language->addCurriculumVitae($this);
        }

        return $this;
    }

    public function removeLanguage(Language $language): static
    {
        if ($this->languages->removeElement($language)) {
            // set the owning side to null (unless already changed)
                $language->removeCurriculumVitae($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Skill>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): static
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
            $skill->addCurriculumVitae($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): static
    {
        if ($this->skills->removeElement($skill)) {
            // set the owning side to null (unless already changed)
                $skill->removeCurriculumVitae($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Links>
     */
    public function getLinks(): Collection
    {
        return $this->links;
    }

    public function addLink(Links $link): static
    {
        if (!$this->links->contains($link)) {
            $this->links->add($link);
            $link->addCurriculumVitae($this);
        }

        return $this;
    }

    public function removeLink(Links $link): static
    {
        if ($this->links->removeElement($link)) {
            // set the owning side to null (unless already changed)
                $link->removeCurriculumVitae($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Experience>
     */
    public function getExperiences(): Collection
    {
        return $this->experiences;
    }

    public function addExperience(Experience $experience): static
    {
        if (!$this->experiences->contains($experience)) {
            $this->experiences->add($experience);
            $experience->addCurriculumVitae($this);
        }

        return $this;
    }

    public function removeExperience(Experience $experience): static
    {
        if ($this->experiences->removeElement($experience)) {
            // set the owning side to null (unless already changed)
                $experience->removeCurriculumVitae($this);
        }

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->user;
    }

    public function setUsers(?User $user): static
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setCurriculum(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getCurriculum() !== $this) {
            $user->setCurriculum($this);
        }

        $this->user = $user;
        return $this;
    }

    public function getCurriculum(): ?string
    {
        return $this->curriculum;
    }

    public function setCurriculum(?string $curriculum): void
    {
        $this->curriculum = $curriculum;
    }

    public function setCvFile(?File $cvfile = null): void
    {
        $this->cvFile = $cvfile;
        if (null !== $cvfile) {
            $this->updatedAt = new DateTime('now');
        }
    }

    public function getCvFile(): ?File
    {
        return $this->cvFile;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }
    public function setUpdatedAt(\DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
