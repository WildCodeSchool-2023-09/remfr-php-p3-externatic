<?php

namespace App\Entity;

use App\Repository\CurriculumVitaeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: 'curriculumVitae', targetEntity: Education::class, orphanRemoval: true)]
    private Collection $educations;

    #[ORM\OneToMany(mappedBy: 'curriculumVitae', targetEntity: Language::class, orphanRemoval: true)]
    private Collection $languages;

    #[ORM\OneToMany(mappedBy: 'curriculumVitae', targetEntity: Skill::class, orphanRemoval: true)]
    private Collection $skills;

    #[ORM\OneToMany(mappedBy: 'curriculumVitae', targetEntity: Links::class, orphanRemoval: true)]
    private Collection $links;

    #[ORM\OneToOne(inversedBy: 'curriculumVitae', cascade: ['persist', 'remove'])]
    private ?AdditionalInfo $additionalInfos = null;

    #[ORM\OneToMany(mappedBy: 'curriculumVitae', targetEntity: Experience::class, orphanRemoval: true)]
    private Collection $experiences;
    #[ORM\OneToOne(mappedBy: 'Curriculum', cascade: ['persist', 'remove'])]
    private ?User $users = null;

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

    public function getInterests(): ?string
    {
        return $this->interests;
    }

    public function setInterests(string $interests): static
    {
        $this->interests = $interests;

        return $this;
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
            $education->setCurriculumVitae($this);
        }

        return $this;
    }

    public function removeEducation(Education $education): static
    {
        if ($this->educations->removeElement($education)) {
            // set the owning side to null (unless already changed)
            if ($education->getCurriculumVitae() === $this) {
                $education->setCurriculumVitae(null);
            }
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
            $language->setCurriculumVitae($this);
        }

        return $this;
    }

    public function removeLanguage(Language $language): static
    {
        if ($this->languages->removeElement($language)) {
            // set the owning side to null (unless already changed)
            if ($language->getCurriculumVitae() === $this) {
                $language->setCurriculumVitae(null);
            }
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
            $skill->setCurriculumVitae($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): static
    {
        if ($this->skills->removeElement($skill)) {
            // set the owning side to null (unless already changed)
            if ($skill->getCurriculumVitae() === $this) {
                $skill->setCurriculumVitae(null);
            }
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
            $link->setCurriculumVitae($this);
        }

        return $this;
    }

    public function removeLink(Links $link): static
    {
        if ($this->links->removeElement($link)) {
            // set the owning side to null (unless already changed)
            if ($link->getCurriculumVitae() === $this) {
                $link->setCurriculumVitae(null);
            }
        }

        return $this;
    }

    public function getAdditionalInfos(): ?AdditionalInfo
    {
        return $this->additionalInfos;
    }

    public function setAdditionalInfos(?AdditionalInfo $additionalInfos): static
    {
        $this->additionalInfos = $additionalInfos;

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
            $experience->setCurriculumVitae($this);
        }

        return $this;
    }

    public function removeExperience(Experience $experience): static
    {
        if ($this->experiences->removeElement($experience)) {
            // set the owning side to null (unless already changed)
            if ($experience->getCurriculumVitae() === $this) {
                $experience->setCurriculumVitae(null);
            }
        }

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): static
    {
        // unset the owning side of the relation if necessary
        if ($users === null && $this->users !== null) {
            $this->users->setCurriculum(null);
        }

        // set the owning side of the relation if necessary
        if ($users !== null && $users->getCurriculum() !== $this) {
            $users->setCurriculum($this);
        }

        $this->users = $users;
        return $this;
    }
}
