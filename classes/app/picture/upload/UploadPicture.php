<?php

namespace App\Picture\Upload;

use App\Picture\PictureRepository;

class UploadPicture
{

    private $pictureRepository;

    public function __construct(PictureRepository $repository)
    {
        $this->pictureRepository = $repository;
    }

    public function upload(Request $request)
    {
        $response = new Response();
        if(!is_dir($request->dirName)){
            mkdir($request->dirName);
        }
        $picUploader = new \PictureUploader($request->file, $request->dirName);
        if(!$picUploader->uploadFile()){
            $response->success = false;
            return $response;
        }

        $picturePath = new \PicturePath($request->mandant, null, $picUploader->getUploadedFilePath(),
            $picUploader->getThumbFilePath(), $request->loggedInUser);
        $picPathId = $this->pictureRepository->uploadPicture($picturePath);
        if($picPathId != null){
            $response->picPathId = $picPathId;
            $response->filePath = $picUploader->getUploadedFilePath();
            $response->thumbPath = $picUploader->getThumbFilePath();
            $response->success = true;
            return $response;
        } else {
            $picUploader->deleteUploadedFiles();
            $response->success = false;
            return $response;
        }
    }
}