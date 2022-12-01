<?php

namespace App\EntityFinder;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.entityfinder')]
interface EntityFinderInterface
{
    public function find(String $class, int $id) : ?object;
}