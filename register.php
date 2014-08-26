<?php
$pageTitle = "Регистрация";
include 'includes/header.php';
?>
    <form method="POST" enctype="multipart/form-data">
        <div>
            Име:<input type="text" name="username"/>
        </div>
        <div>
            Парола:<input type="password" name="pass"/>
        </div>
        <div>
            e-mail:<input type="email" name="email"/>
        </div>
        <div>
            Снимка:<input type="file" name="picture"/>
        </div>
        <div>
            <input type="submit" value="Регистрация"/>
        </div>
        <?php

        if ($_POST) {
            try {
            if ($_FILES['picture']['name'] == "") {
                $reg = register($_POST['username'], $_POST['pass'], $_POST['email']);
            } else {
                $reg = register($_POST['username'], $_POST['pass'], $_POST['email'], $_FILES['picture']);
            }
            } catch (Exception $e) {
               echo $e->getMessage();
            }
        }
        ?>
    </form>

<?php
include 'includes/footer.php';
?>