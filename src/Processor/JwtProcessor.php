<?php

namespace App\Processor;

use DateTimeImmutable;
use App\Exception\AuthorizationException;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Token\Builder;
use Lcobucci\JWT\Encoding\CannotDecodeContent;
use Lcobucci\JWT\Token\InvalidTokenStructure;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Token\UnsupportedHeaderFound;
use Lcobucci\JWT\UnencryptedToken;

class JwtProcessor
{
    const TOKEN_IDENTIFIER = '321dnlrnf2lkfn';
    const TOKEN_EXPIRE_TIME = '30 min';

    public function encode(array $data)
    {
        try {
            $tokenBuilder = (new Builder(new JoseEncoder(), ChainedFormatter::default()));
            $algorithm    = new Sha256();
            $signingKey   = InMemory::plainText(random_bytes(32));
            
            $now   = new DateTimeImmutable();
            $token = $tokenBuilder
                ->relatedTo(json_encode($data))
                ->identifiedBy(self::TOKEN_IDENTIFIER)
                ->issuedAt($now)
                ->expiresAt($now->modify('+'.self::TOKEN_EXPIRE_TIME))
                ->getToken($algorithm, $signingKey);
            
            return $token->toString();
        } catch (\Exception $e) {
            throw new \Exception('An error occurred while trying to encode the JWT token.');
        }
    }

    public function decode($token): UnencryptedToken
    {
        $parser = new Parser(new JoseEncoder());

        try {
            $token = $parser->parse($token);
        } catch (CannotDecodeContent | InvalidTokenStructure | UnsupportedHeaderFound $e) {
            throw new AuthorizationException('Token tempered, error at decoding');
        }

        $timeNow = (new DateTimeImmutable())->getTimestamp();
        $tokenDate = $token->claims()->get('exp')->getTimestamp();

        if ($tokenDate < $timeNow) {
            throw new AuthorizationException('Token has expired !');
        }
        
        return $token;
    }
}