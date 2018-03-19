<?php

session_start();

if ($_SESSION['access'] == TRUE) {
    echo "Hello " . $_SESSION['name'] . "\n";
    echo "<html><br><a href='logout.php?logout=true'>Logout</a><br></html>";
    echo "<html><a href='modify_account.php'>Settings</a><br></html>";
}

else {
    if (isset($_COOKIE['name'])) {
    echo "Hello " . $_COOKIE['name'] . "\n";
    echo "<html><br><a href='logout.php?logout=true'>Logout</a><br></html>";
    echo "<html><a href='modify_account.php'>Settings</a><br></html>";
} else {
    header('Location: /pool_php_d10/ex_05/login.php');
    exit();
}
}