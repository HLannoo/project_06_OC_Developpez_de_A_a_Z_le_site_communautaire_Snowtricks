<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Trick;
use App\Entity\Image;
use App\Entity\Video;
use App\Entity\Comment;
use App\Entity\Category;

class TricksFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        //créer 3 catégories
        for ($i=1; $i <= 3; $i++) {
            $category = new Category();
            $category->setName("Catégorie n°$i");

            $manager->persist($category);

            // Créer 10 tricks
            for ($u = 1; $u <= 10; $u++) {
                $tricks = new Trick();
                $tricks->setName("titre de l'article n°$u")
                    ->setDescription("Contenu de l'article n°$u")
                    ->setCreatedAt(new \DateTime())
                    ->setCategory($category);

                $manager->persist($tricks);

                // Ajout des commentaires à l'article
                for ($k = 1; $k <= mt_rand(1, 4); $k++) {

                    $comment = new Comment();

                    $now = new \DateTime();

                    $comment->setContent("Commentaire de l'article n°$u")
                        ->setCreatedAt($now)
                        ->setTrick($tricks);

                    $manager->persist($comment);

                    // Ajout des images à l'article
                    for ($l = 1; $l <= mt_rand(1, 4); $l++) {

                        $image = new Image();
                        $image->setPath('https://via.placeholder.com/130.png/09f/fff')
                            ->setName('nom image $l')
                            ->setTrick($tricks);

                        $manager->persist($image);

                        // Ajout des vidéos à l'article
                        for ($v = 1; $v <= mt_rand(1, 4); $v++) {

                            $video = new Video();
                            $video->setUrl('https://via.placeholder.com/130.png/09f/fff')
                                ->setTrick($tricks);

                            $manager->persist($video);
                        }
                    }
                }
            }
        }
        $manager->flush();
    }

}
