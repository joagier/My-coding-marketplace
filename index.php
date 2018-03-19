<?php

session_start();

if ($_SESSION['access'] == TRUE) {
    echo "Hello " . $_SESSION['username'] . "\n";
    echo "<html><br><a href='logout.php?logout=true'>Logout</a><br></html>";
    echo "<html><a href='modify_account.php'>Settings</a><br></html>";
}

else {
    if (isset($_COOKIE['username'])) {
    echo "Hello " . $_COOKIE['username'] . "\n";
    echo "<html><br><a href='logout.php?logout=true'>Logout</a><br></html>";
    echo "<html><a href='modify_account.php'>Settings</a><br></html>";
} else {
    header('Location: /My-coding-marketplace/login.php');
    exit();
}
}