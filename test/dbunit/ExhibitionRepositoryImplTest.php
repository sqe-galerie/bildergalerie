<?php
require(__DIR__ . '/DbTestCase.php');

use PHPUnit\DbUnit\TestCaseTrait;

class ExhibitionRepositoryImplTest extends DbTestCase
{
    use TestCaseTrait;

    const TABLE = 'galery_categories';

    /** @var \App\Exhibition\ExhibitionRepository */
    private $exhibitionRepo = null;

    /**
     * @return \PHPUnit\DbUnit\DataSet\FlatXmlDataSet
     */
    public function getDataSet()
    {
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/fixtures/exhibition-seed.xml');
    }

    /**
     * @before
     */
    public function setupTestObject()
    {

        $mandant = new Mandant(1);
        $galeryDbConnection = new GaleryMysql(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
        $this->exhibitionRepo = new ExhibitionRepositoryImpl($galeryDbConnection, $mandant);
    }


    public function testDeleteShouldRemoveOneEntry()
    {
        $this->assertEquals(2, $this->getConnection()->getRowCount(self::TABLE), "Pre-Condition");

        $this->exhibitionRepo->deleteExhibitionById(2);

        $this->assertEquals(1, $this->getConnection()->getRowCount(self::TABLE), "Inserting failed");
    }

    public function testGetShouldReturnTheDesiredExhibition()
    {
        $this->assertEquals(2, $this->getConnection()->getRowCount(self::TABLE), "Pre-Condition");

        /** @var Category $exhibition */
        $exhibition = $this->exhibitionRepo->getExhibition(1);
        $this->assertEquals('Ausstellung 1', $exhibition->getCategoryName());
    }


}