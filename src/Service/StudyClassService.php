<?php

namespace App\Service;

use App\Entity\StudyClass;
use App\Repository\StudyClassRepository;

class StudyClassService
{
    public function __construct(
        private StudyClassRepository $studyClassRepository
    ) {
    }

    public function getAllClasses(): array
    {
        return $this->studyClassRepository->findAll();
    }

    public function getOneById(string $id): ?StudyClass
    {
        return $this->studyClassRepository->find($id);
    }

    public function updateClass(StudyClass $studyClass): void
    {
        $this->studyClassRepository->save($studyClass);
    }


    public function addNewClass(StudyClass $studyClass): StudyClass
    {
        $this->studyClassRepository->save($studyClass);

        return $studyClass;
    }
}