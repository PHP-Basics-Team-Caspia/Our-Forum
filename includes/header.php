<?php
session_start();
$ProfileViewerURL = 'userProfile.php';
include 'patterns/Database.php';
include 'functions.php';
$db=Database::getInstance();
$db->setParameters('localhost','reaths3_caspia','teamcaspia','reaths3_caspia');
$connection = $db->getConnection();
mysqli_query($connection,'SET NAMES utf8');
mb_internal_encoding('UTF-8');
if(!$connection){
    echo 'Сриване на системата!!!';
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?= $pageTitle;?></title>
        <meta charset="UTF-8">
    </head>
    <body>
        