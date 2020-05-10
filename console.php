<?php
// ----INCLUDE APIS------------------------------------
// Include our Website API
include ("api/api.inc.php");

// ----PAGE GENERATION LOGIC---------------------------
function createPage($pimgdir)
{
    $pc = jsonLoadConsole();
    $tci = dalfactoryCreateConsoleCarousel();
    $keyinformation = renderKeyInformation($pc);
    $tcarousel = renderCarousel($tci,$pimgdir);
    $tvideo = renderVideo();
    $tindepthreview = renderReview();
    
    $tcontent = <<<PAGE
    <ul class="breadcrumb ss_breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li class="active">Console Overview</li>
    </ul>
    {$tcarousel}
    <br>
    <div class="alert alert-dismissible alert-info">
        <button class="close" type="button" data-dismiss="alert">×</button>
        <h4>Welcome!</h4>
        <p>You can now read more about Nintendo <a href="nintendo.php"><u>here</u></a>.</p>
    </div>
    <div class="row">
        <div class="col-lg-6">
            {$tvideo}
        </div>
        <div class="col-lg-6">
            {$keyinformation}
        </div>
    </div>
    {$tindepthreview}
PAGE;
    return $tcontent;
}

//----BUSINESS LOGIC---------------------------------
//Start up a PHP Session for this user.
session_start();

$tpagetitle = "Console Overview";
$tpage = new MasterPage($tpagetitle);
$timgdir = $tpage->getPage()->getDirImages();

//Build up our Dynamic Content Items.
$tpagelead  = "";
$tcurrpage = "";
$tpagecontent = createPage($timgdir,$tcurrpage);
$tpagefooter = "";

//----BUILD OUR HTML PAGE----------------------------
//Set the Three Dynamic Areas (1 and 3 have defaults)
if(!empty($tpagelead))
    $tpage->setDynamic1($tpagelead);
    $tpage->setDynamic2($tpagecontent);
    if(!empty($tpagefooter))
        $tpage->setDynamic3($tpagefooter);
        //Return the Dynamic Page to the user.
        $tpage->renderPage();
?>