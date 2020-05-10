<?php 
//----INCLUDE APIS------------------------------------
include("api/api.inc.php");

//----BUSINESS LOGIC---------------------------------
//Start up a PHP Session for this user.
session_start();
$tmyname = $_REQUEST["myname"] ?? "";
$tlogintoken = $_SESSION["myuser"] ?? "";

if(empty($tlogintoken) && !empty($tmyname))
{
    $_SESSION["myuser"] = processRequest($tmyname);
    $_SESSION["entered"] = true;
    header("Location: index.php");
}
else {
    $terror = "app_error.php";
    header("Location: {$terror}");
}
?>