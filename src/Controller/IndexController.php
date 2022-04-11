<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TrickRepository;

class IndexController extends AbstractController
{

    #[Route('/', name: 'app_blog')]
    public function index(TrickRepository $tricksRepo): Response
    {

        $tricks = $tricksRepo->findAll();
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'IndexController',
            'tricks'=>$tricks,
        ]);
    }
}