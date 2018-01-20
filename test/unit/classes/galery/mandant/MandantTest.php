<?php
/**
 * Created by PhpStorm.
 * User: Frederic Welsch
 * Date: 18.01.2018
 * Time: 17:28
 */
use PHPUnit\Framework\TestCase;

class MandantTest extends TestCase {
    public function testGetPageTitle() {
        $mandant = new Mandant(4711, "TestTitle", "TestGalery");
        $this->assertEquals("TestTitle", $mandant->getPageTitle());
    }
}