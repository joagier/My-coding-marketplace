<?php

session_start();

if ((isset($_COOKIE["username"])) || ($_SESSION['access'] == TRUE) ) {
    function connect_db($host, $username, $passwd, $port, $db) {
        $pdo = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $db, $username, $passwd);
        return $pdo;
    }
    try {
        $pdo = connect_db("localhost", "root", "Echarcon91!", "80", "pool_php_rush");

    } catch (Exception $e) {
        echo $e->getMessage();
    }
    if ($_SESSION['access'] == TRUE) {
        $result = $pdo->query('SELECT username, email FROM users WHERE email = "' . $_SESSION['email'] . '"');
    } else {
        if (isset($_COOKIE['name'])) {
            $result = $pdo->query('SELECT username, email FROM users WHERE email = "' . $_COOKIE['email'] . '"');
        }
    }
    $data[] = $result->fetchAll(PDO::FETCH_OBJ);

if (isset($_POST['submit'])) {
    if (($_POST['username'] == "username") || (!isset($_POST['username']))) {
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

        if ($_SESSION['access'] == TRUE) {
            $pdo->query('UPDATE users SET username = "' . $_POST['username'] . '", email = "' . $_POST['email'] .'", password = "' . $hash . '"  WHERE id =' . $_SESSION['id']);
        } else {
            if (isset($_COOKIE['name'])) {
                $pdo->query('UPDATE users SET username = "' . $_POST['username'] . '", email = "' . $_POST['email'] .'", password = "' . $hash . '"  WHERE id =' . $_COOKIE['id']);

            }
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
<form action="modify_account.php" method="post">
    <p>
        <label>Name :</label><input type="text" name="username" value="<?php echo $data[0][0]->username ?>" minlength="3" maxlength="10" required> <br>
        <label>Mail :</label><input type="text" name="email" value="<?php echo $data[0][0]->email ?>" required> <br>
        <label>Password :</label><input type="password" name="password" minlength="3" maxlength="10" required> <br>
        <label>Password confirmation :</label><input type="password" name="password_confirmation" required> <br>

        <input type="submit" name="submit" value="Submit">
    </p>
</form>
</body>
</html>

<?php }

else {
    header('Location: /My-coding-marketplace/login.php');
    exit();
}
?>



