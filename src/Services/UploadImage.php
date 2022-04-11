<?php

namespace App\Services;

use App\Entity\Trick;

class UploadImage
{
    public function imageRegister($image)
    {

        $name = md5(uniqid()).'.'.$image->guessExtension();

        $path ='uploads/tricks' ;

        return $image->move($path,$name);




    }

}