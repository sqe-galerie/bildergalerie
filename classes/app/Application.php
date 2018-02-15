<?php


namespace App;


interface Application
{

    /**
     * @return Exhibition\ExhibitionBoundary
     */
    public function getExhibitionBoundary();

    public function getPictureBoundary();

}