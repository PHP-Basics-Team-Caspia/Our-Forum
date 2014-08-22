<?php
session_start();
date_default_timezone_set('Europe/Sofia');
$connection=mysqli_connect('localhost','reaths3_caspia','teamcaspia','reaths3_caspia');
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
        