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
     * @throws Exception
     * @throws SimpleUserErrorException
     */
    public function deleteExhibitionById($id)
    {
        $this->dao->deleteCateogry($id);
    }

    /**
     * @param $mandant
     * @param $limit
     * @return mixed
     */
    public function listAllExhibitions($mandant, $limit)
    {
        return $this->dao->getCategoryTeasers($limit);
    }

    /**
     * @param $id
     * @return Category
     */
    public function getExhibition($id)
    {
        return $this->dao->getCategoryById($id);
    }
}