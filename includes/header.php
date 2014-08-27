<?php
session_start();
$ProfileViewerURL = 'userProfile.php';
include 'Database.php';
include 'functions.php';
$db = Database::getInstance();
$db->setParameters('localhost', 'reaths3_caspia', 'teamcaspia', 'reaths3_caspia');
$connection = $db->getConnection();
mysqli_query($connection, 'SET NAMES utf8');
mb_internal_encoding('UTF-8');
if (!$connection) {
    echo 'Сриване на системата!!!';
    exit();
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?= $pageTitle ?></title>
    <meta charset="utf8">
    <link href="styles/SASS.css" rel="stylesheet"/>
    <link href="styles/ContactsSASS.css" rel="stylesheet"/>
    <link href="pictures/favicon.ico" rel="shortcut icon" type="image/x-icon">
</head>
<body>
<div id="wrapper">
    <header>
        <div class="upperHeader">
            <a id="heading" href="index.php">
                Saksia.bg
            </a>

            <div>
                Together for green future
            </div>
        </div>
        <div class="lowerHeader">
            <div class="loginForm">
                <?php
                $loginForm = '
                        <form method="post">
                        <label for="username">Username: </label> <input type="text" name="username-header"/>
                        <label for="password">Password: </label> <input type="password" name="password-header"/>
                        <input type="submit"/>
                        </form>';

                if (isset($_POST['logout'])) {
                    logout();
                }
                if (isset($_POST['username-header'])) {
                    try {
                        login($_POST['username-header'], $_POST['password-header']);
                    } catch (Exception $loginError) {
                        echo $loginError->getMessage();
                    }
                }
                if (isset($_SESSION['user_id'])) {
                    $user = getUser($_SESSION['user_id']);
                    echo '<form method="post">' .
                        'Welcome <a href="viewProfile.php">' . $user['user_login'] . '</a>' .
                        '<input type="hidden" name="logout" value="logout">   <input type="submit" value="Log Out"></form>';
                } else {
                    echo $loginForm;
                }
                ?>
            </div>
            <div class="headerReg">
                <?php
                if (!isset($_SESSION['user_id'])) {
                    echo '<a href="register.php">Регистрирай се тук</a>  ';
                }
                ?>
                <div>
                    <form method="post" action="search.php">
                        <input type="search" name="search"/> <input type="submit" value="Search"/>
                    </form>
                </div>
            </div>
        </div>
    </header>
    <div id="content">
        <section>

