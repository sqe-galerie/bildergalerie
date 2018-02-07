<?php


namespace App;


interface Application
{

    /**
     * @return Exhibition\ExhibitionBoundary
     */
    public function getExhibitionBoundary();

}