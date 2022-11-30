<?php

namespace App\OmdbApi\Transformer;

use App\Entity\Movie;
use App\Repository\GenreRepository;
use DateTimeImmutable;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Polyfill\Intl\Icu\Exception\NotImplementedException;

class MovieTransformer implements DataTransformerInterface
{

    public function __construct(private GenreTransformer $genreTransformer)
    {
    }

    public function transform(mixed $value): Movie
    {
        $movie = new Movie();
        $movie->setCountry($value['Country']);
        $movie->setPoster(isset($value['Poster'])?$value['Poster']:'N/A');
        $movie->setTitle($value['Title']);
        $movie->setReleasedAt(isset($value['Released'])?DateTimeImmutable::createFromFormat('d F Y', $value['Released']):DateTimeImmutable::createFromFormat('Y', $value['Year']));
        $movie->setPrice(0);
        $genres = explode(',', $value['Genre']);
        foreach ($genres as $genre) {
            $transformedGenre = $this->genreTransformer->transform($genre);
            $movie->addGenre($transformedGenre);
        }
        return $movie;
    }

    public function reverseTransform(mixed $value)
    {
        throw new NotImplementedException();
    }
}