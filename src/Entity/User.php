<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('email')]
#[UniqueEntity('username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(name: 'email', type: 'string', length: 255, unique: true)]
    #[Assert\Email]
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(min: 7)]
    private string $email;

    #[ORM\Column(name: 'username', type: 'string', length: 255, unique: true, nullable: true)]
    #[Assert\Type('string')]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    private string $password;

    #[ORM\ManyToMany(targetEntity: StudyClass::class, inversedBy: "users")]
    private PersistentCollection $studyClasses;

    #[ORM\ManyToOne(targetEntity: Role::class, inversedBy: "users")]
    private Role $role;

    public function __construct()
    {
        //$this->studyClasses = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return PersistentCollection|StudyClass[]
     */
    public function getStudyClasses(): PersistentCollection
    {
        return $this->studyClasses;
    }

    public function addStudyClass(StudyClass $studyClass): self
    {
        if (!$this->studyClasses->contains($studyClass)) {
            $this->studyClasses[] = $studyClass;
        }
        return $this;
    }

    public function removeStudyClass(StudyClass $studyClass): self
    {
        $this->studyClasses->removeElement($studyClass);
        return $this;
    }

    // interface methods
    public function getUserIdentifier(): string
    {
        return $this->email ?? $this->username;
    }

    public function eraseCredentials(): void {}
    public function getRoles(): array { return []; }

    public function setRole(Role $role): self
    {
        $this->role = $role;
        return $this;
    }
}