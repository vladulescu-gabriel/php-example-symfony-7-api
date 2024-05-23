<?php

namespace App\Entity;

use App\Repository\PermissionRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PermissionRepository::class)]
#[UniqueEntity('name')]
class Permission
{
    const PERMISSION_KEY = 'ACCESS';
    const ACCESS_VIEW_USERS = 'ACCESS_VIEW_USERS';
    const ACCESS_ADD_USER = 'ACCESS_ADD_USER';
    const ACCESS_VIEW_USER = 'ACCESS_VIEW_USER';
    const ACCESS_VIEW_ROLES = 'ACCESS_VIEW_ROLES';
    const ACCESS_VIEW_ROLE = 'ACCESS_VIEW_ROLE';
    const ACCESS_ADD_ROLE = 'ACCESS_ADD_ROLE';
    const ACCESS_CHANGE_ROLE = 'ACCESS_CHANGE_ROLE';
    const ACCESS_VIEW_STUDY_CLASSES = 'ACCESS_VIEW_STUDY_CLASSES';
    const ACCESS_VIEW_STUDY_CLASS = 'ACCESS_VIEW_STUDY_CLASS';
    const ACCESS_ADD_STUDY_CLASS = 'ACCESS_ADD_STUDY_CLASS';
    const ACCESS_ADD_STUDENTS_TO_STUDY_CLASS = 'ACCESS_ADD_STUDENTS_TO_STUDY_CLASS';
    const ACCESS_REMOVE_STUDENTS_FROM_STUDY_CLASS = 'ACCESS_REMOVE_STUDENTS_FROM_STUDY_CLASS';
    const ACCESS_STUDY_CLASS_OWNER = 'ACCESS_STUDY_CLASS_OWNER';
    const ACCESS_STUDY_CLASS_MEMBER = 'ACCESS_STUDY_CLASS_MEMBER';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(name: 'name', type: 'string', length: 255, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(min: 7)]
    private string $name;

    #[ORM\ManyToMany(targetEntity: Role::class, mappedBy: 'permissions')]

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
}