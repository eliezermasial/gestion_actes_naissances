<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'controller/ControllerCertificat.php';

if(!isset($_GET["id"]) || empty($_GET["id"]) ){
    header("index.php");
}
$id=$_GET["id"];
$certificat= post_certificat($id);

var_dump($certificat);
?>