<?php
$title = "Saksia.bg";
require_once 'includes/header.php';

$showedContentLength = 20;
try {
    //Get Topics
    $allTopics = getTopics($_GET['catid']);

    //Upper Information Table
    echo '
    <table border="1">
        <tr>
            <th>Created On</th><th>Author</th><th>Title</th><th>Content</th><th>Tags</th><th>Views</th><th>Votes</th>
        </tr>';

    //Print All Topics
    foreach ($allTopics as $currTopic) {
        $id = $currTopic['question_id'];
        $creator = getUser($currTopic['question_creatorID']);
        $createdOn = date('d-m-Y H:m', strtotime($currTopic['question_created']));
        $title = $currTopic['question_title'];
        $content = substr($currTopic['question_content'], 0, $showedContentLength) . '...';
        $tags = $currTopic['question_tags'];
        $tags = explode(', ', $tags);
        $views = $currTopic['question_views'];
        $votes = $currTopic['question_votes'];

        echo '<tr>';

        echo "
            <td>{$createdOn}</td>
            <td><a href=\"{$ProfileViewerURL}?userid={$creator['user_id']}\">{$creator['user_login']}</a></td>
            <td><a href=\"viewTopic.php?id={$id}\">{$title}</a></td>
            <td>{$content}</td>
            <td>";
        foreach($tags as $tag) {
            echo '<a href="viewTag.php?name=' . $tag . '">' . $tag . ' </a>';
        }
        echo "</td>
            <td>{$views}</td>
            <td>{$votes}</td>";

        echo ' </tr > ';
    }
    echo '</table >';
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
    echo '<a href="index.php">Go home</a>';
}

?>

    <aside>
        <div class="categories">
            <nav>
                <ul>
                    <?php
                    $categories = getCategories();

                    foreach ($categories as $category) {
                        echo '<li>';

                        echo '<a href="' . 'index.php?catid=' . $category['category_ID'] . '">' . $category['category_name'] . '</a>';

                        echo '</li>';
                    }

                    ?>
                </ul>
            </nav>
        </div>
        <div class="socials">
            <ul>
                <li>

                    <a href="">FAQ</a>

                </li>
                <li>

                    <a href="">Contacts</a>

                </li>
                <li>

                    <a href="">Help</a>

                </li>
                <li>
                    <img src="pictures/giHubImg.png" />
                </li>
                <li>
                    <div id="fb-root" ></div>
                    <script>
                        (function (d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0];
                            if (d.getElementById(id)) return;
                            js = d.createElement(s); js.id = id;
                            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
                            fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));</script>
                    <div style="background-color:white" class="fb-like-box" data-href="https://www.facebook.com/pages/Saksiacom/1605229196370501?sk=info" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="false"></div>
                </li>
            </ul>
        </div>
    </aside>

<?php
require_once 'includes/footer.php';
