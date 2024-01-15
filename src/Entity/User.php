<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface, \Serializable
{
    public const MARITAL_STATUS = [
        1 => 'Célibataire',
        2 => 'En Concubinage',
        3 => 'union libre',
        4 => 'PACS',
        5 => 'marié(e)',
        6 => 'Veuf(ve)',
        7 => 'Divorcé(e)',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'Merci de saisir votre email')]
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Merci de saisir votre prénom')]
    #[Assert\Length(max: 255)]
    private ?string $firstname = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Merci de saisir votre nom')]
    #[Assert\Length(max: 255)]
    private ?string $lastname = null;

    #[ORM\Column(nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(nullable: true)]
    private ?string $zipcode = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank(message: 'Merci de sélectionner votre préférence de contact')]
    private ?string $contactPreference = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthdate = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $nationality = null;

    #[ORM\Column(nullable: true)]
    private ?int $maritalStatus = null;

    #[ORM\ManyToMany(targetEntity: Offer::class, inversedBy: 'user')]
    private Collection $offer;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Process::class, cascade: ['remove'])]
    #[ORM\JoinColumn(onDelete:"CASCADE")]
    private Collection $process;

    #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
    private ?CurriculumVitae $curriculum = null;

    #[ORM\ManyToMany(targetEntity: Criteria::class, inversedBy: 'user')]
    private Collection $criteria;

    #[ORM\ManyToMany(targetEntity: Contact::class, inversedBy: 'user')]
    private ?Collection $contacts;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: 'boolean')]
    private bool $isVerified = false;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?AdditionalInfo $additionalInfo = null;

    #[ORM\OneToMany(mappedBy: 'collaborateur', targetEntity: Process::class)]
    private Collection $processes;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'candidates')]
    private ?self $collaborateur = null;

    #[ORM\OneToMany(mappedBy: 'collaborateur', targetEntity: self::class)]
    private Collection $candidates;

    #[ORM\ManyToMany(targetEntity: Offer::class, inversedBy: 'Favorited')]
    #[ORM\JoinTable(name: 'user_favorites')]
    private Collection $favorites;

    public function __construct()
    {
        $this->offer = new ArrayCollection();
        $this->process = new ArrayCollection();
        $this->criteria = new ArrayCollection();
        $this->processes = new ArrayCollection();
        $this->candidates = new ArrayCollection();
        $this->favorites = new ArrayCollection();
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function addRole(string $role): static
    {
        if (!(in_array($role, $this->roles))) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function removeRole(string $role): static
    {
        if (in_array($role, $this->roles)) {
            $roleArray = [];
            foreach ($this->roles as $newRole) {
                if ($newRole != $role) {
                    $roleArray[] = $newRole;
                }
            }
            $this->roles = $roleArray;
        }
        return $this;
    }

    public function hasRole(string $role): bool
    {
        return in_array($role, $this->roles);
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(?string $zipcode): static
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

    public function getMaritalStatus(): ?int
    {
        return $this->maritalStatus;
    }

    public function getMaritalStatusName(): string
    {
        $value = "Inconnu";

        if (!is_null($this->maritalStatus)) {
            $value = self::MARITAL_STATUS[$this->maritalStatus];
        }

        return $value;
    }

    public function setMaritalStatus(?int $maritalStatus): static
    {
        if (array_key_exists($maritalStatus, self::MARITAL_STATUS)) {
            $this->maritalStatus = $maritalStatus;
        }
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
            $process->setUser($this);
        }

        return $this;
    }

    public function removeProcess(Process $process): static
    {
        if ($this->process->removeElement($process)) {
// set the owning side to null (unless already changed)
            if ($process->getUser() === $this) {
                $process->setUser(null);
            }
        }

        return $this;
    }


    public function getCurriculum(): ?CurriculumVitae
    {
        return $this->curriculum;
    }

    public function setCurriculum(?CurriculumVitae $curriculum): static
    {
        $this->curriculum = $curriculum;
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

    public function setContacts(Collection $contacts): User
    {
        $this->contacts = $contacts;

        return $this;
    }

    public function addContact(Contact $contact): static
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
        }

        return $this;
    }

    public function removeContact(Contact $contact): static
    {
        $this->contacts->removeElement($contact);
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getAdditionalInfo(): ?AdditionalInfo
    {
        return $this->additionalInfo;
    }

    public function setAdditionalInfo(?AdditionalInfo $additionalInfo): static
    {
        $this->additionalInfo = $additionalInfo;

        return $this;
    }


        /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
        ));
    }

        /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password,
        ) = unserialize($serialized);
    }

    /**
     * @return Collection<int, Process>
     */
    public function getProcesses(): Collection
    {
        return $this->processes;
    }

    public function getFullname(): string
    {
        return $this->firstname . " " . $this->lastname;
    }

    public function getCollaborateur(): ?self
    {
        return $this->collaborateur;
    }

    public function setCollaborateur(?self $collaborateur): static
    {
        $this->collaborateur = $collaborateur;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getCandidates(): Collection
    {
        return $this->candidates;
    }

    public function addCandidate(self $candidate): static
    {
        if (!$this->candidates->contains($candidate)) {
            $this->candidates->add($candidate);
            $candidate->setCollaborateur($this);
        }

        return $this;
    }

    public function removeCandidate(self $candidate): static
    {
        if ($this->candidates->removeElement($candidate)) {
            // set the owning side to null (unless already changed)
            if ($candidate->getCollaborateur() === $this) {
                $candidate->setCollaborateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Offer>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Offer $favorite): static
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites->add($favorite);
        }

        return $this;
    }

    public function removeFavorite(Offer $favorite): static
    {
        $this->favorites->removeElement($favorite);

        return $this;
    }

    public function getRolesName(): ?string
    {
        $rolesName = 'ROLE_USER';
        foreach ($this->roles as $role) {
            $rolesName .= ', ' . $role;
        }
        return $rolesName;
    }
}
