<?php

session_start();
$_SESSION['access'] = FALSE;

if (isset($_POST['submit'])) {
    if  (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo "Incorrect email\n";
    }
    elseif ((!isset($_POST['password']))) {
        echo "Incorrect password\n";
    }
    else {
        function connect_db($host, $username, $passwd, $port, $db) {
            $pdo = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $db, $username, $passwd);
            return $pdo;
        }
        try {
            $pdo = connect_db("localhost", "root", "Echarcon91!", "80", "pool_php_rush");

        } catch (Exception $e) {
            echo $e->getMessage();
        }

        $result = $pdo->query('SELECT id, username, email, password FROM users WHERE email = "' . $_POST['email'] . '"');
        $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $count = $result->rowcount();
        if ($count > 0) {
            $data[] = $result->fetchAll(PDO::FETCH_OBJ);
            $access = password_verify($_POST['password'], $data[0][0]->password);
            if ($access == TRUE) {
                $_SESSION['access'] = TRUE;
                $_SESSION['username'] = $data[0][0]->username;
                $_SESSION['email'] = $data[0][0]->email;
                $_SESSION['id'] = $data[0][0]->id;
                if ($_POST['remember']) {
                    setcookie("id", $data[0][0]->id, time() + 365*24*3600, "/My-coding-marketplace/");
                    setcookie("username", $data[0][0]->username, time() + 365*24*3600, "/My-coding-marketplace/");
                    setcookie("email", $data[0][0]->email, time() + 365*24*3600, "/My-coding-marketplace/");
                }
                header('Location: /My-coding-marketplace/index.php');
                exit();
            } else {
                echo "Incorrect password\n";
            }
        } else {
            echo "Incorrect email\n";
        }
    }
}

?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8" />
    <title>Name</title>
</head>

<body>
<form action="login.php" method="post">
    <p>
        <label>Mail :</label><input type="text" name="email" required> <br>
        <label>Password :</label><input type="password" name="password" minlength="3" maxlength="10" required> <br>
        <input type="checkbox" name="remember" id="remember"><label for="remember">Remember me</label> <br>
        <input type="submit" name="submit" value="Submit">
    </p>
</form>
</body>
</html>
