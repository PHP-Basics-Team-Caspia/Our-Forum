<?php
$showedContentLength = 20;
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
    echo ' <a href="index.php">Go Back</a></br>';
    echo '
    <table border="1">
     <tr>
        <th>Created On</th><th>Author</th><th>Title</th><th>Content</th><th>Tags</th><th>Views</th><th>Votes</th>
     </tr>';
    foreach ($allTopics as $currTopic) {
        $id = $currTopic['question_id'];
        $creator = mysqli_query($connection, 'SELECT * FROM `users` WHERE user_id =' . $currTopic['question_creatorID']);
        $creator = $creator->fetch_assoc();
        $createdOn = date('d-m-Y H:m',strtotime($currTopic['question_created']));
        $title = $currTopic['question_content'];
        $content = substr($currTopic['question_content'],0, $showedContentLength).'...';
        $tags = $currTopic['question_tags'];
        $views = $currTopic['question_views'];
        $votes = $currTopic['question_votes'];
        echo '<tr>';

        echo "
        <td>{$createdOn}</td>
        <td><a href=\"{$ProfileViewerURL}?id={$creator['user_id']}\">{$creator['user_login']}</a></td>
        <td><a href=\"viewTopic.php?id={$id}\">{$title}</a></td>
        <td>{$content}</td>
        <td>{$tags}</td>
        <td>{$views}</td>
        <td>{$votes}</td>";


        echo ' </tr > ';
    }
    echo '</table > ';
}