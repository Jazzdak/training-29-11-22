<?php

namespace App\EntityFinder;

use Doctrine\ORM\EntityManagerInterface;

class EntityFinder implements EntityFinderInterface
{

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function find(string $class, int $id): ?object
    {
        return $this->find($class, $id);
    }
}