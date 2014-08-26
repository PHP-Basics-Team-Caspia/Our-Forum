<?php
include_once '../includes/header.php';

if ($_POST) {
    if (isset($_POST['category_name'])) {
        addCategory($_POST['category_name']);
    }
    if (!$toApprove = empty($_POST['approve'])) {
        foreach ($_POST['approve'] as $currID) {
            approveTopic($currID);
        }
    }
}
?>
<form method="post">
    Add new category: <input type="text" name="category_name" placeholder="Category name"/>

    <br/>Approve topics: <br/>
    <?php
    $toBeApprovedDB = mysqli_query($GLOBALS['connection'], "SELECT * FROM `questions` WHERE `question_approved` = 0");
    if ($toBeApprovedDB->num_rows == 0) {
        echo "No unapproved topics exist";
    } else {
        echo '<table border="1">
        <tr>
            <th>Added On</th>
            <th>Creator</th>
            <th>Title</th>
            <th>Content</th>
            <th>Tags</th>
            <th>Approve</th>
        </tr>';
        while ($currQuestion = $toBeApprovedDB->fetch_assoc()) {
            $allQuestions[] = $currQuestion;
        }
        foreach ($allQuestions as $question) {
            echo '<tr>';

            echo '<td>' . $question['question_created'] . '</td>';
            try {
                $creator = getUser($question['question_creatorID']);
                echo '<td>' . $creator['user_login'] . '</td>';
            } catch (Exception $e) {
                echo '<td>' . $e->getMessage() . '</td>';
            }
            echo '<td>' . $question['question_title'] . '</td>';
            echo '<td>' . $question['question_content'] . '</td>';
            echo '<td>' . $question['question_tags'] . '</td>';
            echo '<td><input type="checkbox" name="approve[]" value="' . $question['question_id'] . '"></td>';

            echo '</tr>';
        }
    }
    ?>
    </table>


   <br/> <input type="submit"/>
</form>
<?php
include_once '../includes/footer.php';

?>