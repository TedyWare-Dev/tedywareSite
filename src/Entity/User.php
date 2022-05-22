<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 * fields= {"email"},
 * message= "L'email que vous avez utiliser est deja utilisé !"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Veuillez saisir un email.")
     * @Assert\Email(message="L'email {{ value }} n'est pas disponible.")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez saisir un mot de passe.")
     * @Assert\Length(min="8")
     * @Assert\Regex(pattern="/^(?=.*[a-zà-ÿ])(?=.*[A-ZÀ-Ý])(?=.*[0-9])(?=.*[^a-zà-ÿA-ZÀ-Ý0-9]).{8,}$/", message="Le message doit comporter au moins 8 caractre dont: 1 minuscule, 1 majuscule, 1 chiffre et 1 caractère spécial.")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="Vos mot de passe ne correspondent pas")
     */
    public $confirm_password;

    /**
     * @ORM\ManyToOne(targetEntity=Role::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $role;

    /**
     * @ORM\OneToMany(targetEntity=Project::class, mappedBy="Collaborator")
     */
    private $projects;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebook;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twitter;

    /**
     * @ORM\Column(type="datetime")
     */
    private $registrationDate;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials()
    {
        return '';
    }

    public function getSalt()
    {
        return '';
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getUserIdentifier()
    {
        return $this->getUsername();
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->setCollaborator($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getCollaborator() === $this) {
                $project->setCollaborator(null);
            }
        }

        return $this;
    }



    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(\DateTimeInterface $registrationDate): self
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getUsername();
        return $this->getRegistrationDate();
        return $this->getProjects();
        return $this->getSalt();
        return $this->getUserIdentifier();
    }

}
