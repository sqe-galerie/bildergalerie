<?php


namespace App\Utils;


interface Authenticator
{

    /**
     * @return bool
     */
    public function isAuthorized();

}