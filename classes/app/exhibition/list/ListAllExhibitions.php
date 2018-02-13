<?php

namespace App\Exhibition\ListAll;

use App\Exhibition\ExhibitionRepository;
use App\Utils\InvalidArgumentException;

class ListAllExhibitions
{

    /**
     * @var ExhibitionRepository
     */
    private $exhibitionRepository;

    /**
     * DeleteExhibition constructor.
     * @param ExhibitionRepository $repository
     */
    public function __construct(ExhibitionRepository $repository)
    {
        $this->exhibitionRepository = $repository;
    }

    public function listAll($request) {
        if (!isset($request->mandant)) {
            throw new InvalidArgumentException("Mandant id required");
        }

        return $this->exhibitionRepository->listAllExhibitions($request->mandant, $request->limit);
    }
}