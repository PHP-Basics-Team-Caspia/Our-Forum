<?php
session_start();
$ProfileViewerURL = 'userProfile.php';
include 'Database.php';
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
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $pageTitle; ?></title>
    <meta charset="utf8">
    <link href="/Projects/CaspiaForum/styles/SASS.css" rel="stylesheet" />
    <link href="/pictures/avatars/favicon.ico" rel="shortcut icon" type="image/x-icon">
</head>
<body>
<div id="wrapper">
    <header>
        <div>
            <a href="index.php">
                Saksia.bg
            </a> <br />
                <span>
                    Together for green future
                </span>
        </div>
    </header>
    <div id="content">
        <section>

