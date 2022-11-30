<?php

namespace App\OmdbApi;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OmdbApiConsumer
{

    public const MODE_TITLE = 't';
    public const MODE_ID = 'i';

    public function __construct(private readonly HttpClientInterface $omdbClient)
    {

    }

    public function fetch(string $mode, string $value): array
    {
        if(!\in_array($mode, [self::MODE_ID, self::MODE_TITLE])){
            throw new \InvalidArgumentException("Invalide argument");
        }

        $data = $this->omdbClient->request(
            Request::METHOD_GET,
            '',
            [
                'query'=>[$mode => $value]
            ]
        )->toArray();

        if ($data['Response'] === 'False') {
            throw new NotFoundHttpException();
        }

        return $data;
    }
}