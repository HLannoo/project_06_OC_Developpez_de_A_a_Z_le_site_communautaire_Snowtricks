<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\CommentType;
use App\Form\TrickType;
use App\Form\VideoType;
use App\Repository\CommentRepository;
use App\Repository\TrickRepository;
use App\Repository\VideoRepository;
use App\Services\UploadImage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Twig\Environment;


class TrickController extends AbstractController
{
    public function __construct (SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    #[Route('user/trick/create', name: 'trick_create')]
    public function create(Request $request, EntityManagerInterface $manager, UploadImage $uploadImage)
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setUser($this->getUser());
            $trick = $form->getData();


            $trick->setCategory($form->get('category')->getData());
            $trick->setSlug($this->slugger->slug(strtolower($form->get('name')->getData())));

            $mainImage = $form->get('mainImage')->getData();
            $resultMainImage = $uploadImage->imageRegister($mainImage);
            $trick->setMainImage($resultMainImage);

            $images = $form->get('images')->getData();
            foreach ($images as $image) {

                $resultImage = $uploadImage->imageRegister($image);
                $image = new Image();
                $image->setPath($resultImage)
                    ->setTrick($trick);
                $trick->addImage($image);


                foreach ($form->get('videos')->getData() as $url) {
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


    #[Route('user/trick/edit/{slug}', name: 'trick_edit')]
    public function edit($slug, TrickRepository $trickRepository, EntityManagerInterface $manager, Request $request, UploadImage $uploadImage)
    {
        $trick = $trickRepository->findOneBy(['slug'=>$slug]);
        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setCategory($form->get('category')->getData());
            $trick->setSlug($this->slugger->slug($form->get('name')->getData()));

            $mainImage = $form->get('mainImage')->getData();
            $resultMainImage = $uploadImage->imageRegister($mainImage);
            $trick->setMainImage($resultMainImage);

            $images = $form->get('images')->getData();
            foreach ($images as $image) {

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
            return $this->redirectToRoute('trick_details', ['slug' => $slug]);
        }
        return $this->render('trick/create_update.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }

    #[Route('/trick/{slug}', name: 'trick_details')]
    public function show(Request $request,TrickRepository $trickRepository, EntityManagerInterface $manager, Trick $tricks,CommentRepository $commentRepository, $slug): Response
    {
        $offset = max(0, $request->query->getInt('offset', 10));
        $paginator = $commentRepository->getCommentPaginator($tricks, $offset);
        $trick = $trickRepository->findOneBy(['slug'=>$slug]);
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $comment->setCreatedAt(new \DateTime());
            $comment->setTrick($trick);
            $comment->setUser($this->getUser());

            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre commentaire a bien été enregistré !'
            );
            return $this->redirectToRoute('trick_details', ['slug' => $slug]);
        }

        return $this->render('trick/details.html.twig', [
            'trick' => $trick,
            'comments' => $paginator,
            'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE),
            'commentForm'=>$form->createView()
        ]);

    }

    #[Route('user/trick/edit/name/{slug}', name: 'trick_edit_name')]
    public function editName($slug, TrickRepository $trickRepository, EntityManagerInterface $manager, Request $request)
    {
        $trick = $trickRepository->findOneBy(['slug'=>$slug]);
        $form = $this->createForm(TrickType::class, $trick);
        $form->remove('description');
        $form->remove('category');
        $form->remove('images');
        $form->remove('mainImage');
        $form->remove('videos');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setSlug($this->slugger->slug(strtolower($form->get('name')->getData())));
            $manager->persist($trick);
            $manager->flush();

            $this->addflash(
                'success',
                "Le trick a été renommé avec succès !"
            );

            return $this->redirectToRoute('app_blog');
        }
        return $this->render('trick/create_update.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }

    #[Route('user/trick/edit/description/{slug}', name: 'trick_edit_description')]
    public function editDescription($slug, TrickRepository $trickRepository, EntityManagerInterface $manager, Request $request)
    {
        $trick = $trickRepository->findOneBy(['slug'=>$slug]);
        $form = $this->createForm(TrickType::class, $trick);
        $form->remove('category');
        $form->remove('name');
        $form->remove('images');
        $form->remove('mainImage');
        $form->remove('videos');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->flush();
            return $this->redirectToRoute('trick_details', ['slug' => $slug]);
        }
        return $this->render('trick/create_update.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }

    #[Route('user/trick/edit/category/{slug}', name: 'trick_edit_category')]
    public function editCat($slug, TrickRepository $trickRepository, EntityManagerInterface $manager, Request $request)
    {
        $trick = $trickRepository->findOneBy(['slug'=>$slug]);
        $form = $this->createForm(TrickType::class, $trick);
        $form->remove('name');
        $form->remove('description');
        $form->remove('images');
        $form->remove('mainImage');
        $form->remove('videos');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->flush();
            return $this->redirectToRoute('trick_details', ['slug' => $slug]);
        }
        return $this->render('trick/create_update.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }

    #[Route('user/trick/edit/main/{slug}', name: 'trick_edit_main')]
    public function editMainImage($slug, TrickRepository $trickRepository, EntityManagerInterface $manager, Request $request, UploadImage $uploadImage)
    {
        $trick = $trickRepository->findOneBy(['slug'=>$slug]);
        $form = $this->createForm(TrickType::class, $trick);
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
            return $this->redirectToRoute('trick_details', ['slug' => $slug]);
        }
        return $this->render('trick/create_update.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }

    #[Route('user/trick/add/images/{slug}', name: 'trick_add_images')]
    public function editImages($slug, TrickRepository $trickRepository, EntityManagerInterface $manager, Request $request, UploadImage $uploadImage)
    {
        $trick = $trickRepository->findOneBy(['slug'=>$slug]);;
        $form = $this->createForm(TrickType::class);
        $form->remove('name');
        $form->remove('description');
        $form->remove('category');
        $form->remove('mainImage');
        $form->remove('videos');

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $images = $form->get('images')->getData();
            foreach ($images as $image) {

                $resultImage = $uploadImage->imageRegister($image);
                $image = new Image();
                $image->setPath($resultImage)
                    ->setTrick($trick);
                $trick->addImage($image);
            }

            $manager->flush();
            return $this->redirectToRoute('trick_details', ['slug' => $slug]);
        }
        return $this->render('trick/create_update.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }

    #[Route('user/trick/edit/image/{slug}', name: 'trick_edit_image')]
    public function editImage($slug, TrickRepository $trickRepository, EntityManagerInterface $manager, Request $request, UploadImage $uploadImage)
    {
        $trick = $trickRepository->findOneBy(['slug'=>$slug]);
        $form = $this->createForm(TrickType::class, $trick);
        $form->remove('name');
        $form->remove('description');
        $form->remove('category');
        $form->remove('mainImage');
        $form->remove('videos');

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form->get('images')->getData();
                $resultImage = $uploadImage->imageRegister($image);
                $image = new Image();
                $image->setPath($resultImage)
                    ->setTrick($trick);
                $trick->addImage($image);


            $manager->flush();
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }
        return $this->render('trick/create_update.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }

    #[Route('user/trick/add/videos/{slug}', name: 'trick_add_videos')]
    public function editVids($slug, TrickRepository $trickRepository, EntityManagerInterface $manager, Request $request)
    {
        $trick = $trickRepository->findOneBy(['slug'=>$slug]);
        $form = $this->createForm(TrickType::class);
        $form->remove('name');
        $form->remove('description');
        $form->remove('category');
        $form->remove('mainImage');
        $form->remove('images');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($form->get('videos')->getData() as $url) {
                $trick->addVideo($url);

            }

            $manager->flush();
            return $this->redirectToRoute('trick_details', ['slug' => $slug]);
        }
        return $this->render('trick/create_update.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }

    #[Route('user/trick/edit/video/{id}', name: 'trick_edit_video')]
    public function editVid($id, VideoRepository $videoRepository, EntityManagerInterface $manager, Request $request)
    {

        $video = $videoRepository->find($id);
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $url = $form->get('url')->getData();
            $video->setUrl($url);


            $manager->persist($video);
            $manager->flush();
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }
        return $this->render('trick/create_update.html.twig', [
            'trick' => $video,
            'form' => $form->createView()
        ]);
    }


    #[Route('user/trick/delete/videos/{id}', name: 'video_delete')]
    public function deleteVideo( Video $video, EntityManagerInterface $manager, Request $request): response
    {
        $manager->remove($video);
        $manager->flush();
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);

    }

    #[Route('user/trick/delete/image/{id}', name: 'image_delete')]
    public function deleteImage(Image $image, EntityManagerInterface $manager, Request $request, KernelInterface $kernel): response
    {
        $nom = $image->getPath();
        $imagesDir = $kernel->getProjectDir() . '/public/uploads/tricks/';
        $idTrick = $image->getTrick()->getId();

        unlink($imagesDir . $nom);

        $manager->remove($image);
        $manager->flush();

        $referer = $request->headers->get('referer');
        return $this->redirect($referer);

    }

    #[Route('user/trick/delete/mainimage', name: 'main_image_delete')]
    public function deleteMainImage( Trick $trick, Request $request, EntityManagerInterface $em, KernelInterface $kernel, TrickRepository $tricksRepo): response
    {
        $nom = $trick->getMainImage();
        $imagesDir = $kernel->getProjectDir() . '/public/uploads/tricks/';

        unlink($imagesDir . $nom);

        $em->remove($trick);
        $em->flush();
        $route = $request->headers->get('referer');

        return $this->redirectToRoute($route);

    }

    #[Route('user/trick/delete/{slug}', name: 'trick_delete')]
    public function deleteTrick( EntityManagerInterface $manager, TrickRepository $trickRepository, KernelInterface $kernel, $slug): response
    {
        $trick = $trickRepository->findOneBy(['slug'=>$slug]);
        $imagesDir = $kernel->getProjectDir() . '/public/uploads/tricks/';

        $mainImage = $trick->getMainImage();
        unlink($imagesDir . $mainImage);

        foreach ($trick->getImages() as $image)
        {
            unlink($imagesDir . $image->getPath());
        }
        foreach ($trick->getComments() as $comment)
        {
            $manager->remove($comment);
        }

        $manager->remove($trick);
        $manager->flush();

        $this->addflash(
            'success',
            "Le trick {$trick->getName()} a été supprimé avec succès !"
        );

        return $this->redirectToRoute('app_blog');

    }

}

