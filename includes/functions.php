<?php
function getCategories($categoryID = null)
{
    if ($categoryID == null) {
        $categoriesDB = mysqli_query($GLOBALS['connection'], 'SELECT * FROM `categories`');
    } else {
        $categoriesDB = mysqli_query($GLOBALS['connection'], "SELECT * FROM `categories` WHERE `category_ID` = {$categoryID}");
    }
    if ($categoriesDB->num_rows == 0) {
        throw new Exception('Invalid category ID');
    }
    if ($categoryID != null) {
        return $categoriesDB->fetch_assoc();
    } else {
        while ($currCategory = $categoriesDB->fetch_assoc()) {
            $categories[] = $currCategory;
        }
        return $categories;
    }
}

function addCategory($name)
{
    mysqli_query($GLOBALS['connection'], "INSERT INTO `categories` (`category_name`) VALUES (\"{$name}\")");
}

function getUser($userID)
{
    $userDB = mysqli_query($GLOBALS['connection'], 'SELECT * FROM `users` WHERE user_id =' . $userID);
    if ($userDB->num_rows == 0) {
        throw new Exception('Invalid userID');
    }
    return $userDB->fetch_assoc();
}

function addTopic($userID, $title, $content, $tags, $category, $approved = null)
{
    $minimumChars = 50;
    if (mb_strlen($title) < 5) {
        throw new Exception('Името на темата е прекалено късо');
    }

    if (mb_strlen($content) < $minimumChars) {
        throw new Exception('Съдържанието е прекалено късо');
    }
    if ($approved != null) {
    $ins = "INSERT INTO `questions` (`question_creatorID`, `question_title`,`question_content`,`question_tags`,`question_categoryID`, `question_approved`)
              VALUES ('{$userID}', '{$title}', '{$content}', '{$tags}', '{$category}', 1)";
    } else {
          $ins = "INSERT INTO `questions`(`question_creatorID`, `question_title`,`question_content`,`question_tags`,`question_categoryID`)
                    VALUES ('{$userID}', '{$title}', '{$content}', '{$tags}', '{$category}')";
    }
    $q = mysqli_query($GLOBALS['connection'], $ins);
    if ($q == false) {
        throw new Exception('Query error');
    }

}
function approveTopic($topicID) {
    mysqli_query($GLOBALS['connection'], "UPDATE `questions` SET `question_approved` = 1 WHERE `question_id` = {$topicID}");
}
function getTopics($categoryID = null)
{
    if ($categoryID !== null) {
        $category = getCategories($categoryID);
        $allTopicsDB = mysqli_query($GLOBALS['connection'], "SELECT * FROM `questions` WHERE `question_categoryID` = {$category['category_ID']}");
    } else {
        $allTopicsDB = mysqli_query($GLOBALS['connection'], "SELECT * FROM `questions`");
    }
    if ($allTopicsDB->num_rows == 0) {
        throw new Exception('Invalid category ID');
    }
    $allTopics = array();
    while ($topic = $allTopicsDB->fetch_assoc()) {
        $allTopics[] = $topic;
    }
    if (sizeof($allTopics) == 0) {
        throw new Exception('No topics in this category.');
    }
    return $allTopics;
}

function getTopic($topicID)
{
    $topicDB = mysqli_query($GLOBALS['connection'], "SELECT * FROM `questions` WHERE `question_id` = {$topicID}");
    if ($topicDB->num_rows == 0) {
        throw new Exception('Invalid Topic');
    }
    $topic = $topicDB->fetch_assoc();

    $topicViews = $topic['question_views'] + 1;
    $updateViews = mysqli_query($GLOBALS['connection'], "UPDATE `questions` SET `question_views` = {$topicViews} WHERE `questions`.`question_id` = {$topicID}");
    if ($updateViews == false) {
        throw new Exception('Unable to update topic views');
    }

    return $topic;
}

function getAnswersFromTopic($topicID)
{
    $topicAnswersDB = mysqli_query($GLOBALS['connection'], "SELECT * FROM `answers` WHERE `answer_questionID` = {$topicID}");
    if ($topicAnswersDB->num_rows == 0) {
        throw new Exception('No answers exist in this topic');
    }
    $topicAnswers = array();
    while ($currAnswer = $topicAnswersDB->fetch_assoc()) {
        $topicAnswers[] = $currAnswer;
    }
    return $topicAnswers;
}

function getUserQuestions($userID)
{
    $userQuestionsDB = mysqli_query($GLOBALS['connection'], "SELECT * FROM `questions` WHERE `question_creatorID` = {$userID}");
    if ($userQuestionsDB->num_rows == 0) {
        throw new Exception('User has no posted questions');
    }
    while ($userQuestion = $userQuestionsDB->fetch_assoc()) {
        $userQuestions[] = $userQuestion;
    }
    return $userQuestions;
}

function getUserAnswers($userID)
{
    $userAnswersDB = mysqli_query($GLOBALS['connection'], "SELECT * FROM `answers` WHERE `answer_creatorID` = {$userID}");
    if ($userAnswersDB->num_rows == 0) {
        throw new Exception('User has no posted answers');
    }
    while ($userAnswer = $userAnswersDB->fetch_assoc()) {
        $userAnswers[] = $userAnswer;
    }
    return $userAnswers;
}

function addAnswer($topicID, $creatorID, $content)
{
    $content = htmlentities($content);
    $add = mysqli_query($GLOBALS['connection'], "INSERT INTO `answers` (`answer_questionID`, `answer_creatorID`, `answer_content`)
        VALUES ({$topicID}, {$creatorID}, \"{$content}\")");
    if ($add == false) {
        throw new Exception('Unable to add answer');
    }
}

function register($username, $pass, $email, $picture = null)
{
    $username = trim($username);
    $username = mysqli_real_escape_string($GLOBALS['connection'], $username); // make data save before send query to MySQL
    $pass = trim($pass);
    $pass = mysqli_real_escape_string($GLOBALS['connection'], $pass);
    $email = trim($email);
    $email = mysqli_real_escape_string($GLOBALS['connection'], $email);
    $select = mysqli_query($GLOBALS['connection'], 'SELECT * FROM users Where `user_login` = "' . $username . '"');
    if ($select->num_rows > 0) {
        throw new Exception('Username already taken');
    }
    $ins = 'INSERT INTO `users`(`user_login`, `user_password`,`user_email`)
                    VALUES ("' . $username . '","' . $pass . '","' . $email . '")';
    $q = mysqli_query($GLOBALS['connection'], $ins);
    if ($q == false) {
        throw new Exception('Query not executed');
    }
    if ($picture != null) {
        mysqli_query($GLOBALS['connection'], "UPDATE `users` SET `user_avatar` = 1 WHERE `user_login` = \"{$username}\"");
        $avatar = $picture;
        $file_type = $avatar['type'];
        $file_size = $avatar['size'];
        $file_path = $avatar['tmp_name'];
        $userDB = mysqli_query($GLOBALS['connection'], "SELECT * FROM `users` WHERE `user_login` = \"{$username}\"");
        $user = $userDB->fetch_assoc();
        $picName = $user['user_id'] . '.' . str_replace('image/', '', $file_type);
        if (!($file_type == "image/jpeg" || $file_type == "image/png" || $file_type == "image/gif")) {
            throw new Exception('Invalid extension for avatar');
        }
        if (!($file_size < 1048576)) {
            throw new Exception('File is too big.');
        }
        $uploaded = move_uploaded_file($file_path, 'pictures' . DIRECTORY_SEPARATOR . 'avatars' . DIRECTORY_SEPARATOR . $picName);
        if ($uploaded == false) {
            throw new Exception('File upload failed');
        } else {
            logIn($username, $pass);
        }
    }
}

function login($userName, $pass)
{
    $userName = trim($userName);
    $userName = mysqli_real_escape_string($GLOBALS['connection'], $userName);
    $pass = trim($pass);
    $pass = mysqli_real_escape_string($GLOBALS['connection'], $pass);

    $userDB = mysqli_query($GLOBALS['connection'], 'SELECT * FROM users Where `user_login` = "' . $userName . '" AND `user_password`="' . $pass . '"');
    if ($userDB->num_rows > 0) {
        $user = $userDB->fetch_assoc();
        $_SESSION['rank'] = $user['user_rank'];
        $_SESSION['user_name'] = $user["user_login"];
        $_SESSION['user_pass'] = $user["user_password"];
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_email'] = $user['user_email'];
    } else {
        throw new Exception("Invalid username or password");
    }
}
