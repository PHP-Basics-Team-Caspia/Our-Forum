<aside>
    <div class="categories">
        <?php
        if (isset($_SESSION['user_id'])) {
            $user = getUser($_SESSION['user_id']);

            if ($user['user_rank'] == 2) {
                echo '<div class="asideDivs"><a href="admin.php">View Admin Panel</a></div>';
            }
        }
        ?>
        <div class="asideDivs">Категории</div>
        <nav>
            <ul>                <?php $categories = getCategories();
                foreach ($categories as $category) {
                    echo '<li>';
                    echo '<a href="' . 'index.php?catid=' . $category['category_ID'] . '">' . $category['category_name'] . '</a>';
                    echo '</li>';
                } ?>            </ul>
        </nav>
    </div>
    <div class="socials">
        <ul>
            <li><a href="https://softuni.bg/"> <img src="pictures/softuni-logo.png"/> </a></li>
            <li><a href="contact.php">Контакти</a></li>
            <li><a href="rules.php">Правила</a></li>
            <li><a href="FAQ.php">FAQ</a></li>
            <li><a href="https://github.com/PHP-Basics-Team-Caspia"> <img src="pictures/giHubImg.png"/> </a></li>
            <li>
                <div id="fb-root"></div>
                <script>(function (d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) return;
                        js = d.createElement(s);
                        js.id = id;
                        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
                <div class="fb-like-box" data-width="200 px" style="background-color:white; width:98%;"
                     data-href="https://www.facebook.com/saksia.bg" data-colorscheme="light" data-show-faces="true"
                     data-header="true" data-stream="false" data-show-border="false"></div>
            </li>
        </ul>
    </div>
</aside>