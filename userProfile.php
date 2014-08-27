<?php
$pageTitle = 'User Profile';
include 'includes/header.php';


try {
    if ($_GET) {
        $user = getUser($_GET['userid']);
    } else {
        $user = getUser($_SESSION['user_id']);
    }

    if (isset($_POST['make-admin'])) {
        try {
            makeAdmin($user['user_id']);
            echo "Пича успешно стана админ";
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    $avatarSRC = getAvatar($user['user_avatar'], $user['user_id']);
    echo "<img class=\"avatar\" src=\"pictures/avatars/$avatarSRC\"/>";
    echo "<div class=\"sectionDivs\">Потребителско име: " . $user['user_login'] . "</div>";

    if (isset($_SESSION['user_id'])) {
        $user = getUser($_SESSION['user_id']);
        if ($_SESSION['user_rank'] == 2) {
                echo '<form method="post"><input type="hidden" name="make-admin" value="make-admin"><input type="submit" value="Make User Admin"></form>';
            }
        }


    try {
        $userQuestions = getUserQuestions($user['user_id']);
        echo '<div class="sectionDivs">Зададени въпроси: </div>';
        echo '<table class="answers">';
        foreach ($userQuestions as $question) {
            echo '<tr>';
            echo '<td>' . "<a href=\"viewTopic.php?id={$question['question_id']}\">{$question['question_title']}" . '</td>';
            echo '</tr>';
        }
        echo '</table>';
//        foreach ($userQuestions as $question) {
//            echo $question['question_title'] . "<br/>";
//        }

    } catch (Exception $e2) {
        echo $e2->getMessage();
    }
    echo '<div class="sectionDivs">Отговори на потребителя: </div>';
    try {
        $userAnswers = getUserAnswers($user['user_id']);
        echo '<table class="answers">';
        foreach ($userAnswers as $answer) {
            echo '<tr>';
            echo '<td>' . "<a href=\"viewTopic.php?id={$answer['answer_questionID']}\">{$answer['answer_content']}" . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } catch (Exception $e3) {
        echo $e3->getMessage();
    }


} catch (Exception $e1) {
    echo $e1->getMessage();
}

echo '</section>';


require_once 'includes/aside.php';
require_once 'includes/footer.php';