<?php

namespace App\Exhibition\Get;

use App\Exhibition\ExhibitionRepository;
use App\Utils\InvalidArgumentException;

class GetExhibition
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

    /**
     * @param Request $request
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function get(Request $request)
    {
        if (!isset($request->id)) {
            throw new InvalidArgumentException("Exhibition id required");
        }

        return $this->exhibitionRepository->getExhibition($request->id);
    }
}