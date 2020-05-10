<?php

require_once("oo_bll.inc.php");

////////////////////////////////
// Redirect To Error Page
////////////////////////////////
function appGoToError()
{
    header("Location: app_error.php");
}

function processRequest($pdata)
{
    $tdata = trim($pdata);
    $tdata = stripslashes($tdata);
    $tdata = htmlspecialchars($tdata);
    return $tdata;
}

function processFormData($pdata)
{
    $tclean = $pdata ?? "";
    if (!empty($tclean))
    {
        $tclean = trim($tclean);
        $tclean = stripslashes($tclean);
        $tclean = htmlspecialchars($tclean);
    }
    return $tclean;
}

function nullAsEmpty(array &$pdata, $tkey)
{
    $pdata[$tkey] = $pdata[$tkey] ?? "";
}

function paginateArray(array $parray,$ppageno,$pnoitems)
{
        $tpageno = $ppageno < 1 ? 1 : $ppageno;
        $tstart = ($tpageno - 1) * $pnoitems;
        return array_slice($parray, $tstart, $pnoitems);
}

function initSessionData()
{
    $tsession = ["name","last-access","fav-club"];
    foreach($tsession as $tsessionkey)
    {
        $_SESSION[$tsessionkey] = "";
    }
}

function destroySession()
{
    //Do we need to do all of this?
    $tsession = ["name","last-access","fav-club"];
    foreach($tsession as $tsessionkey)
    {
        if(isset($_SESSION[$tsessionkey]))
            unset($_SESSION[$tsessionkey]);
            
    }
    //Call Session Unset
    session_unset();
    //Make a call to session destroy
    session_destroy();
}
    
?>