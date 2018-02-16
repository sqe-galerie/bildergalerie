<?php


use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

class ExhibitionRepositoryImplTest extends TestCase
{
    use TestCaseTrait;

    // only instantiate pdo once for test clean-up/fixture load
    static private $pdo = null;

    // only instantiate PHPUnit_Extensions_Database_DB_IDatabaseConnection once per test
    private $conn = null;

    final public function getConnection()
    {
        if ($this->conn === null) {
            if (self::$pdo == null) {
                $dsn = 'mysql:host=5.5.5.5;dbname=sqe_bildergalerie';
                self::$pdo = new PDO($dsn, 'homestead', 'secret' );
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, 'sqe_bildergalerie');
        }

        return $this->conn;
    }

    /**
     * @return \PHPUnit\DbUnit\DataSet\FlatXmlDataSet
     */
    public function getDataSet()
    {
        return $this->createFlatXMLDataSet(dirname(__FILE__).'/fixtures/exhibition-seed.xml');
    }

    public function testAddEntry()
    {
        $this->assertEquals(2, $this->getConnection()->getRowCount('galery_categories'), "Pre-Condition");

        $mandant = new Mandant(1);
        $galeryDbConnection = new GaleryMysql('5.5.5.5', 'homestead', 'secret', 'sqe_bildergalerie');
        $exhibitionRepoImpl = new ExhibitionRepositoryImpl($galeryDbConnection, $mandant);

        $exhibitionRepoImpl->deleteExhibitionById(2);

        $this->assertEquals(1, $this->getConnection()->getRowCount('galery_categories'), "Inserting failed");
    }

}