<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Services\UploadImage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
    #[Route('/user/{id}', name: 'user_profile')]
    public function userProfile($id, Request $request, EntityManagerInterface $manager, User $user,UploadImage $uploadImage,KernelInterface $kernel):response
    {
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->remove('plainPassword');
        $form->remove('agreeTerms');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPseudo($form->get('pseudo')->getData());
            $user->setEmail($form->get('email')->getData());
            if (!empty($mainImage = $form->get('mainImage')->getData())) {

                $nom = $user->getImage();
                $imagesDir = $kernel->getProjectDir() . '/public/uploads/profil/';
                unlink($imagesDir . $nom);

                $resultImage = $uploadImage->profilImageRegister($mainImage);
                $user->setImage($resultImage);
            }



            $manager->flush();
            $this->addFlash('success', 'Profil mis à jour');
            return $this->redirectToRoute('user_profile',['id' => $id]);

        }
        return $this->render('user/profile.html.twig', [
            'user'=>$user,
            'FormProfile' => $form->createView(),
        ]);
    }
}
