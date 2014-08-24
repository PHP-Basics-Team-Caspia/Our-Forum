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

function getUser($userID)
{
    $userDB = mysqli_query($GLOBALS['connection'], 'SELECT * FROM `users` WHERE user_id =' . $userID);
    if ($userDB->num_rows == 0) {
        throw new Exception('Invalid userID');
    }
    return $userDB->fetch_assoc();
}

function addTopic($userID, $title, $content, $tags, $category)
{
    $minimumChars = 50;
    if (mb_strlen($title) < 5) {
        throw new Exception('Името на темата е прекалено късо');
    }

    if (mb_strlen($content) < $minimumChars) {
        throw new Exception('Съдържанието е прекалено късо');
    }
    $ins = 'INSERT INTO `questions`(`question_creatorID`, `question_title`,`question_content`,`question_tags`,`question_categoryID`)
                  VALUES ("' . $userID . '","' . $title . '","' . $content . '","' . $tags . '","' . $category . '")';
    $q = mysqli_query($GLOBALS['connection'], $ins);
    return true;
}

function getTopicsFromCategory($categoryID)
{
    $category = getCategories($categoryID);
    $allTopicsDB = mysqli_query($GLOBALS['connection'], "SELECT * FROM `questions` WHERE `question_categoryID` = {$category['category_ID']}");
    if ($allTopicsDB == false) {
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
function getAnswersFromTopic($topicID) {
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