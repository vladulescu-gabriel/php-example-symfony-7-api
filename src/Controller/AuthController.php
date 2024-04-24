<?php

namespace App\Controller;

use App\Model\User;
use App\Processor\JwtProcessor;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;     
use Symfony\Component\HttpFoundation\Response;
use App\Processor\ResponseProcessor;

class AuthController
{
    // #[Route('/lucky/number')]
    public function number(): Response
    {
        $number = random_int(0, 100);

        return ResponseProcessor::send('fine');
    }

    #[Route('/api/login')]
    public function authenticate(Request $request)
    {   
        $x = (new JwtProcessor)->encode(["ion" => 2]);
        $y = (new JwtProcessor)->decode($x);
        dd([$x, $y]);
    }
}