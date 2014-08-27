<?php
include_once('includes/header.php');

if($_POST) {
    addAnswer($_GET['id'], $_SESSION['user_id'], $_POST['content']);
}

try {
    $topic = getTopic($_GET['id']);
//Go back
    $category = getCategories($topic['question_categoryID']);
    echo "<div class=\"sectionDivs\"><a href=\"admin.php?catid={$category['category_ID']}\">Върни се към  {$category['category_name']}</a></div>";
//Print out the topic
    try {
        $topicCreator = getUser($topic['question_creatorID']);
    } catch (Exception $e2) {
        echo 'Error: ' . $e2->getMessage();
    }
//    echo 'Topic: <br/><table border="1">';
//    echo "
//    <tr>
//    <td><a href=\"{$ProfileViewerURL}?id={$topicCreator['user_id']}\">{$topicCreator['user_login']}</a></td>
//    <td>{$topic['question_content']}</td>
//    <td>{$topic['question_created']}</td>
//    <td>Views: {$topic['question_views']}</td>
//    </tr></table>";
} catch (Exception $e1) {
    echo "Error: " . $e1->getMessage();
}
?>

    <table class="questions">
        <tr>
            <th>Автор</th>
            <th>Гласове</th>
            <th><?=$topic['question_title']?></th>
        </tr>
        <tr>
            <td>
                <img
                <a href=\"{$ProfileViewerURL}?id={$topicCreator['user_id']}\"><?=$topicCreator['user_login']?></a>
            </td>
            <td><?=$topic['question_votes']?></td>
            <td><?=$topic['question_content']?></td>
        </tr>
    </table>



<?php
//Print answers to the topic
echo '<div class="sectionDivs">Отговори:</div>';
try {
    $topicAnswers = getAnswersFromTopic($_GET['id']);
    echo '<table class="answers">';

    foreach ($topicAnswers as $answer) {
        try {
            $answerCreator = getUser($answer['answer_creatorID']);
        } catch (Exception $e3) {
            echo 'Error: ' . $e3->getMessage();
        }

        echo '<tr>';
        echo "<td><a href=\"{$ProfileViewerURL}?userid={$answerCreator['user_id']}\">{$answerCreator['user_login']}</a></td>";
        echo "<td>{$answer['answer_content']}</td>";
        echo '</tr>';
    }
    echo '</table>';
} catch (Exception $e4) {
    echo $e4->getMessage();
}
?>
<?php
if (isset($_SESSION['user_id'])) : ?>
<form class="addAnswers" method="post">
    <textarea class="addAnswerContent" name="content"></textarea>
    <input type="submit" value="Добави отговор"/>
</form>
<?php
    endif;
echo '</section>';
require_once 'includes/aside.php';
require_once 'includes/footer.php';