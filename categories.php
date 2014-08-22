<?php
include_once('includes/header.php');
$categories = getCategories($connection);
function getCategories($connection) {
    $categories = array();
    $categoriesDB = mysqli_query($connection, 'SELECT * FROM `categories`');

    while ($row = $categoriesDB->fetch_assoc()) {
        $categories[$row['category_ID']] = $row['category_name'];
    }
    return $categories;
}
