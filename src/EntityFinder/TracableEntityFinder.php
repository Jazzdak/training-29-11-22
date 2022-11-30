<?php

namespace App\EntityFinder;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

#[AsDecorator("App\EntityFinder\EntityFinder")]
class TracableEntityFinder implements EntityFinderInterface
{

    public function __construct(private readonly EntityFinder $finder, private readonly LoggerInterface $logger, private bool $isLogged)
    {
    }

    public function find(string $class, int $id)
    {
        if($this->isLogged) {
            $this->logger->debug(printf("EntityFinder used on Entity %s with id %d", $class, $id));
        }

        return $this->finder->find($class, $id);
    }
}