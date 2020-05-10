<?php

class PLCarouselImage
{
    //-------CLASS FIELDS------------------
    public $imgref;
    public $title;
    public $lead;
    
    //-------CONSTRUCTOR--------------------
    public function __construct($pimgref,$ptitle,$plead)
    {
        $this->imgref = $pimgref;
        $this->title  = $ptitle;
        $this->lead   = $plead;
    }
}


?>