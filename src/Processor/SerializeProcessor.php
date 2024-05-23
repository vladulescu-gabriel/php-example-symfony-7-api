<?php

namespace App\Processor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SerializeProcessor
{
    private Serializer $serializer;

    public function __construct() 
    {
        $this->serializer = new Serializer(
            [new ObjectNormalizer()],
            [new JsonEncoder()],
        );
    }

    public function serialize(mixed $data): array
    {
        $jsonString = $this->serializer->serialize($data, 'json');
        return json_decode($jsonString);
    }
}