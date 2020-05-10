<?php
// ----INCLUDE APIS------------------------------------
// Include our Website API
include ("api/api.inc.php");

// ----PAGE GENERATION LOGIC---------------------------
function createPage($pgame, $preview, $pid, $pexternalreviewslist, $pretailerslist, $puserreviewslist)
{
    $tgameprofile = renderGameOverview($pgame);
    $tgamename = $pgame->gamename;
    
    $tgamereview = renderGameReview($preview);
    $texternalreviews = renderExternalReviews($pexternalreviewslist, $pid);
    $tretailers = renderRetailers($pretailerslist, $pid);
    $tuserreviews = renderUserReviews($puserreviewslist, $pid);
    
    $tuserreviews;
    $tcontent = <<<PAGE
    <ul class="breadcrumb ss_breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li><a href="ranking.php">Ranking</a></li>
        <li class="active">{$tgamename}</li>
    </ul>
    {$tgameprofile}
    {$tgamereview}
    {$texternalreviews}
    {$tretailers}
    {$tuserreviews}
PAGE;
    return $tcontent;
}

// ----BUSINESS LOGIC---------------------------------
// Start up a PHP Session for this user.
session_start();

//Use our Data Access Layer to create our Game List
$tgames = [];
$tid = $_REQUEST["id"] ?? -1;

$texternalreviewslist = jsonLoadAllExternalReviews();
$tretailerslist = jsonLoadAllRetailers();
$tuserreviewslist = jsonLoadAllUserReviews();
$tallgames = jsonLoadAllGames();

//Handle our Requests and Search for Games
if (is_numeric($tid) && $tid > 0 && $tid < count($tallgames)+1)
{
    $tgame = jsonLoadOneGame($tid);
    $treview = jsonLoadOneReview($tid);
    $tgames[] = $tgame;
}

//Page Decision Logic - Have we found our game?
if (count($tgames)===0)
{
    header("Location: app_error.php");
}
else
{
    //We've found our game
    $tpagecontent = createPage($tgame, $treview, $tid, $texternalreviewslist, $tretailerslist, $tuserreviewslist);
    
    $tpagetitle = "Game Page";
    $tpagelead = "";
    $tpagefooter = "";
    
    // ----BUILD OUR HTML PAGE----------------------------
    // Create an instance of our Page class
    $tpage = new MasterPage($tpagetitle);
    // Set the Three Dynamic Areas (1 and 3 have defaults)
    if (! empty($tpagelead))
        $tpage->setDynamic1($tpagelead);
        $tpage->setDynamic2($tpagecontent);
        if (! empty($tpagefooter))
            $tpage->setDynamic3($tpagefooter);
            // Return the Dynamic Page to the user.
            $tpage->renderPage();
}
?>