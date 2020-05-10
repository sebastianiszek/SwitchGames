<?php 
//----INCLUDE APIS------------------------------------
include("api/api.inc.php");

//----PAGE GENERATION LOGIC---------------------------

function createPage($pgames)
{
    $tquote = renderQuote();
    $tgameprofile = "";
    foreach($pgames as $tg)
    {
        if ($tg->id == 2 || $tg->id == 6 || $tg->id == 5) {
        $tgameprofile .= renderGameSummary($tg);
        }
    }
$tcontent = <<<PAGE
    {$tquote}
    {$tgameprofile}
PAGE;
    return $tcontent;
}

// ----BUSINESS LOGIC---------------------------------
// Start up a PHP Session for this user.
session_start();

//Load games
$tgames = jsonLoadAllGames();

//Build up our Dynamic Content Items. 
$tpagetitle = "Home Page";
$tpagelead  = "<h1>Welcome to Switch Game Reviews</h1>";
$tpagecontent = createPage($tgames);
$tpagefooter = "";

//----BUILD OUR HTML PAGE----------------------------
//Create an instance of our Page class
$tpage = new MasterPage($tpagetitle);
//Set the Three Dynamic Areas (1 and 3 have defaults)
if(!empty($tpagelead))
    $tpage->setDynamic1($tpagelead);
$tpage->setDynamic2($tpagecontent);
if(!empty($tpagefooter))
    $tpage->setDynamic3($tpagefooter);
//Return the Dynamic Page to the user.    
$tpage->renderPage();

?>