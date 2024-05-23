<?php

namespace App\Controller;

use App\Entity\Permission;
use App\Service\StudyClassService;
use App\Processor\SerializeProcessor;
use App\Validator\ClassStudentsAddValidator;
use App\Validator\ClassStudentsRemoveValidator;
use App\Validator\NewClassValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;     
use Symfony\Component\HttpFoundation\Response;
use App\Processor\ResponseProcessor;

class StudyClassController extends AbstractController
{
    public function __construct(
        private StudyClassService $studyClassService,
        private NewClassValidator $newClassValidator,
        private ClassStudentsAddValidator $classStudentsAddValidator,
        private ClassStudentsRemoveValidator $classStudentsRemoveValidator,
        private SerializeProcessor $serializer
    ){}

    #[Route(
        '/api/study-classes',
        methods: ['GET'],
        options: [Permission::PERMISSION_KEY => Permission::ACCESS_VIEW_STUDY_CLASSES]
    )]
    public function getAll(Request $request): Response
    {
        $classes = $this->studyClassService->getAllClasses();
        $data = $this->serializer->serialize($classes);
        return ResponseProcessor::send($data);
    }

    #[Route(
        '/api/study-classes/{classId}',
        methods: ['GET'],
        options: [Permission::PERMISSION_KEY => Permission::ACCESS_VIEW_STUDY_CLASS]
    )]
    public function getOne(Request $request, int $classId): Response
    {
        $class = $this->studyClassService->getOneById($classId);
        $data = $this->serializer->serialize($class);
        return ResponseProcessor::send($data);
    }

    #[Route(
        '/api/study-classes',
        methods: ['POST'],
        options: [Permission::PERMISSION_KEY => Permission::ACCESS_ADD_STUDY_CLASS]
    )]
    public function addOne(Request $request): Response
    {
        $class = $this->newClassValidator->validate($request);
        $newClass = $this->studyClassService->addNewClass($class);
        $data = $this->serializer->serialize($newClass);
        
        return ResponseProcessor::send($data);
    }

    #[Route(
        '/api/study-classes/{classId}/students',
        methods: ['POST'], 
        options: [Permission::PERMISSION_KEY => Permission::ACCESS_ADD_STUDENTS_TO_STUDY_CLASS]
    )]
    public function addStudents(Request $request, int $classId): Response
    {
        $class = $this->studyClassService->getOneById($classId);
        $students = $this->classStudentsAddValidator->validate($request);

        foreach ($students as $student) {
            $class->addUser($student);
        }

        $this->studyClassService->updateClass($class);
        $data = $this->serializer->serialize($class);
        
        return ResponseProcessor::send($data);
    }

    #[Route(
        '/api/study-classes/{classId}/students',
        methods: ['DELETE'],
        options: [Permission::PERMISSION_KEY => Permission::ACCESS_REMOVE_STUDENTS_FROM_STUDY_CLASS]
    )]
    public function removeStudents(Request $request, int $classId): Response
    {
        $class = $this->studyClassService->getOneById($classId);
        $students = $this->classStudentsRemoveValidator->validate($request);

        foreach ($students as $student) {
            $class->removeUser($student);
        }

        $this->studyClassService->updateClass($class);
        $data = $this->serializer->serialize($class);
        
        return ResponseProcessor::send($data);
    }
}