<?php


namespace App\Exhibition;


use App\Utils\Authenticator;

class ExhibitionBoundary
{

    /** @var  Authenticator */
    private $authenticator;
    /** @var  ExhibitionRepository */
    private $exhibitionRepository;

    /**
     * ExhibitionBoundary constructor.
     * @param Authenticator $authenticator
     * @param ExhibitionRepository $exhibitionRepository
     */
    public function __construct(Authenticator $authenticator, ExhibitionRepository $exhibitionRepository)
    {
        $this->authenticator = $authenticator;
        $this->exhibitionRepository = $exhibitionRepository;
    }


    public function deleteExhibition(Delete\Request $request)
    {
        $deleteExhibition = new Delete\DeleteExhibition($this->authenticator, $this->exhibitionRepository);
        $deleteExhibition->delete($request);
    }

    public function listAllExhibitions(ListAll\Request $request)
    {
        $listAllExhibition = new ListAll\ListAllExhibitions($this->exhibitionRepository);
        $response = new ListAll\Response();
        $response->exhibitions = $listAllExhibition->listAll($request);

        return $response;
    }

    public function getExhibition(Get\Request $request)
    {
        $getExhibition = new Get\GetExhibition($this->exhibitionRepository);
        $response = new Get\Response();
        $response->exhibition = $getExhibition->get($request);

        return $response;
    }
}