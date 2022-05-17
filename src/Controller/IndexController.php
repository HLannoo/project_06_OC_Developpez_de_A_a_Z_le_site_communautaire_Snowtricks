<?php

namespace App\Controller;

use App\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TrickRepository;

class IndexController extends AbstractController
{

    #[Route('/', name: 'app_blog')]
    public function index(TrickRepository $tricksRepo, Request $request, Trick $tricks, TrickRepository $trickRepository ): Response
    {
        $offset = max(0, $request->query->getInt('offset', 10));
        $paginator = $trickRepository->getTrickPaginator($tricks, $offset);
        $tricks = $tricksRepo->findAll();
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'IndexController',
            'tricks'=>$tricks,
            'paginations' => $paginator,
            'previous' => $offset - TrickRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + TrickRepository::PAGINATOR_PER_PAGE)
        ]);
    }
}