<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'app_default_')]
class DefaultController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(MovieRepository $movieRepository): Response
    {

        return $this->render('default/index.html.twig', [
            'controller_name' => 'index',
            'movies' => $movieRepository->findBy([], ['id'=>'desc'], 6)
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'contact',
        ]);
    }
}
