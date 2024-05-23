<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;     
use Symfony\Component\HttpFoundation\Response;
use App\Processor\ResponseProcessor;

class WelcomeController extends AbstractController
{
    #[Route('/')]
    public function welcome(Request $request): Response
    {
        return ResponseProcessor::send([
            "message" => "Hello, api server is online ! Please use an API platform like PostMan or ThunderClient to test the Api.",
            "routes" => [
                [ "path" => "/signin", "method" => "POST", "body" => ["login" => "username or email", "password" => "password"] ],
                [ "path" => "/signup", "method" => "POST", "body" => ["email" => "email@email.com", "username" => "username", "password" => "password"] ],
                [ "path" => "/api/users", "method" => "GET", "body" => "NOTHING" ],
                [ "path" => "/api/users", "method" => "POST", "body" => ["email" => "email@email.com", "username" => "username", "password" => "password", "role" => "roleName"] ],
                [ "path" => "/api/users/{userId}", "method" => "GET", "body" => "NOTHING" ],
                [ "path" => "/api/users/{userId}/{newRole}", "method" => "PUT", "body" => "NOTHING" ],
                [ "path" => "/api/roles", "method" => "GET", "body" => "NOTHING" ],
                [ "path" => "/api/roles{roleId}", "method" => "GET", "body" => "NOTHING" ],
                [ "path" => "/api/roles", "method" => "POST", "body" => ["name" => "New Role Name"] ],
                [ "path" => "/api/study-classes", "method" => "GET", "body" => "NOTHING" ],
                [ "path" => "/api/study-classes/{studyClassId}", "method" => "GET", "body" => "NOTHING" ],
                [ "path" => "/api/study-classes", "method" => "POST", "body" => ["name" => "study class Name", "owner_id" => "User Id with ACCESS_STUDY_CLASS_OWNER permission"] ],
                [ "path" => "/api/study-classes/{classId}/students", "method" => "POST", "body" => [ "user_ids" => [1, 2, 3]] ],
                [ "path" => "/api/study-classes/{classId}/students", "method" => "DELETE", "body" => [ "user_ids" => [1, 2, 3]] ],
            ]
        ]);
    }
}