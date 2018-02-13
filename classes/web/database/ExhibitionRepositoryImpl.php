<?php


class ExhibitionRepositoryImpl implements \App\Exhibition\ExhibitionRepository
{ 
    private $dao;
    private $mandant;

    /**
     * ExhibitionRepositoryImpl constructor.
     * @param GaleryMysql $dbConn
     * @param Mandant $mandant
     */
    public function __construct(GaleryMysql $dbConn, Mandant $mandant)
    {
        $this->dao = new CategoryDAO($dbConn, $mandant);
        $this->mandant = $mandant;
    }


    /**
     * @param $id
     * @return void
     */
    public function deleteExhibitionById($id)
    {
        $this->dao->deleteCateogry($id);
    }
  
 
    public function createOrUpdateExhibition($id, $name, $description)
    { 
        $category = new Category($this->mandant, $id, $name, $description ); 
        if (null != $id) {
            $this->dao->updateCategory($category); 
            $catId = $id;
        } else {
            $catId = $this->dao->createCategory($category); 
        } 
        if ($catId  == false) { 
            throw new Exception("Kategorie konnte nicht angelegt oder aktualisiert werden");
        }
        return $catId ;
    }


}