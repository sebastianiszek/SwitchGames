<?php
// ----INCLUDE APIS------------------------------------
// Include our Website API
include ("api/api.inc.php");

// ----PAGE GENERATION LOGIC---------------------------
function createPage($pgames)
{
    $ttable = renderTable($pgames);
    $tcontent = <<<PAGE
    <ul class="breadcrumb ss_breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li class="active">Ranking</li>
    </ul>
    {$ttable}
PAGE;
    return $tcontent;
}

// ----BUSINESS LOGIC---------------------------------
// Start up a PHP Session for this user.
session_start();

$tgames = jsonLoadAllGames();

$tpagecontent = createPage($tgames);

$tpagetitle = "Ranking";
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