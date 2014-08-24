<?php
$pageTitle = 'Форма';
include 'includes/header.php';

if ($_POST) {
    $title = trim($_POST['title']);
    $title = mysqli_real_escape_string($connection, $title);
    $content = trim($_POST['content']);
    $content = mysqli_real_escape_string($connection, $content);
    $tags = trim($_POST['tags']);
    $tags = mysqli_real_escape_string($connection, $tags);
    $typeOfObj = $_POST['type'];
    $selectedType = $caregories[$_POST['type']];
    $error = false;
    if (mb_strlen($title) < 5) {
        echo '<p class="RegIn">Името на продукта е прекалено късо</p>';
        $error = true;
    }

    if (mb_strlen($content) < 100) {
        echo '<p class="RegIn">Short text</p>';
        $error = true;
    }
    if (!array_key_exists($typeOfObj, $caregories)) {
        echo '<p class="RegIn">невалидна група</p>';
        $error = true;
    }
   
    if (!$error) {
        $ins = 'INSERT INTO `questions`(`question_creatorID`, `question_title`,`question_content`,`question_tags`,`question_categoryID`)
                  VALUES ("' . $_SESSION["user_id"] . '","' . $title . '","' . $content . '","' . $tags . '","'.$selectedType.'")';
        $q = mysqli_query($connection, $ins);
        echo '<p class="RegIn">Записът е успешен</p>';
    }
}
?>
<header><a href="index.php" align="center">Back To Forum</a></header>
<form method="POST" enctype="multipart/form-data" class="RegIn">
    <div>
        <select name="type">
            <?php
            foreach ($caregories as $key => $value) {
                echo '<option value="' . $key . '">' . $value .
                '</option>';
            }
            ?>
        </select>           
    </div>        
    <div>Title:<input type="text" name="title" /></div>
    <div>Content:<input type="text" name="content" /></div>
    <div>Tags:<input type="text" name="tags" /></div>
    <div><input type="submit" value="Добави" /></div>
</form>
<?php
include 'includes/footer.php';
?>