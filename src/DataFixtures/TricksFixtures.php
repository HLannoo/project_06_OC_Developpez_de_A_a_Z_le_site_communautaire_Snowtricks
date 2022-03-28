<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Tricks;

class TricksFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <=10; $i++) {
            $tricks = New Tricks();
            $tricks->setTitle("titre de l'article n°$i")
                    ->setContent("Contenu de l'article n°$i")
                    ->setImage("https://dummyimage.com/140x140.png/09f/fff")
                    ->setVideo("https://dummyimage.com/140x140.png/09f/fff")
                    ->setDenomination("Soft")
                    ->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($tricks);
        }

        $manager->flush();
    }
}
