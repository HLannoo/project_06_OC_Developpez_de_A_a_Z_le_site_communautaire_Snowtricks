<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    protected $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
        }
    public function load(ObjectManager $manager): void
    {


            $user = new User();
            $hash = $this->hasher->hashPassword($user,'test123');
            $user->setPseudo('Kayoken')
                ->setEmail('hedilannoo@gmail.com')
                ->setRoles(['ROLE_ADMIN'])
                ->setPassword($hash);

        $manager->persist($user);
        $manager->flush();
    }
}
