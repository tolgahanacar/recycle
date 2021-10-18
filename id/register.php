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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="form-control">
        <form method="post">
            <div class="mb-3">
                <label for="Username">Username</label><br>
                <input type="text" name="username" id="username">
            </div>
            <div class="mb-3">
                <label for="Name">Name</label><br>
                <input type="text" name="name" id="name">
            </div>
            <div class="mb-3">
                <label for="Name">Surname</label><br>
                <input type="text" name="surname" id="surname">
            </div>
            <div class="mb-3">
                <label for="Surname">E-Mail</label><br>
                <input type="email" name="email" id="email">
            </div>
            <div class="mb-3">
                <label for="Password">Password</label><br>
                <input type="password" name="pass" id="pass">
            </div>
            <div class="mb-3">
                <input type="submit" value="Register" name="register" class="btn btn-primary">
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
            echo "<div class='alert alert-primary' role='alert'>Registration successful.</div>";
            header("location:./login.php");
        } else {
            echo "<div class='alert alert-danger' role='alert'>Registration failed or an error occurred, please contact the administrator!</div>";
        }
    }
    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>