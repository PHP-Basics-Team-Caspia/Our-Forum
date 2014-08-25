<?php
mb_internal_encoding('UTF-8');
$pageTitle = 'ФОРУМ';
include 'includes/header.php';
var_dump($_SESSION); echo "\n<br/>";
$categories = getCategories();
foreach ($categories as $category) {
    echo '<a href="viewTopics.php?catid=' . $category['category_ID'] . '">' . $category['category_name'] . '</a><br/>';
}
try {
    $allTopics = getTopics();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
foreach ($allTopics as $topic) {
    echo $topic['question_title'] . "<br/>";
}
?>