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
     * @param $id null for create operation, value for update operation
     * @param $name 
     * @param $description 
     * @return id of the exhibition
     */
    public function createOrUpdateExhibition($id, $name, $description);

}