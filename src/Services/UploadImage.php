<?php

namespace App\Services;

use App\Entity\Image;

class UploadImage
{
    public function imageRegister($file)
    {

        $name = md5(uniqid()).'.'.$file->guessExtension();

        $path ='uploads/tricks' ;
        $file->move($path,$name);

        return $name;




    }

}