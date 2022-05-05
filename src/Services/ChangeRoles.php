<?php

namespace App\Services;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class ChangeRoles
{

    public function upgradeGuest(User $user, $manager)
    {
        $user->setRoles(['ROLE_USER']);

        $manager->persist($user);
        $manager->flush();


    }
}
