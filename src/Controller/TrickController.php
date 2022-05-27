<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\CommentType;
use App\Form\ImageType;
use App\Form\TrickType;
use App\Form\VideoType;
use App\Repository\CommentRepository;
use App\Repository\ImageRepository;
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


class TrickController extends AbstractController
{
    private $slugger;
    private $manager;
    private $uploadImage;
    protected $trickRepository;
    protected $kernel;
    protected $trickNameVerifier;

    public function __construct(SluggerInterface $slugger, EntityManagerInterface $manager, UploadImage $uploadImage, TrickRepository $trickRepository, KernelInterface $kernel)
    {
        $this->slugger = $slugger;
        $this->manager = $manager;
        $this->uploadImage = $uploadImage;
        $this->trickRepository = $trickRepository;
        $this->kernel = $kernel;
    }

    #[Route('user/trick/create', name: 'trick_create')]
    public function create(Request $request)
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $trickName = $form->get('name')->getData();
            $trick = $form->getData();
            $trick->setUser($this->getUser());
            $trick->setSlug($this->slugger->slug(strtolower($trickName)));
            $trick->setCategory($form->get('category')->getData());
            $images = $form->get('images')->getData();

            foreach ($images as $image) {
                $resultImage = $this->uploadImage->imageRegister($image);
                $image = new Image();
                $image->setPath($resultImage)
                    ->setTrick($trick);
                $trick->addImage($image);
            }

            foreach ($form->get('videos')->getData() as $url) {
                $trick->addVideo($url);

            }
            $this->manager->persist($trick);
            $this->manager->flush();
            $this->addflash(
                'success',
                "Le trick a été créé avec succès !"
            );
            return $this->redirectToRoute('app_blog');


        }
        return $this->render('trick/create_update.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('user/trick/edit/{slug}', name: 'trick_edit')]
    public function edit($slug, Request $request)
    {
        $trick = $this->trickRepository->findOneBy(['slug' => $slug]);
        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setCategory($form->get('category')->getData());
            $trick->setSlug($this->slugger->slug($form->get('name')->getData()));
            $trick->setUpdatedAt(new \DateTime('now'));

            $images = $form->get('images')->getData();
            foreach ($images as $image) {

                $resultImage = $this->uploadImage->imageRegister($image);
                $image = new Image();
                $image->setPath($resultImage)
                    ->setTrick($trick);
                $trick->addImage($image);

                foreach ($form->get('videos')->getData() as $url) {
                    $trick->addVideo($url);
                }
            }
            $this->manager->flush();
            return $this->redirectToRoute('trick_details', ['slug' => $slug]);
        }

        return $this->render('trick/create_update.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }

    #[Route('/trick/{slug}', name: 'trick_details')]
    public function show(Trick $tricks, CommentRepository $commentRepository, $slug, Request $request): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $commentRepository->getCommentPaginator($tricks, $offset);
        $trick = $this->trickRepository->findOneBy(['slug' => $slug]);
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setCreatedAt(new \DateTime());
            $comment->setTrick($trick);
            $comment->setUser($this->getUser());

            $this->manager->persist($comment);
            $this->manager->flush();

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
            'commentForm' => $form->createView()
        ]);

    }

    #[Route('user/trick/edit/name/{slug}', name: 'trick_edit_name')]
    public function editName($slug, Request $request)
    {
        $trick = $this->trickRepository->findOneBy(['slug' => $slug]);
        $form = $this->createForm(TrickType::class, $trick);
        $form->remove('description');
        $form->remove('category');
        $form->remove('images');
        $form->remove('videos');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setSlug($this->slugger->slug(strtolower($form->get('name')->getData())));
            $trick->setUpdatedAt(new \DateTime('now'));
            $this->manager->persist($trick);
            $this->manager->flush();

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
    public function editDescription($slug, Request $request)
    {
        $trick = $this->trickRepository->findOneBy(['slug' => $slug]);
        $form = $this->createForm(TrickType::class, $trick);
        $form->remove('category');
        $form->remove('name');
        $form->remove('images');
        $form->remove('videos');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setUpdatedAt(new \DateTime('now'));

            $this->manager->flush();
            $this->addflash(
                'success',
                "description modifié avec succès !"
            );
            return $this->redirectToRoute('trick_details', ['slug' => $slug]);
        }
        return $this->render('trick/create_update.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }

    #[Route('user/trick/edit/category/{slug}', name: 'trick_edit_category')]
    public function editCat($slug, Request $request)
    {
        $trick = $this->trickRepository->findOneBy(['slug' => $slug]);
        $form = $this->createForm(TrickType::class, $trick);
        $form->remove('name');
        $form->remove('description');
        $form->remove('images');
        $form->remove('videos');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setCategory($form->get('category')->getData());
            $trick->setUpdatedAt(new \DateTime('now'));

            $this->manager->flush();
            $this->addflash(
                'success',
                "Catégorie modifié avec succès !"
            );
            return $this->redirectToRoute('trick_details', ['slug' => $slug]);
        }
        return $this->render('trick/create_update.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }

    #[Route('user/trick/add/images/{slug}', name: 'trick_add_images')]
    public function addImages($slug, Request $request)
    {
        $trick = $this->trickRepository->findOneBy(['slug' => $slug]);;
        $form = $this->createForm(TrickType::class);
        $form->remove('name');
        $form->remove('description');
        $form->remove('category');
        $form->remove('videos');

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setUpdatedAt(new \DateTime('now'));
            $images = $form->get('images')->getData();
            foreach ($images as $image) {

                $resultImage = $this->uploadImage->imageRegister($image);
                $image = new Image();
                $image->setPath($resultImage)
                    ->setTrick($trick);
                $trick->addImage($image);
            }

            $this->manager->flush();
            $this->addflash(
                'success',
                "Image(s) ajoutée(s) avec succès !"
            );
            return $this->redirectToRoute('trick_details', ['slug' => $slug]);
        }
        return $this->render('trick/create_update.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }

    #[Route('user/trick/edit/image/{id}', name: 'trick_edit_image')]
    public function editImage($id, Image $imageEntity, ImageRepository $imageRepository, Request $request)
    {
        $trick = $this->trickRepository->findOneBy(['id' => $id]);
        $form = $this->createForm(ImageType::class, $trick);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            if (!empty($image = $form->get('images')->getData())) {
                $findImage = $imageRepository->find($id);
                $name = $findImage->getPath();
                $imagesDir = $this->kernel->getProjectDir() . '/public/uploads/tricks/';
                if (is_file($imagesDir . $name)) {

                    unlink($imagesDir . $name);
                }
                $resultImage = $this->uploadImage->imageRegister($image);
                $imageEntity->setPath($resultImage);
                $imageEntity->getTrick()->setUpdatedAt(new \DateTime('now'));

            }


            $this->manager->flush();
            $referer = $request->headers->get('referer');
            $this->addFlash('success', "l'image a bien été éditée");
            return $this->redirect($referer);
        }
        return $this->render('trick/create_update.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }

    #[Route('user/trick/add/videos/{slug}', name: 'trick_add_videos')]
    public function addVid($slug, Request $request)
    {
        $trick = $this->trickRepository->findOneBy(['slug' => $slug]);
        $form = $this->createForm(TrickType::class);
        $form->remove('name');
        $form->remove('description');
        $form->remove('category');
        $form->remove('images');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($form->get('videos')->getData() as $url) {
                $trick->addVideo($url);
                $trick->setUpdatedAt(new \DateTime('now'));

            }

            $this->manager->flush();
            $this->addflash(
                'success',
                "La vidéo a été ajoutée avec succès !"
            );
            return $this->redirectToRoute('trick_details', ['slug' => $slug]);
        }
        return $this->render('trick/create_update.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }

    #[Route('user/trick/edit/video/{id}', name: 'trick_edit_video')]
    public function editVid($id, VideoRepository $videoRepository, Request $request)
    {

        $video = $videoRepository->find($id);
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $url = $form->get('url')->getData();
            $video->setUrl($url);
            $trick = $video->getTrick();
            $trick->setUpdatedAt(new \DateTime('now'));


            $this->manager->persist($video);
            $this->manager->flush();
            $referer = $request->headers->get('referer');
            $this->addflash(
                'success',
                "La vidéo a été éditée avec succès !"
            );
            return $this->redirect($referer);
        }
        return $this->render('trick/create_update.html.twig', [
            'trick' => $video,
            'form' => $form->createView()
        ]);
    }


    #[Route('user/trick/delete/videos/{id}', name: 'video_delete')]
    public function deleteVideo(Video $video, Request $request)
    {
        $this->manager->remove($video);
        $trick = $video->getTrick();
        $trick->setUpdatedAt(new \DateTime('now'));

        $this->manager->flush();
        $referer = $request->headers->get('referer');
        $this->addflash(
            'success',
            "La vidéo a été supprimée avec succès !"
        );
        return $this->redirect($referer);

    }

    #[Route('user/trick/delete/image/{id}', name: 'image_delete')]
    public function deleteImage(Image $image, Request $request): response
    {
        $nom = $image->getPath();
        $imagesDir = $this->kernel->getProjectDir() . '/public/uploads/tricks/';
        $image->getTrick()->setUpdatedAt(new \DateTime('now'));
        $image->getTrick()->getId();


        unlink($imagesDir . $nom);

        $this->manager->remove($image);
        $this->manager->flush();

        $referer = $request->headers->get('referer');

        $this->addflash(
            'success',
            "L'image a été supprimée avec succès !"
        );
        return $this->redirect($referer);

    }

    #[Route('user/trick/delete/{slug}', name: 'trick_delete')]
    public function deleteTrick($slug): response
    {
        $trick = $this->trickRepository->findOneBy(['slug' => $slug]);
        $imagesDir = $this->kernel->getProjectDir() . '/public/uploads/tricks/';

        foreach ($trick->getImages() as $image) {
            unlink($imagesDir . $image->getPath());
        }
        foreach ($trick->getComments() as $comment) {
            $this->manager->remove($comment);
        }

        $this->manager->remove($trick);
        $this->manager->flush();

        $this->addflash(
            'success',
            "Le trick {$trick->getName()} a été supprimé avec succès !"
        );

        return $this->redirectToRoute('app_blog');

    }

}

