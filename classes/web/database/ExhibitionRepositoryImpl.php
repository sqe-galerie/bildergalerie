<?php


class ExhibitionRepositoryImpl implements \App\Exhibition\ExhibitionRepository
{
    private $dao;

    /**
     * ExhibitionRepositoryImpl constructor.
     * @param GaleryMysql $dbConn
     * @param Mandant $mandant
     */
    public function __construct(GaleryMysql $dbConn, Mandant $mandant)
    {
        $this->dao = new CategoryDAO($dbConn, $mandant);
    }


    /**
     * @param $id
     * @return void
     */
    public function deleteExhibitionById($id)
    {
        $this->dao->deleteCateogry($id);
    }

}