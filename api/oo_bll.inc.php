<?php

class BLLConsole
{
    //-------CLASS FIELDS------------------
    public $consolename;
    public $retailer;
    public $price;
    public $releasedate;
    public $description;
    
    //-------CONSTRUCTOR--------------------
    public function fromArray(stdClass $passoc)
    {
        foreach($passoc as $tkey => $tvalue)
        {
            $this->{$tkey} = $tvalue;
        }
    }
}

class BLLGame
{
    //-------CLASS FIELDS------------------
    public $id = null;
    public $gamename;
    public $score;
    public $developer;
    public $genres;
    public $multiplayer;
    
    //-------CONSTRUCTOR--------------------
    public function fromArray(stdClass $passoc)
    {
        foreach($passoc as $tkey => $tvalue)
        {
            $this->{$tkey} = $tvalue;
        }
    }
}

class BLLReview
{
    //-------CLASS FIELDS------------------
    public $id = null;
    public $review;
    
    //-------CONSTRUCTOR--------------------
    public function fromArray(stdClass $passoc)
    {
        foreach($passoc as $tkey => $tvalue)
        {
            $this->{$tkey} = $tvalue;
        }
    }
}

class BLLExternalReview
{
    //-------CLASS FIELDS------------------
    public $id = null;
    public $refid;
    public $reviewer;
    public $score;
    public $link;
    
    //-------CONSTRUCTOR--------------------
    public function fromArray(stdClass $passoc)
    {
        foreach($passoc as $tkey => $tvalue)
        {
            $this->{$tkey} = $tvalue;
        }
    }
}

class BLLRetailer
{
    //-------CLASS FIELDS------------------
    public $id = null;
    public $refid;
    public $retailer;
    public $price;
    public $link;
    
    //-------CONSTRUCTOR--------------------
    public function fromArray(stdClass $passoc)
    {
        foreach($passoc as $tkey => $tvalue)
        {
            $this->{$tkey} = $tvalue;
        }
    }
}

class BLLUserReview
{
    //-------CLASS FIELDS------------------
    public $id = null;
    public $refid;
    public $email;
    public $rating;
    public $review;
    
    //-------CONSTRUCTOR--------------------
    public function fromArray(stdClass $passoc)
    {
        foreach($passoc as $tkey => $tvalue)
        {
            $this->{$tkey} = $tvalue;
        }
    }
}
?>