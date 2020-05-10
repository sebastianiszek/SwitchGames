<?php
// -------------------- This page is my additional functionality --------------------

// ----INCLUDE APIS------------------------------------
// Include our Website API
include ("api/api.inc.php");

// ----PAGE GENERATION LOGIC---------------------------
function createPage()
{
    $tkeyinformation = renderNintendoKeyInformation();
    $ttabs = renderNintendoTabs();
    $tcontent = <<<PAGE
    <ul class="breadcrumb ss_breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li><a href="console.php">Console Overview</a></li>
        <li class="active">Nintendo</li>
    </ul>
    {$tkeyinformation}
    {$ttabs}
PAGE;
    return $tcontent;
}

// ----BUSINESS LOGIC---------------------------------
// Start up a PHP Session for this user.
session_start();

$tpagecontent = createPage();

$tpagetitle = "Nintendo";
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
        
?>