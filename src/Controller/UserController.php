<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends AbstractController
{
    #[Route('/user/{pseudo}', name: 'user_profile')]
    public function userProfile(Request $request, EntityManagerInterface $manager, User $user):response
    {
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->remove('plainPassword');
        $form->remove('agreeTerms');
        $form->remove('mainImage');
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPseudo($form->get('pseudo')->getData());
            $user->setEmail($form->get('email')->getData());

            $manager->flush();
            return $this->redirectToRoute('user_profile', ['user' => $user]);

        }
        return $this->render('user/profile.html.twig', [
            'user'=>$user,
            'FormProfile' => $form->createView(),
        ]);
    }
}
