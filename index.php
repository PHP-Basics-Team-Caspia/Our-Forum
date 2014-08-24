<?php
mb_internal_encoding('UTF-8');
$pageTitle = 'ФОРУМ';
include 'includes/header.php';
var_dump($_SESSION); echo "\n<br/>";
$categories = getCategories();
foreach ($categories as $category) {
    echo '<a href="viewTopics.php?catid=' . $category['category_ID'] . '">' . $category['category_name'] . '</a><br/>';
}
