<?php


namespace App\Exhibition;


interface ExhibitionRepository
{

    /**
     * @param $id
     * @return void
     */
    public function deleteExhibitionById($id);

}