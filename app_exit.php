<?php 
//----INCLUDE APIS------------------------------------
include("api/api.inc.php");

//----BUSINESS LOGIC---------------------------------
//Start up a PHP Session for this user.
session_start();

$taction = $_REQUEST["action"] ?? "";
$tlogintoken = $_SESSION["myuser"] ?? "";
if($taction == "exit" && !empty($tlogintoken))
{
    unset($_SESSION["myuser"]);
    unset($_SESSION["entered"]);
    session_unset();
    session_destroy();
    header("Location: index.php");
}
else 
{
    header("Location: app_error.php");
}

?>