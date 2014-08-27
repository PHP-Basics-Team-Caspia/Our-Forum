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

function approveTopic($topicID)
{
    mysqli_query($GLOBALS['connection'], "UPDATE `questions` SET `question_approved` = 1 WHERE `question_id` = {$topicID}");
}

function getTopics($categoryID = null)
{
    if ($categoryID !== null) {
        $category = getCategories($categoryID);
        $allTopicsDB = mysqli_query($GLOBALS['connection'], "SELECT * FROM `questions` WHERE `question_approved` = 1 AND `question_categoryID` = {$category['category_ID']} ORDER BY `question_created` DESC");
    } else {
        $allTopicsDB = mysqli_query($GLOBALS['connection'], "SELECT * FROM `questions` WHERE `question_approved` = 1 ORDER BY `question_created` DESC");
    }
    if ($allTopicsDB == false) {
        throw new Exception('Invalid topic');
    }
    if ($allTopicsDB->num_rows == 0) {
        throw new Exception('No topics in this category.');
    }
    $allTopics = array();
    while ($topic = $allTopicsDB->fetch_assoc()) {
        $allTopics[] = $topic;
    }
    return $allTopics;
}

function getTopic($topicID)
{
    $topicDB = mysqli_query($GLOBALS['connection'], "SELECT * FROM `questions` WHERE `question_id` = {$topicID}");
    if ($topicDB->num_rows == 0) {
        throw new Exception('No topics exist in this category');
    }
    if ($topicDB == false) {
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
    $topicAnswersDB = mysqli_query($GLOBALS['connection'], "SELECT * FROM `answers` WHERE `answer_questionID` = {$topicID} ORDER BY `answer_created` ASC");
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
    $content = htmlspecialchars($content);
    $add = mysqli_query($GLOBALS['connection'], "INSERT INTO `answers` (`answer_questionID`, `answer_creatorID`, `answer_content`)
        VALUES ({$topicID}, {$creatorID}, \"{$content}\")");
    if ($add == false) {
        throw new Exception('Unable to add answer');
    }
}

function register($username, $pass, $email, $picture = null)
{
    $username = trim($username);
    if (!preg_match('/^[A-Za-z][A-Za-z0-9]{5,31}$/', $username)) {
        throw new Exception('Wrong Username');
    } else {
        $username = mysqli_real_escape_string($GLOBALS['connection'], $username); // make data save before send query to MySQL
        $pass = trim($pass);
        $pass = mysqli_real_escape_string($GLOBALS['connection'], $pass);
        $email = trim($email);
        $email = mysqli_real_escape_string($GLOBALS['connection'], $email);
        $select = mysqli_query($GLOBALS['connection'], 'SELECT * FROM users Where `user_login` = "' . $username . '"');
        if ($select->num_rows > 0) {
            throw new Exception('Username already taken');
        }
        $ins = "INSERT INTO `users` (`user_login`, `user_password`,`user_email`)
                    VALUES (\"{$username}\", md5(\"{$pass}\"), \"{$email}\")";
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
                login($username, $pass);
            }
        }
    }
}

function login($userName, $pass)
{
    $userName = trim($userName);
    $userName = mysqli_real_escape_string($GLOBALS['connection'], $userName);
    $pass = trim($pass);
    $pass = mysqli_real_escape_string($GLOBALS['connection'], $pass);
    $userDB = mysqli_query($GLOBALS['connection'], "SELECT * FROM users Where `user_login` = \"{$userName}\" AND `user_password`=\"" . md5($pass) . '"');
    if ($userDB->num_rows > 0) {
        $user = $userDB->fetch_assoc();
        $_SESSION['user_rank'] = $user['user_rank'];
        $_SESSION['user_name'] = $user["user_login"];
        $_SESSION['user_pass'] = $user["user_password"];
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_email'] = $user['user_email'];
    } else {
        throw new Exception("Invalid username or password");
    }
}

function getAvatar($user_avatar, $user_id)
{
    if ($user_avatar == 0) {
        $name = "defaultAvatar";
    } else $name = $user_id;
    $dir = 'pictures/avatars/';
    $files = scandir($dir);
    for ($i = 2; $i < count($files); $i++) {
        $file = explode('.', $files[$i]);
        if ($file[0] == $name) {
            return implode('.', $file);
        }
    }
}

function getTopicsWithTag($tagName)
{
    $allTopicsDB = getTopics();
    foreach ($allTopicsDB as $topic) {
        $topicTags = explode(', ', $topic['question_tags']);
        if (array_search($tagName, $topicTags) !== false) {
            $topics[] = $topic;
        }
    }
    if (empty($topics)) {
        throw new Exception('No topics exist with this tag');
    }

    return $topics;

}

function logout()
{
    session_destroy();
}

function search($keyword)
{
    $topicsDB = mysqli_query($GLOBALS['connection'], "SELECT * FROM `questions` WHERE `question_title` LIKE \"%{$keyword}%\"");
    if ($topicsDB->num_rows == 0) {
        throw new Exception('No topics exist');
    }
    while ($topic = $topicsDB->fetch_assoc()) {
        $topics[] = $topic;
    }
    return $topics;
}

function makeAdmin($userID)
{
    $query = mysqli_query($GLOBALS['connection'], "UPDATE `users` SET `user_rank` = 2 WHERE `user_id` = \"{$userID}\"");
    if ($query == false) {
        throw new Exception("Unable to make user admin");
    }
}