<?php

namespace App\Picture\Create;

use App\Picture\PictureRepository;
use App\Utils\Authenticator;
use App\Utils\NotAuthorizedException;
use PHPUnit\Framework\TestCase;

class CreatePictureTest extends TestCase
{
    private $createInteractor;

    private $authenticatorStub;

    private $repositoryStub;

    private $userStub;
    private $mandantStub;

    public function setupTestobject()
    {
        $this->authenticatorStub = $this->createMock(Authenticator::class);
        $this->repositoryStub = $this->createMock(PictureRepository::class);
        $this->userStub = $this->createMock(\User::class);
        $this->mandantStub = $this->createMock(\Mandant::class);

        $this->createInteractor = new CreatePicture($this->authenticatorStub, $this->repositoryStub);
    }

    public function testCreateShouldThrowIfNotAuthorized()
    {
        $this->expectException(NotAuthorizedException::class);
        $this->createInteractor->create(new Request());
    }

    public function testShouldCallCreatePictureMethodOfRepository()
    {
        $this->setIsAuthorized();
        $this->repositoryStub
            ->expects($this->once())
            ->method('createPicture')
            ->with($this->equalTo(new \Picture($this->mandantStub, null, "Ein Gemälde", "Eine Beschreibung", null, "Das Material", null, null, null,
                "/uploads/1/image001.png", null, null, $this->userStub, $this->userStub, null, null)));
        $request = new Request();
        $request->title = "Ein Gemälde";
        $request->tags = null;
        $request->descr = "Eine Beschreibung";
        $request->material = "Das Material";
        $request->picPathId = "/uploads/1/image001.png";
        $request->uploadedBy = $this->userStub;
        $request->owner = $this->userStub;
        $request->mandant = $this->mandantStub;
        $this->createInteractor->create($request);
    }

    private function setIsAuthorized()
    {
        $this->authenticatorStub
            ->method('isAuthenticated')
            ->willReturn(true);
    }
}