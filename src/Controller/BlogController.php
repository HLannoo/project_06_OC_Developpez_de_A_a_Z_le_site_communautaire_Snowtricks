<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TricksRepository;
use App\Entity\Tricks;

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
}
