<?php

namespace App\Repository;

use App\Entity\StudyClass;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class StudyClassRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudyClass::class);
    }

    public function save(StudyClass $studyClass)
    {
        $this->em->persist($studyClass);
        $this->em->flush();
    }
}
