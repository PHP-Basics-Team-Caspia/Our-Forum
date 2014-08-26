<?php
$pageTitle = 'Форма';
include 'includes/header.php';

if ($_POST) {
    $userID = $_SESSION["user_id"];
    $title = trim($_POST['title']);
    $title = mysqli_real_escape_string($connection, $title);
    $content = trim($_POST['content']);
    $content = mysqli_real_escape_string($connection, $content);
    $category = $_POST['category'];
    $tags = trim($_POST['tags']);
    $tags = mysqli_real_escape_string($connection, $tags);

    try {
        $user = getUser($userID);
        if ($user['user_rank'] == 0 || $user['user_rank'] == -1) {
            addTopic($userID, $title, $content, $tags, $category);
        } else {
            addTopic($userID, $title, $content, $tags, $category, true);
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
    <header><a href="index.php" align="center">Back To Forum</a></header>
    <form method="POST" enctype="multipart/form-data" class="RegIn">
        <div>
            <label for="category">Category: </label><select name="category">
                <?php
                $categories = getCategories();
                foreach ($categories as $category) {
                    echo "<option value=\"{$category['category_ID']}\">{$category['category_name']}</option>";
                }
                ?>
            </select>
        </div>
        <div>Title:<input type="text" name="title"/></div>
        <div>Content:<input type="text" name="content"/></div>
        <div>Tags:<input type="text" name="tags"/></div>
        <div><input type="submit" value="Добави"/></div>
    </form>
<?php
include 'includes/footer.php';
?>