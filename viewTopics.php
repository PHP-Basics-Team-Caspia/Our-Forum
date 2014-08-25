<?php
include_once('includes/header.php');
$showedContentLength = 20;
echo '<a href="index.php">Go Home</a><br/>';
try {
    //Get Topics
    $allTopics = getTopics($_GET['catid']);

    //Upper Information Table
    echo '
    <table border="1">
     <tr>
        <th>Created On</th><th>Author</th><th>Title</th><th>Content</th><th>Tags</th><th>Views</th><th>Votes</th>
     </tr>';

//Print All Topics
    foreach ($allTopics as $currTopic) {
            $id = $currTopic['question_id'];
            $creator = getUser($currTopic['question_creatorID']);
            $createdOn = date('d-m-Y H:m', strtotime($currTopic['question_created']));
            $title = $currTopic['question_title'];
            $content = substr($currTopic['question_content'], 0, $showedContentLength) . '...';
            $tags = $currTopic['question_tags'];
            $views = $currTopic['question_views'];
            $votes = $currTopic['question_votes'];

            echo '<tr>';

            echo "
        <td>{$createdOn}</td>
        <td><a href=\"{$ProfileViewerURL}?userid={$creator['user_id']}\">{$creator['user_login']}</a></td>
        <td><a href=\"viewTopic.php?id={$id}\">{$title}</a></td>
        <td>{$content}</td>
        <td>{$tags}</td>
        <td>{$views}</td>
        <td>{$votes}</td>";


            echo ' </tr > ';
    }
    echo '</table >';
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
    echo '<a href="index.php">Go home </a>';
}