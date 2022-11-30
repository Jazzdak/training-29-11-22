<?php

namespace App\Controller;

use App\EntityFinder\EntityFinder;
use App\EntityFinder\EntityFinderInterface;
use App\EntityFinder\TracableEntityFinder;
use App\OmdbApi\Consumer\OmdbApiConsumer;
use App\OmdbApi\Provider\MovieProvider;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/movie', name: 'app_movie_')]
class MovieController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('movie/index.html.twig', [
            'controller_name' => 'Movie Index',
        ]);
    }

    #[Route('/{!id<\d+>?1}', name: 'details')]
    public function details(int $id, MovieRepository $movieRepository): Response
//    public function details(int $id, EntityManagerInterface $entityManager): Response
//    public function details(int $id, TracableEntityFinder $entityFinder): Response
    {
//        $movie = [
//            'title' => 'Star Wars',
//            'releasedAt' => new \DateTimeImmutable('1977-05-25'),
//            'genres' => ['Action', 'Adventure', 'Fantasy'],
//        ];

        $movie = $movieRepository->findOneById($id);

//        $movie = $entityManager->find(Movie::class, $id);
//        $entityManager->getUnitOfWork()->markReadOnly($movie);

//        $movie = $entityFinder->find("Movie", $id);

        return $this->render('movie/details.html.twig', [
            'movie' => $movie,
        ]);
    }

    #[Route('/omdb/{title}', name: 'omdb', methods: ['GET'])]
    public function omdb(string $title = null, MovieProvider $provider): Response
    {
        return $this->render('movie/details.html.twig', [
            'movie' => $provider->getMovie(OmdbApiConsumer::MODE_TITLE, $title)
        ]);
    }
}
