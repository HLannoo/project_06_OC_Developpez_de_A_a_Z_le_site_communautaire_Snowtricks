<?php

namespace App\Services;


use Symfony\Component\HttpFoundation\File\File;

class UploadImage
{
    public function imageRegister(File $file)
    {

        $name = md5(uniqid()) . '.' . $file->guessExtension();

        $path = 'uploads/tricks';
        $file->move($path, $name);

        return $name;

    }

    public function profilImageRegister(File $file)
    {
        $name = md5(uniqid()) . '.' . $file->guessExtension();

        $path = 'uploads/profil';
        $file->move($path, $name);


        return $name;
    }

}