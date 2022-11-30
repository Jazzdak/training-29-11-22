<?php

namespace App\Services;

interface EntityFinderInterface
{
    public function find(String $class, int $id);
}