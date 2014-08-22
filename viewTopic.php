<?php
include_once('includes/header.php');

if (!isset($_GET['id'])) {
    echo 'Invalid topic <a href="index.php">Go back</a>';
    return;
}
$topicID = $_GET['id'];
$topicDB = mysqli_query($connection, "SELECT * FROM `questions` WHERE `question_id` = {$topicID}");
$topic = $topicDB->fetch_assoc();
$topicCreator = mysqli_query($connection, 'SELECT * FROM `users` WHERE user_id =' . $topic['question_creatorID']);
$topicCreator = $topicCreator->fetch_assoc();
if (empty($topic)) {
    echo 'Invalid topic <a href="index.php">Go back</a>';
    return;
}

//Update topic views
$topicViews = $topic['question_views'] + 1;
$updateViews = mysqli_query($connection, "UPDATE `questions` SET `question_views` = {$topicViews} WHERE `questions`.`question_id` = {$topic['question_id']}");

$topicAnswersDB = mysqli_query($connection, "SELECT * FROM `answers` WHERE `answer_questionID` = {$topicID}");
$topicAnswers = array();
while ($currAnswer = $topicAnswersDB->fetch_assoc()) {
    $topicAnswers[] = $currAnswer;
}

//Go back
$category = mysqli_query($connection, "SELECT * FROM `categories` WHERE `category_id` = {$topic['question_categoryID']}");
$category = $category->fetch_assoc();
echo "<a href=\"viewTopics.php?catid={$category['category_ID']}\">Go back to {$category['category_name']}</a>" . '<br/>';
//Print out the topic
echo 'Topic: <br/><table border="1">';
echo "
    <tr>
    <td><a href=\"{$ProfileViewerURL}?id={$topicCreator['user_id']}\">{$topicCreator['user_login']}</a></td>
    <td>{$topic['question_content']}</td>
    <td>{$topic['question_created']}</td>
    <td>Views: {$topic['question_views']}</td>
    </tr>";
echo '</table><br/>';

//Print answers to the topic
if (empty($topicAnswers)) {
    echo 'No answers exist in this topic';
} else {
    echo 'Answers:<br/>';
    echo '<table border="1">';

    foreach ($topicAnswers as $answer) {
        $answerCreator = mysqli_query($connection, 'SELECT * FROM `users` WHERE user_id =' . $answer['answer_creatorID']);
        $answerCreator = $answerCreator->fetch_assoc();
        $content = $answer['answer_content'];

        echo '<tr>';

        echo "<td><a href=\"{$ProfileViewerURL}?id={$answerCreator['user_id']}\">{$answerCreator['user_login']}</a></td>";
        echo "<td>{$content}</td>";

        echo '</tr>';
    }

    echo '</table>';
}