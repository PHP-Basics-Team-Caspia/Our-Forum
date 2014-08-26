<?php

$pageTitle = 'User Profile';
include 'includes/header.php';
try {
    if ($_GET) {
        $user = getUser($_GET['userid']);
    } else {
        $user = getUser($_SESSION['user_id']);
    }
    $avatarSRC = searchFile($user['user_avatar'], $user['user_id']);
    echo "<img src=\"pictures/avatars/{$avatarSRC}\" style='width: 100px !important; height: 100px !important;'/>";
    echo 'User Name: ' . $user['user_login'] . "<br/>";

    try {
        $userQuestions = getUserQuestions($user['user_id']);
        echo 'User Questions: <br/>';
        foreach ($userQuestions as $question) {
            echo $question['question_title'] . "<br/>";
        }

    } catch (Exception $e2) {
        echo $e2->getMessage();
    }
    echo 'User Answers: <br/>';
    try {
        $userAnswers = getUserAnswers($user['user_id']);
        foreach ($userAnswers as $answer) {
            echo $answer['answer_content'] . "<br/>";
        }
    } catch (Exception $e3) {
        echo $e3->getMessage();
    }


} catch (Exception $e1) {
    echo $e1->getMessage();
}
include 'includes/footer.php';