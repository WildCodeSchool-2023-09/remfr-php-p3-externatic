<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Merci de saisir votre prénom')]
    #[Assert\Length(max: 255)]
    private ?string $firstname = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Merci de saisir votre nom')]
    #[Assert\Length(max: 255)]
    private ?string $lastname = null;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank(message: 'Merci de saisir votre email')]
    #[Assert\Length(max: 50)]
    private ?string $email = null;

    #[ORM\Column(nullable: true)]
    private ?int $phone = null;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank(message: 'Merci de saisir votre mot de passe')]
    #[Assert\Length(max: 50)]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(nullable: true)]
    private ?int $zipcode = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(length: 50)]
    private ?string $rule = null;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank(message: 'Merci de sélectionner votre préférence de contact')]
    private ?string $contactPreference = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthdate = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $nationality = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $maritalStatus = null;
    #[ORM\ManyToMany(targetEntity: Offer::class, inversedBy: 'users')]
    private Collection $offer;
    #[ORM\OneToMany(mappedBy: 'users', targetEntity: Process::class)]
    private Collection $process;
    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Contact $contact = null;
    #[ORM\OneToOne(inversedBy: 'users', cascade: ['persist', 'remove'])]
    private ?CurriculumVitae $CV = null;
    #[ORM\ManyToMany(targetEntity: Criteria::class, inversedBy: 'users')]
    private Collection $criteria;
    public function __construct()
    {
        $this->offer = new ArrayCollection();
        $this->process = new ArrayCollection();
        $this->criteria = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(?int $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getZipcode(): ?int
    {
        return $this->zipcode;
    }

    public function setZipcode(?int $zipcode): static
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getRule(): ?string
    {
        return $this->rule;
    }

    public function setRule(string $rule): static
    {
        $this->rule = $rule;

        return $this;
    }

    public function getContactPreference(): ?string
    {
        return $this->contactPreference;
    }

    public function setContactPreference(string $contactPreference): static
    {
        $this->contactPreference = $contactPreference;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeInterface $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(?string $nationality): static
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getMaritalStatus(): ?string
    {
        return $this->maritalStatus;
    }

    public function setMaritalStatus(?string $maritalStatus): static
    {
        $this->maritalStatus = $maritalStatus;

        return $this;
    }

    /**
     * @return Collection<int, Offer>
     */
    public function getOffer(): Collection
    {
        return $this->offer;
    }

    public function addOffer(Offer $offer): static
    {
        if (!$this->offer->contains($offer)) {
            $this->offer->add($offer);
        }

        return $this;
    }

    public function removeOffer(Offer $offer): static
    {
        $this->offer->removeElement($offer);
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
            $process->setUsers($this);
        }

        return $this;
    }

    public function removeProcess(Process $process): static
    {
        if ($this->process->removeElement($process)) {
// set the owning side to null (unless already changed)
            if ($process->getUsers() === $this) {
                $process->setUsers(null);
            }
        }

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): static
    {
        $this->contact = $contact;
        return $this;
    }

    public function getCV(): ?CurriculumVitae
    {
        return $this->CV;
    }

    public function setCV(?CurriculumVitae $CV): static
    {
        $this->CV = $CV;
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
}
