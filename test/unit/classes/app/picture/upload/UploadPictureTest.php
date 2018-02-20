<?php

namespace App\Picture\Upload;

use App\Picture\PictureRepository;
use PHPUnit\Framework\TestCase;

class UploadPictureTest extends TestCase
{
    /** @var UploadPicture */
    private $uploadInteractor;

    /** @var PictureRepository */
    private $repositoryStub;

    /**
     * @before
     */
    public function setupTestobject()
    {
        $this->repositoryStub = $this->createMock(PictureRepository::class);
        $this->uploadInteractor = new UploadPicture($this->repositoryStub);
    }



}