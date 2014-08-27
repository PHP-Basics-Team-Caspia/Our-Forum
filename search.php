<?php
include_once 'includes/header.php';

try {
$keyword = $_POST['search'];
$topics = search($keyword);

    //Upper Information Table
    echo '
    <table class="questions">
        <tr>
            <th>Въпрос</th><th>Автор</th><th>Създаден на</th><th>Тагове</th><th>Посещения</th><th>Гласове</th>
        </tr>';

    //Print All Topics
    foreach ($topics as $currTopic) {
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
            <td><a href=\"viewTopic.php?id={$id}\">{$title}</a></td>
            <td><a href=\"{$ProfileViewerURL}?userid={$creator['user_id']}\">{$creator['user_login']}</a></td>
            <td>{$createdOn}</td>
            <!--<td>{$content}</td>-->
            <td>{$tags}</td>
            <td>{$views}</td>
            <td>{$votes}</td>";


        echo ' </tr > ';
    }
    echo '</table >';


} catch (Exception $e) {
    echo $e->getMessage();
}

echo '</section>';
include_once('includes/aside.php');
include_once 'includes/header.php';