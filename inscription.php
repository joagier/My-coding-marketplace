<?php

if (isset($_POST['submit'])) {
    if (($_POST['name'] == "name") || (!isset($_POST['name']))) {
        echo "Invalid name\n";
    }

    elseif  (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email\n";
    }
    elseif (($_POST['password'] == "password") || (!isset($_POST['password'])) ||
        ($_POST['password_confirmation'] == "password_confirmation") || (!isset($_POST['password_confirmation'])) ||
        ($_POST['password'] != $_POST['password_confirmation'])) {
        echo "Invalid password or password confirmation\n";
    }
    else {
        echo "User created";
        $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $date = date("Y-m-d");
        echo $date;
        function connect_db($host, $username, $passwd, $port, $db) {
                $pdo = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $db, $username, $passwd);
                return $pdo;
            }
            try {
                $pdo = connect_db("localhost", "root", "Echarcon91!", "80", "php_day_09");

            } catch (Exception $e) {
            echo $e->getMessage();
            }
        $pdo->query('INSERT INTO users (name, email, password, created_at) VALUES ("' . $_POST['name'] . '", "' .
            $_POST['email'] . '" , "'. $hash . '", "' . $date .'")');
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
<form action="inscription.php" method="post">
    <p>
        <label>Name :</label><input type="text" name="name" value="name" minlength="3" maxlength="10" required> <br>
        <label>Mail :</label><input type="text" name="email" value="email" required> <br>
        <label>Password :</label><input type="password" name="password" value="password" minlength="3" maxlength="10" required> <br>
        <label>Password confirmation :</label><input type="password" name="password_confirmation" value="password_confirmation" required> <br>

        <input type="submit" name="submit" value="Submit">
    </p>
</form>
</body>
</html>

