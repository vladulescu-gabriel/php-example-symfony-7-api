<?php

namespace App\Repository;

use App\Entity\StudyClass;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

final class StudyClassRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct($registry, StudyClass::class);
    }

    public function save(StudyClass $studyClass)
    {
        $this->entityManager->persist($studyClass);
        $this->entityManager->flush();
    }
}
