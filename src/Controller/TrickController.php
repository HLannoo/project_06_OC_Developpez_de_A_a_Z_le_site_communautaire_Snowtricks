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
use Symfony\Component\HttpKernel\KernelInterface;
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

            $mainImage = $form->get('mainImage')->getData();
            $resultMainImage = $uploadImage->imageRegister($mainImage);
            $trick->setMainImage($resultMainImage);

            $images = $form->get('images')->getData();
            foreach($images as $image) {

                $resultImage = $uploadImage->imageRegister($image);
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
            return $this->redirectToRoute('app_blog');

        }
        return $this->render('trick/create_update.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/trick/edit/{id}', name:'trick_edit')]
    public function edit($id, TrickRepository $trickRepository, EntityManagerInterface $manager, Request $request, UploadImage $uploadImage)
    {
        $trick = $trickRepository->find($id);
        $form = $this->createForm(TrickType::class,$trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $trick->setCategory($form->get('category')->getData());

            $mainImage = $form->get('mainImage')->getData();
            $resultMainImage = $uploadImage->imageRegister($mainImage);
            $trick->setMainImage($resultMainImage);

            $images = $form->get('images')->getData();
            foreach($images as $image) {

                $resultImage = $uploadImage->imageRegister($image);
                $image = new Image();
                $image->setPath($resultImage)
                    ->setTrick($trick);
                $trick->addImage($image);

                foreach ($form->get('videos')->getData() as $url) {
                    $trick->addVideo($url);
                }
            }
            $manager->flush();
            return $this->redirectToRoute('trick_details',['id'=>$id]);
        }
        return $this->render('trick/create_update.html.twig', [
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

    #[Route('/trick/edit/name/{id}', name:'trick_edit_name')]
    public function editName($id, TrickRepository $trickRepository, EntityManagerInterface $manager, Request $request)
    {
        $trick = $trickRepository->find($id);
        $form = $this->createForm(TrickType::class,$trick);
        $form->remove('description');
        $form->remove('category');
        $form->remove('images');
        $form->remove('mainImage');
        $form->remove('videos');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->flush();
            return $this->redirectToRoute('trick_details',['id'=>$id]);
        }
        return $this->render('trick/create_update.html.twig', [
            'trick'=>$trick,
            'form' => $form->createView()
        ]);
    }

    #[Route('/trick/edit/description/{id}', name:'trick_edit_description')]
    public function editDescription($id, TrickRepository $trickRepository, EntityManagerInterface $manager, Request $request)
    {
        $trick = $trickRepository->find($id);
        $form = $this->createForm(TrickType::class,$trick);
        $form->remove('category');
        $form->remove('name');
        $form->remove('images');
        $form->remove('mainImage');
        $form->remove('videos');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->flush();
            return $this->redirectToRoute('trick_details',['id'=>$id]);
        }
        return $this->render('trick/create_update.html.twig', [
            'trick'=>$trick,
            'form' => $form->createView()
        ]);
    }

    #[Route('/trick/edit/category/{id}', name:'trick_edit_category')]
    public function editCat($id, TrickRepository $trickRepository, EntityManagerInterface $manager, Request $request)
    {
        $trick = $trickRepository->find($id);
        $form = $this->createForm(TrickType::class,$trick);
        $form->remove('name');
        $form->remove('description');
        $form->remove('images');
        $form->remove('mainImage');
        $form->remove('videos');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->flush();
            return $this->redirectToRoute('trick_details',['id'=>$id]);
        }
        return $this->render('trick/create_update.html.twig', [
            'trick'=>$trick,
            'form' => $form->createView()
        ]);
    }

    #[Route('/trick/edit/main/{id}', name:'trick_edit_main')]
    public function editMainImage($id, TrickRepository $trickRepository, EntityManagerInterface $manager, Request $request,UploadImage $uploadImage)
    {
        $trick = $trickRepository->find($id);
        $form = $this->createForm(TrickType::class,$trick);
        $form->remove('name');
        $form->remove('description');
        $form->remove('category');
        $form->remove('images');
        $form->remove('videos');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $mainImage = $form->get('mainImage')->getData();
            $resultMainImage = $uploadImage->imageRegister($mainImage);
            $trick->setMainImage($resultMainImage);

            $manager->flush();
            return $this->redirectToRoute('trick_details',['id'=>$id]);
        }
        return $this->render('trick/create_update.html.twig', [
            'trick'=>$trick,
            'form' => $form->createView()
        ]);
    }

    #[Route('/trick/edit/images/{id}', name:'trick_edit_images')]
    public function editImages($id, TrickRepository $trickRepository, EntityManagerInterface $manager, Request $request,UploadImage $uploadImage)
    {
        $trick = $trickRepository->find($id);
        $form = $this->createForm(TrickType::class,$trick);
        $form->remove('name');
        $form->remove('description');
        $form->remove('category');
        $form->remove('mainImage');
        $form->remove('videos');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $images = $form->get('images')->getData();
            foreach($images as $image) {

                $resultImage = $uploadImage->imageRegister($image);
                $image = new Image();
                $image->setPath($resultImage)
                    ->setTrick($trick);
                $trick->addImage($image);
            }

            $manager->flush();
            return $this->redirectToRoute('trick_details',['id'=>$id]);
        }
        return $this->render('trick/create_update.html.twig', [
            'trick'=>$trick,
            'form' => $form->createView()
        ]);
    }

    #[Route('/trick/edit/videos/{id}', name:'trick_edit_videos')]
    public function editVid($id, TrickRepository $trickRepository, EntityManagerInterface $manager, Request $request)
    {
        $trick = $trickRepository->find($id);
        $form = $this->createForm(TrickType::class,$trick);
        $form->remove('name');
        $form->remove('description');
        $form->remove('category');
        $form->remove('mainImage');
        $form->remove('images');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach($form->get('videos')->getData() as $url) {
                $trick->addVideo($url);

            }

            $manager->flush();
            return $this->redirectToRoute('trick_details',['id'=>$id]);
        }
        return $this->render('trick/create_update.html.twig', [
            'trick'=>$trick,
            'form' => $form->createView()
        ]);
    }

    #[Route('/trick/image_delete/{id}', name:'image_delete')]
    public function deleteImage (Image $image,Request $request, EntityManagerInterface $em, KernelInterface $kernel,TrickRepository $tricksRepo):response
    {
        $nom = $image->getPath();
        $imagesDir = $kernel->getProjectDir().'/public/uploads/tricks/';

        unlink($imagesDir.$nom);

        $em->remove($image);
        $em->flush();

        $route = $request->headers->get('referer');

        return $this->redirectToRoute($route);

    }

    #[Route('/trick/main_image_delete', name:'main_image_delete')]
    public function deleteMainImage ($id, Trick $trick, Request $request, EntityManagerInterface $em, KernelInterface $kernel,TrickRepository $tricksRepo):response
    {
        $nom = $trick->getMainImage();
        $imagesDir = $kernel->getProjectDir().'/public/uploads/tricks/';

        unlink($imagesDir.$nom);

        $em->remove($trick);
        $em->flush();
        $route = $request->headers->get('referer');

        return $this->redirectToRoute($route);

    }

}

