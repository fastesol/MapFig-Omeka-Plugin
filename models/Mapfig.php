<?php

class Mapfig extends Omeka_Record_AbstractRecord
{
    public $id;
    public $name = "My Map";
    public $width = 600;
    public $height = 500;
    public $zoom = 2;
    public $baselayer;
    public $layergroup;
    public $pointers;
}