<?php

namespace App\Entity;

use App\Entity\Criteria;
use App\Repository\OfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OfferRepository::class)]
class Offer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $assignment = null;

    #[ORM\Column(length: 255)]
    private ?string $collaborator = null;

    #[ORM\ManyToOne(inversedBy: 'offers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'offer')]
    private Collection $user;

    #[ORM\OneToMany(mappedBy: 'offer', targetEntity: Process::class)]
    private Collection $process;

    #[ORM\ManyToMany(targetEntity: Criteria::class, inversedBy: 'offers')]
    private Collection $criteria;

    #[ORM\Column]
    private ?int $minSalary = null;

    #[ORM\Column]
    private ?int $maxSalary = null;

    #[ORM\Column]
    private ?int $contractType = null;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->process = new ArrayCollection();
        $this->criteria = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAssignment(): ?string
    {
        return $this->assignment;
    }

    public function setAssignment(string $assignment): static
    {
        $this->assignment = $assignment;

        return $this;
    }

    public function getCollaborator(): ?string
    {
        return $this->collaborator;
    }

    public function setCollaborator(string $collaborator): static
    {
        $this->collaborator = $collaborator;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
            $user->addOffer($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->user->removeElement($user)) {
            $user->removeOffer($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Process>
     */
    public function getProcess(): Collection
    {
        return $this->process;
    }

    public function addProcess(Process $process): static
    {
        if (!$this->process->contains($process)) {
            $this->process->add($process);
            $process->setOffer($this);
        }

        return $this;
    }

    public function removeProcess(Process $process): static
    {
        if ($this->process->removeElement($process)) {
            // set the owning side to null (unless already changed)
            if ($process->getOffer() === $this) {
                $process->setOffer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Criteria>
     */
    public function getCriteria(): Collection
    {
        return $this->criteria;
    }

    public function addCriterion(Criteria $criterion): static
    {
        if (!$this->criteria->contains($criterion)) {
            $this->criteria->add($criterion);
        }

        return $this;
    }

    public function removeCriterion(Criteria $criterion): static
    {
        $this->criteria->removeElement($criterion);

        return $this;
    }

    public function getMinSalary(): ?int
    {
        return $this->minSalary;
    }

    public function setMinSalary(int $minSalary): static
    {
        $this->minSalary = $minSalary;

        return $this;
    }

    public function getMaxSalary(): ?int
    {
        return $this->maxSalary;
    }

    public function setMaxSalary(int $maxSalary): static
    {
        $this->maxSalary = $maxSalary;

        return $this;
    }

    public function getContractType(): ?string
    {
        if (!array_key_exists($this->contractType, Criteria::CONTRACT_TYPE)) {
            return '';
        }

        return Criteria::CONTRACT_TYPE[$this->contractType];
    }

    public function setContractType(int $contractType): static
    {
        if (!array_key_exists($contractType, Criteria::CONTRACT_TYPE)) {
            return $this;
        }

        $this->contractType = $contractType;

        return $this;
    }
}
