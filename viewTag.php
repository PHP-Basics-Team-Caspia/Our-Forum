<?php
if (isset($_GET['id'])) {
$topics = getTopicsWithTag($_GET['id']);
} else {
    echo "Invalid "
}