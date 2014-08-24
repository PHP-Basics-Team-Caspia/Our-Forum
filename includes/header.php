<?php
session_start();
include 'patterns/Database.php';
$db=Database::getInstance();
$db->setParameters('localhost','reaths3_caspia','teamcaspia','reaths3_caspia');
$connection=$db->getConnection();
mysqli_query($connection,'SET NAMES utf8');
mb_internal_encoding('UTF-8');
if(!$connection){
    echo 'Сриване на системата!!!';
    exit();
}
$caregories=array(1=>'1',2=>'2',3=>'3');
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?= $pageTitle;?></title>
        <meta charset="UTF-8">
    </head>
    <body>
        