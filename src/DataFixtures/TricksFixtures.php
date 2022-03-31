<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Tricks;
use App\Entity\Images;
use App\Entity\Videos;
use App\Entity\Comments;
use App\Entity\Category;

class TricksFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        //créer 3 catégories
        for ($i=1; $i <= 3; $i++) {
            $category = new Category();
            $category->setTitle("Catégorie n°$i")
                ->setDescription("Description n°$i");

            $manager->persist($category);

            // Créer 10 tricks
            for ($u = 1; $u <= 10; $u++) {
                $tricks = new Tricks();
                $tricks->setTitle("titre de l'article n°$u")
                    ->setContent("Contenu de l'article n°$u")
                    ->setCreatedAt(new \DateTimeImmutable())
                    ->setCategory($category);

                $manager->persist($tricks);

                // Ajout des commentaires à l'article
                for ($k = 1; $k <= mt_rand(1, 4); $k++) {

                    $comment = new Comments();

                    $now = new \DateTimeImmutable();

                    $comment->setAuthor('Hédi Lannoo')
                        ->setContent("Commentaire de l'article n°$u")
                        ->setCreateAt($now)
                        ->setTrick($tricks);

                    $manager->persist($comment);

                    // Ajout des images à l'article
                    for ($l = 1; $l <= mt_rand(1, 4); $l++) {

                        $image = new Images();
                        $image->setPath('https://via.placeholder.com/130.png/09f/fff')
                            ->setIdTrick($tricks);

                        $manager->persist($image);

                        // Ajout des vidéos à l'article
                        for ($v = 1; $v <= mt_rand(1, 4); $v++) {

                            $video = new Videos();
                            $video->setPath('https://via.placeholder.com/130.png/09f/fff')
                                ->setIdTrick($tricks);

                            $manager->persist($video);
                        }
                    }
                }
            }
        }
        $manager->flush();
    }

}
