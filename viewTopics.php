<?php
include_once('includes/header.php');
if (!(isset($_GET['catid'])) || empty($_GET['catid'])) {
    echo 'Invalid Category. <a href="index.php">Go Back</a>';
    return;
}
$currCategoryDB = mysqli_query($connection, 'SELECT * FROM `categories` WHERE `category_ID` = ' . $_GET['catid']);
if ($currCategoryDB->num_rows == 0) {
    echo 'Invalid Category. <a href="index.php">Go Back</a>';
    return;
}
$currCategory = $currCategoryDB->fetch_assoc();
$currCategoryID = $currCategory['category_ID'];

$allTopicsDB = mysqli_query($connection, "SELECT * FROM `questions` WHERE `question_categoryID` = $currCategoryID");
$allTopics = array();
while ($Topic = $allTopicsDB->fetch_assoc()) {
    $allTopics[] = $Topic;
}
if (sizeof($allTopics) == 0) {
    echo 'No topics in this category. <a href="index.php">Go Back</a>';
} else {
    echo '
    <table border="1">
     <tr>
        <th>Created On</th><th>Author</th><th>Title</th><th>Content</th><th>Tags</th><th>Views</th><th>Votes</th>
     </tr>';
    foreach ($allTopics as $currTopic) {
        $creator = mysqli_query($connection, 'SELECT `user_login` FROM `users` WHERE user_id =' . $currTopic['question_creatorID']);
        $creator = $creator->fetch_row();
        echo '<tr>';

        echo "
        <td>{$currTopic['question_created']}</td>
        <td>$creator[0]</td>
        <td>{$currTopic['question_title']}</td>
        <td>{$currTopic['question_content']}</td>
        <td>{$currTopic['question_tags']}</td>
        <td>{$currTopic['question_views']}</td>
        <td>{$currTopic['question_votes']}</td>";


        echo ' </tr > ';
    }
    echo '</table > ';
}