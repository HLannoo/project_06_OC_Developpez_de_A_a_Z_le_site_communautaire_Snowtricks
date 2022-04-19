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

            $trick->setCategory($form->get('category')->getData());
            $trick->removeAllImages();
            foreach($request->files->get('trick')['images'] as $file) {
                $resultImage = $uploadImage->imageRegister($file['path']);
                $image = new Image();
                $image->setPath($resultImage)
                    ->setTrick($trick);
                $trick->addImage($image);


                foreach($form->get('videos')->getData() as $url) {
                    $trick->addVideo($url);

                }
            }
            $manager->persist($trick);
            $manager->flush();
            $this->addFlash(
                'success',
                'Le trick <strong>' . $trick->getName() . '</strong> a bien été ajouté !'
            );
            return $this->redirectToRoute('app_blog');

        }
        return $this->render('trick/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/trick/edit/{id}', name:'trick_edit')]
    public function edit($id, TrickRepository $trickRepository, EntityManagerInterface $manager): Response
    {
        $trick = $trickRepository->find($id);
        $form = $this->createForm(TrickType::class,$trick);

        $manager->flush();

        return $this->render('trick/update.html.twig', [
            'controller_name' => 'TrickController',
            'trick'=>$trick,
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

