<?php

namespace App\Services;

use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use function PHPUnit\Framework\isFalse;
use function PHPUnit\Framework\isTrue;

class TrickNameVerifier extends AbstractController
{
    protected $trickRepository;


    public function __construct(TrickRepository $trickRepository)
    {
        $this->trickRepository = $trickRepository;
    }

    public function TrickNameCheck($name)
    {
        $trickExist = $this->trickRepository->findOneBy(['name' => $name]);
        if ($trickExist) {
            return false;
        } else {
            return true;
        }
    }

    public function TrickNameCheckUpdate($name,$slug)
    {
        $trickExist = $this->trickRepository->findBy(array('name' => $name));
        if ($slug == $name ) {
            return true;
        } elseif($trickExist) {
            return false;
        }
        else {
            return true;
    }
    }

}