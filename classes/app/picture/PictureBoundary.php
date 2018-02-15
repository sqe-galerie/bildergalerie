<?php

namespace App\Picture;

use App\Utils\Authenticator;

class PictureBoundary
{

    private $authenticator;
    private $pictureRepository;

    public function __construct(Authenticator $authenticator, PictureRepository $pictureRepository)
    {
        $this->authenticator = $authenticator;
        $this->pictureRepository = $pictureRepository;
    }

    public function createPicture(Create\Request $request)
    {
        $createPicture = new Create\CreatePicture($this->authenticator, $this->pictureRepository);
        $success = $createPicture->create($request);
        return $success;
    }

    public function uploadPicture(Upload\Request $request)
    {
        $uploadPicture = new Upload\UploadPicture($this->pictureRepository);
        return $uploadPicture->upload($request);
    }

}