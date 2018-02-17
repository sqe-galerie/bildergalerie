<?php

namespace App\Picture\Create;

class Request
{
    public $title;
    public $tags;
    public $descr;
    public $material;
    public $picPathId;
    public $picPath;
    public $picPathThumb;
    /**
     * @var int[]
     */
    public $categoryIds;
    public $mandant;
    public $uploadedBy;
    public $owner;
    public $edit;
    public $editPicId;
}