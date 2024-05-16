<?php

namespace App\Service;

use Exception;
use App\Entity\User;
use App\Exception\AuthorizationException;
use App\Processor\JwtProcessor;
use Symfony\Component\HttpFoundation\Request;

class AuthService
{
    public function __construct(
        private JwtProcessor $jwtProcessor,
        private UserService $userService
    ) {
    }

    public function getAuthUser(Request $request): User
    {
        return $this->validateAuth($request);
    }

    public function setAuthUser(User $user): string
    {
        return $this->jwtProcessor->encode([
            "userId" => $user->getId()
        ]);
    }

    public function validateAuth(Request $request): User
    {
        $request->headers->set('Content-Type', 'application/json');
        $token = $this->parseAuthorizationHeader($request);
        $decryptedToken = $this->jwtProcessor->decode($token);

        try {
            $tokenData = $decryptedToken->claims()->get('sub');
            $tokenPayload = json_decode($tokenData);
            $userId = $tokenPayload->userId;
        } catch (Exception $x) {
            throw new AuthorizationException('Authorization Token data is broken !');
        }

        $user = $this->userService->getUserById($userId);

        if (!$user instanceof User) {
            throw new AuthorizationException('User not found !');
        }

        return $user;
    }

    private function parseAuthorizationHeader(Request $request): string
    {
        $rawToken = $request->headers->get('Authorization');

        if (!$rawToken) {
            throw new AuthorizationException('Authorization Token required !');
        }

        if (preg_match('/Bearer\s((.*)\.(.*)\.(.*))/', $rawToken, $matches)) {
            if(is_string($matches[1])) {
                return $matches[1];
            }
        }

        throw new AuthorizationException("Authorization Token tempered !");
    }
}