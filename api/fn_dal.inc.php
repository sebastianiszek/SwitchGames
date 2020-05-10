<?php

// Include the Class Include
require_once ("oo_bll.inc.php");
require_once ("oo_pl.inc.php");

//---------JSON HELPER FUNCTIONS-------------------------------------------------------

function jsonOne($pfile,$pid)
{
    $tsplfile = new SplFileObject($pfile);
    $tsplfile->seek($pid-1);
    $tdata = json_decode($tsplfile->current());
    return $tdata;
}

function jsonAll($pfile)
{
    $tentries = file($pfile);
    $tarray = [];
    foreach($tentries as $tentry)
    {
        $tarray[] = json_decode($tentry);
    }
    return $tarray;
}

function jsonNextID($pfile)
{
    $tsplfile = new SplFileObject($pfile);
    $tsplfile->seek(PHP_INT_MAX);
    return $tsplfile->key() + 1;
}

//---------JSON-DRIVEN OBJECT CREATION FUNCTIONS-----------------------------------------

function jsonLoadConsole() : BLLConsole
{
    $tconsole = new BLLConsole();
    $tconsole->fromArray(jsonOne("data/console.json",1));
    return $tconsole;
}

function jsonLoadOneGame($pid) : BLLGame
{
    $tgame = new BLLGame();
    $tgame->fromArray(jsonOne("data/games.json",$pid));
    return $tgame;
}

function jsonLoadOneReview($pid) : BLLReview
{
    $treview = new BLLReview();
    $treview->fromArray(jsonOne("data/reviews.json",$pid));
    return $treview;
}

function dalfactoryCreateConsoleCarousel(): array
{
    $tcarouselitems = [];
    $tcarouselitems[] = new PLCarouselImage("switchg1.png", "Switch Overview", "Your Nintendo Switch Glossary");
    $tcarouselitems[] = new PLCarouselImage("switchg2.png", "Switch Overview", "Your Nintendo Switch Glossary");
    return $tcarouselitems;
}

//--------------MANY OBJECT IMPLEMENTATION--------------------------------------------------------

function jsonLoadAllGames() : array
{
    $tarray = jsonAll("data/games.json");
    return array_map(function($a){ $tc = new BLLGame(); $tc->fromArray($a); return $tc; },$tarray);
}

function jsonLoadAllReviews() : array
{
    $tarray = jsonAll("data/reviews.json");
    return array_map(function($a){ $tc = new BLLReview(); $tc->fromArray($a); return $tc; },$tarray);
}

function jsonLoadAllExternalReviews() : array
{
    $tarray = jsonAll("data/externalreviews.json");
    return array_map(function($a){ $tc = new BLLExternalReview(); $tc->fromArray($a); return $tc; },$tarray);
}

function jsonLoadAllRetailers() : array
{
    $tarray = jsonAll("data/retailers.json");
    return array_map(function($a){ $tc = new BLLRetailer(); $tc->fromArray($a); return $tc; },$tarray);
}

function jsonLoadAllUserReviews() : array
{
    $tarray = jsonAll("data/userreviews.json");
    return array_map(function($a){ $tc = new BLLUserReview(); $tc->fromArray($a); return $tc; },$tarray);
}
?>