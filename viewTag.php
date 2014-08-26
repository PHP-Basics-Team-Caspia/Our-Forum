<?php
include 'includes/header.php';
$showedContentLength = 20;
if (isset($_GET['name'])) {
    try {
        $topics = getTopicsWithTag($_GET['name']);
        echo '
    <table border="1">
        <tr>
            <th>Created On</th><th>Author</th><th>Title</th><th>Content</th><th>Tags</th><th>Views</th><th>Votes</th>
        </tr>';
        foreach ($topics as $topic) {
            $id = $topic['question_id'];
            $creator = getUser($topic['question_creatorID']);
            $createdOn = date('d-m-Y H:m', strtotime($topic['question_created']));
            $title = $topic['question_title'];
            $content = substr($topic['question_content'], 0, $showedContentLength) . '...';
            $tags = $topic['question_tags'];
            $tags = explode(', ', $tags);
            $views = $topic['question_views'];
            $votes = $topic['question_votes'];

            echo '<tr>';

            echo "
            <td>{$createdOn}</td>
            <td><a href=\"{$ProfileViewerURL}?userid={$creator['user_id']}\">{$creator['user_login']}</a></td>
            <td><a href=\"viewTopic.php?id={$id}\">{$title}</a></td>
            <td>{$content}</td>
            <td>";
            foreach($tags as $tag) {
                echo '<a href="viewTag.php?name=' . $tag . '">' . $tag . ' </a>';
            }
            echo "</td>
            <td>{$views}</td>
            <td>{$votes}</td>";

            echo ' </tr > ';
        }
        echo '</tr></table>';

    } catch (Exception $e) {
        echo $e->getMessage();
    }
} else {
    echo "No id";
}