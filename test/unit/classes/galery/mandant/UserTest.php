<?php
/**
 * Created by PhpStorm.
 * User: Frederic Welsch
 * Date: 18.01.2018
 * Time: 18:10
 */
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase {
    public function testGetMandant() {
        $mandant = new Mandant(4711, "TestTitle", "TestGalery");
        $user = new User($mandant, 4712, "mmustermann", "mustermann",
            "max", "mmustermann@example.com");
        $this->assertEquals($mandant, $user->getMandant());
    }
}