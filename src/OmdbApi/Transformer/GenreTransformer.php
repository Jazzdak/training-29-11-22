<?php

namespace App\OmdbApi\Transformer;

use App\Entity\Genre;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Polyfill\Intl\Icu\Exception\NotImplementedException;

class GenreTransformer implements DataTransformerInterface
{

    public function transform(mixed $value): Genre
    {
        $genre = new Genre();
        $genre->setName($value);
        $genre->setPoster("N/A");

        return $genre;
    }

    public function reverseTransform(mixed $value)
    {
        throw new NotImplementedException();
    }
}