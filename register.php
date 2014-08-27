<?php
$pageTitle = "Регистрация";
include 'includes/header.php';
echo '<div class="sectionDivs">Добре дошъл на страницата ни за регистрация!</div>';
?>
    <form class="register" method="POST" enctype="multipart/form-data">
        <div>
            <label for="username">Username:</label>
            <input id="username" type="text" name="username"/>
        </div>
        <div>
            <label for="pass">Парола:</label>
            <input id="pass" type="password" name="pass"/>
        </div>
        <div>
            <label for="email">e-mail:</label>
            <input id="email" type="email" name="email"/>
        </div>
        <div>
            <label for="picture">Снимка:</label>
            <input id="picture" type="file" name="picture"/>
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
                echo "Регистрацията е успешна!";
            } catch (Exception $e) {
               echo $e->getMessage();
            }
        }
        ?>
    </form>

    </section>


<?php
require_once 'includes/aside.php';
require_once 'includes/footer.php';