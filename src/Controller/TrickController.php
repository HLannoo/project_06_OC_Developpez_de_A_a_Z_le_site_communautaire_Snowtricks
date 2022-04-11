<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use App\Services\UploadImage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
    #[Route('/trick/create', name:'trick_create')]
    public function create(Request $request, EntityManagerInterface $manager, UploadImage $uploadImage)
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $trick = $form->getData();
            $dataImg = $form->get('images')->getData();
            $register = $uploadImage->imageRegister($dataImg);


            $trick->setCategory($form->get('category')->getData());
            $manager->persist($trick);

            $image = new Image();
            $image->setPath($register->getPathname());
            $image->setTrick($trick);
            $manager->persist($image);

            $video = new Video();
            $video->setUrl($request->get('trick')['videos']);
            $video->setTrick($trick);
            $manager->persist($video);

            $manager->flush();


        }
        return $this->render('trick/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/trick/{id}', name: 'trick_details')]
    public function show(TrickRepository $tricksRepo, $id): Response
    {
        $trick = $tricksRepo->findOneById($id);

        return $this->render('trick/details.html.twig', [
            'controller_name' => 'TrickController',
            'trick'=>$trick,
        ]);

    }

}

