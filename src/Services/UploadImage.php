<?php

namespace App\Services;

class UploadImage
{
    public function imageRegister($file)
    {

        $name = md5(uniqid()).'.'.$file->guessExtension();

        $path ='uploads/tricks' ;
        $file->move($path,$name);

        return $name;

    }

    public function profilImageRegister($file)
    {
        $name = md5(uniqid()).'.'.$file->guessExtension();

        $path ='uploads/profil' ;
        $file->move($path,$name);


        return $name;
    }

}