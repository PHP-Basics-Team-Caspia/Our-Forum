<?php
include_once('includes/header.php');

if($_POST) {
    addAnswer($_GET['id'], $_SESSION['user_id'], $_POST['content']);
}

try {
    $topic = getTopic($_GET['id']);
//Go back
    $category = getCategories($topic['question_categoryID']);
    echo "<a href=\"viewTopics.php?catid={$category['category_ID']}\">Go back to {$category['category_name']}</a>" . '<br/>';
//Print out the topic
    try {
        $topicCreator = getUser($topic['question_creatorID']);
    } catch (Exception $e2) {
        echo 'Error: ' . $e2->getMessage();
    }
    echo 'Topic: <br/><table border="1">';
    echo "
    <tr>
    <td><a href=\"{$ProfileViewerURL}?id={$topicCreator['user_id']}\">{$topicCreator['user_login']}</a></td>
    <td>{$topic['question_content']}</td>
    <td>{$topic['question_created']}</td>
    <td>Views: {$topic['question_views']}</td>
    </tr></table>";
} catch (Exception $e1) {
    echo "Error: " . $e1->getMessage();
}
//Print answers to the topic
echo 'Answers:<br/>';
try {
    $topicAnswers = getAnswersFromTopic($_GET['id']);
    echo '<table border="1">';

    foreach ($topicAnswers as $answer) {
        try {
            $answerCreator = getUser($answer['answer_creatorID']);
        } catch (Exception $e3) {
            echo 'Error: ' . $e3->getMessage();
        }

        echo '<tr>';
        echo "<td><a href=\"{$ProfileViewerURL}?userid={$answerCreator['user_id']}\">{$answerCreator['user_login']}</a></td>";
        echo "<td>{$answer['answer_content']}</td>";
        echo "<td>{$answer['answer_created']}</td>";
        echo '</tr>';
    }
    echo '</table>';
} catch (Exception $e4) {
    echo $e4->getMessage();
}

echo '<form method="post">
    <textarea name="content"></textarea>
    <input type="submit"/>
</form>';
include_once 'includes/footer.php';
