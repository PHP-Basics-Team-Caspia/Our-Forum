<?php
mb_internal_encoding('UTF-8');
$pageTitle = 'ФОРУМ';
include 'includes/header.php';
include_once 'categories.php';
var_dump($_SESSION); echo "\n<br/>";
foreach ( $categories as $categoryID=>$categoryName ) {
    echo '<a href="viewTopics.php?catid=' . $categoryID . '">' . $categoryName . '</a><br/>';
}
