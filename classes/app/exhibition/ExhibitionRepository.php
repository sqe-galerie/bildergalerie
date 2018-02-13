<?php


namespace App\Exhibition;


interface ExhibitionRepository
{

    /**
     * @param $id
     * @return void
     */
    public function deleteExhibitionById($id);

    /**
     * @param $mandant
     * @param $limit
     * @return mixed
     */
    public function listAllExhibitions($mandant, $limit);

}