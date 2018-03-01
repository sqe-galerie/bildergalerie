<?php

namespace App\Picture\Upload;

use App\Picture\PictureRepository;
use crodas\FileUtil\File;
use PHPUnit\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UploadPictureTest extends TestCase
{
    /** @var UploadPicture */
    private $uploadInteractor;

    /** @var PictureRepository | MockObject */
    private $repositoryStub;

    /**
     * @var \Mandant | MockObject
     */
    private $mandantStub;

    /**
     * @var \User | MockObject
     */
    private $userStub;

    /**
     * @before
     */
    public function setupTestobject()
    {
        $this->repositoryStub = $this->createMock(PictureRepository::class);
        $this->uploadInteractor = new UploadPicture($this->repositoryStub);
        $this->mandantStub = $this->createMock(\Mandant::class);
        $this->userStub = $this->createMock(\User::class);
    }

    public function testShouldCallUploadPictureMethodOfRepository()
    {
        $file = array(
            "tmp_name" => "test/unit/classes/app/picture/upload/twitter.png",
            "name" => "twitter"
        );
        $dir = "upload";
        $this->repositoryStub
            ->expects($this->once())
            ->method('uploadPicture');
        $request = new Request();
        $request->mandant = $this->mandantStub;
        $request->file = $file;
        $request->dirName = $dir;
        $request->loggedInUser = $this->userStub;
        $response = $this->uploadInteractor->upload($request);

    }



}