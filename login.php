<?php
include_once 'includes/header.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    try {
        login($_POST['username'], $_POST['password']);
        echo 'Login successful!';
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

?>
<form method="post">
    <label for="username">Username: </label><input type="text" name="username"/>
    <label for="password">Password: </label><input type="password" name ="password"/>
    <input type="submit"/>
</form>
<?php
include_once 'includes/footer.php';
?>