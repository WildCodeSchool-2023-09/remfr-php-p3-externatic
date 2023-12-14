<?php

namespace App\Entity;

use App\Repository\UsersRepository;
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
    private $firstname;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Merci de saisir votre nom')]
    #[Assert\Length(max: 255)]
    private $lastname;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank(message: 'Merci de saisir votre email')]
    #[Assert\Length(max: 50)]
    private $email;

    #[ORM\Column(nullable: true)]
    private ?int $phone = null;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank(message: 'Merci de saisir votre mot de passe')]
    #[Assert\Length(max: 50)]
    private $password;

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
    private $contact_preference;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthdate = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $nationality = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $marital_status = null;

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
        return $this->contact_preference;
    }

    public function setContactPreference(string $contact_preference): static
    {
        $this->contact_preference = $contact_preference;

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
        return $this->marital_status;
    }

    public function setMaritalStatus(?string $marital_status): static
    {
        $this->marital_status = $marital_status;

        return $this;
    }
}
