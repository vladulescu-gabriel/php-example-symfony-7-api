<?php

namespace App\Processor;

use DateTimeImmutable;
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

    public function encode(array $data)
    {
        try {
            $tokenBuilder = (new Builder(new JoseEncoder(), ChainedFormatter::default()));
            $algorithm    = new Sha256();
            $signingKey   = InMemory::plainText(random_bytes(32));
            
            $now   = new DateTimeImmutable();
            $token = $tokenBuilder
                // Configures the issuer (iss claim)
                ->issuedBy('http://example.com')
                // Configures the audience (aud claim)
                ->permittedFor('http://example.org')
                // Configures the subject of the token (sub claim)
                ->relatedTo(json_encode($data))
                // Configures the id (jti claim)
                ->identifiedBy('4f1g23a12aa')
                // Configures the time that the token was issue (iat claim)
                ->issuedAt($now)
                // Configures the time that the token can be used (nbf claim)
                ->canOnlyBeUsedAfter($now->modify('+1 minute'))
                // Configures the expiration time of the token (exp claim)
                ->expiresAt($now->modify('+1 hour'))
                // Configures a new claim, called "uid"
                ->withClaim('uid', 1)
                // Configures a new header, called "foo"
                ->withHeader('foo', 'bar')
                // Builds a new token
                ->getToken($algorithm, $signingKey);
            
            return $token->toString();
        }
        catch (\Exception $e) {
            throw new \Exception('An error occurred while trying to encode the JWT token.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function decode($token): UnencryptedToken
    {
        $parser = new Parser(new JoseEncoder());

        try {
            $token = $parser->parse($token);
        } catch (CannotDecodeContent | InvalidTokenStructure | UnsupportedHeaderFound $e) {
            echo 'Oh no, an error: ' . $e->getMessage();
        }
        assert($token instanceof UnencryptedToken);
        
        return $token;
    }
}