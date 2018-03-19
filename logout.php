<?php

if ($_GET['logout'] == true) {
    setcookie("username", '', time() - 3600, "/My-coding-marketplace/");
    session_unset();
    session_destroy();
    session_reset();
    header('Location: /My-coding-marketplace/login.php');
    exit();
}