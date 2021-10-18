<?php
require_once '../root/root.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>
    <div>
        <form method="post">
            <div>
                <label for="Username">Username</label><br>
                <input type="text" name="username" id="username">
            </div>
            <div>
                <label for="Name">Name</label><br>
                <input type="text" name="name" id="name">
            </div>
            <div>
                <label for="Name">Surname</label><br>
                <input type="text" name="surname" id="surname">
            </div>
            <div>
                <label for="Surname">E-Mail</label><br>
                <input type="email" name="email" id="email">
            </div>
            <div>
                <label for="Password">Password</label><br>
                <input type="password" name="pass" id="pass">
            </div>
            <div>
                <input type="submit" value="Register" name="register">
            </div>
        </form>
    </div>
    <?php
    if (isset($_POST['register'])) {
        $username  = Security($_POST['username']);
        $name      = Security($_POST['name']);
        $surname   = Security($_POST['surname']);
        $email     = Security($_POST['email']);
        $password2 = Security($_POST['pass']);
        $control        = "/\S*((?=\S{8,})(?=\S*[A-Z]))\S*/";
        if (empty($username) || empty($name) || empty($surname) || empty($email) || empty($password2)) {
            die("Empty Blank!");
        }
        if (is_numeric($name) || is_numeric($surname)) {
            die("The first or last name does not contain a numeric value!");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("The e-mail you entered does not meet the e-mail criteria!");
        }

        $dontuse = "+";
        if (strpos($email, $dontuse)) {
            die("Please do not use invalid signs or register more than once.");
        }

        $query = $db->prepare("SELECT * FROM users WHERE Username = :username OR EMail = :email");
        $query->bindParam(":username", $username, PDO::PARAM_STR);
        $query->bindParam(":email", $email, PDO::PARAM_STR);
        $query->execute();
        $count = $query->rowCount();
        if ($count > 0) {
            die("This user is registered in the system!");
        }

        if (!preg_match($control, $password2) || strlen($password2) < 8) {
            die("Please re-enter your password with 1 capital letter and at least 8 characters!");
        }

        $password = PassHash($password2);
        $status = 0;

        $reg = $db->prepare("INSERT INTO users (Username, Name, Surname, EMail, Password, Status) VALUES (:username, :name, :surname, :email, :password, :status)");
        $reg->bindParam(":username", $username, PDO::PARAM_STR);
        $reg->bindParam(":name", $name, PDO::PARAM_STR);
        $reg->bindParam(":surname", $surname, PDO::PARAM_STR);
        $reg->bindParam(":email", $email, PDO::PARAM_STR);
        $reg->bindParam(":password", $password, PDO::PARAM_STR);
        $reg->bindParam(":status", $status, PDO::PARAM_INT);
        $reg->execute();
        if ($db->lastInsertId()) {
            echo "Registration successful.";
            header("location:./login.php");
        } else {
            echo "Registration failed or an error occurred, please contact the administrator!";
        }
    }
    ?>
</body>

</html>