<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TricksRepository;

class BlogController extends AbstractController
{

    #[Route('/accueil', name: 'app_blog')]
    public function index(TricksRepository $tricksRepo): Response
    {

        $tricks = $tricksRepo->findAll();
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'tricks'=>$tricks,
        ]);
    }

    #[Route('/tricks/{id}', name: 'trick_details')]
    public function details(TricksRepository $tricksRepo, $id): Response
    {
        $trick = $tricksRepo->findOneById($id);
        return $this->render('blog/details.html.twig', [
            'controller_name' => 'BlogController',
            'trick'=>$trick,
        ]);
    }
}
