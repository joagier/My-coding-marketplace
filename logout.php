<?php

if ($_GET['logout'] == true) {
    setcookie("name", '', time() - 3600, "/pool_php_d10/ex_05/");
    session_unset();
    session_destroy();
    session_reset();
    header('Location: /pool_php_d10/ex_05/login.php');
    exit();
}