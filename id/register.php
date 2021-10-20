<?php
require_once '../root/root.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="">
    <title>Register | Recycle</title>
    <?php include '../inc/seotags.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="form-control">
            <form method="post">
                <div class="mb-3">
                    <label for="Username"><b>Username</b></label><br>
                    <input type="text" name="username" id="username" required>
                </div>
                <div class="mb-3">
                    <label for="Name"><b>Name</label></b><br>
                    <input type="text" name="name" id="name" required>
                </div>
                <div class="mb-3">
                    <label for="Name"><b>Surname</label></b><br>
                    <input type="text" name="surname" id="surname" required>
                </div>
                <div class="mb-3">
                    <label for="Surname"><b>E-Mail</label></b><br>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="Password"><b>Password</label></b><br>
                    <input type="password" name="pass" id="pass" required>
                </div>
                <div class="mb-3">
                    <span>Already a member? <a href="./login.php">Login</a></span>
                </div>
                <div class="mb-3">
                    <input type="submit" value="Register" name="register" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
    <?php
    if (isset($_POST['register'])) {
        $username  = Security($_POST['username']);
        $name      = Security(ucwords(strtolower($_POST['name'])));
        $surname   = Security(ucwords(strtolower($_POST['surname'])));
        $email     = Security($_POST['email']);
        $password2 = Security($_POST['pass']);
        $control        = "/\S*((?=\S{8,})(?=\S*[A-Z]))\S*/";
        if (empty($username) || empty($name) || empty($surname) || empty($email) || empty($password2)) {
            die("<div class='container'><div class='alert alert-danger' role='alert'>Empty Blank!</div></div>");
        }
        if (is_numeric($name) || is_numeric($surname)) {
            die("<div class='container'><div class='alert alert-danger' role='alert'>The first or last name does not contain a numeric value!</div></div>");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("<div class='container'><div class='alert alert-danger' role='alert'>The e-mail you entered does not meet the e-mail criteria!</div></div>");
        }

        $dontuse = "+";
        if (strpos($email, $dontuse)) {
            die("<div class='container'><div class='alert alert-danger' role='alert'>Please do not use invalid signs or register more than once.</div></div>");
        }

        $query = $db->prepare("SELECT * FROM users WHERE Username = :username OR EMail = :email");
        $query->bindParam(":username", $username, PDO::PARAM_STR);
        $query->bindParam(":email", $email, PDO::PARAM_STR);
        $query->execute();
        $count = $query->rowCount();
        if ($count > 0) {
            die("<div class='container'><div class='alert alert-danger' role='alert'>This user is registered in the system!</div></div>");
        }

        if (!preg_match($control, $password2) || strlen($password2) < 8) {
            die("<div class='container'><div class='alert alert-danger' role='alert'>Please re-enter your password with 1 capital letter and at least 8 characters!</div></div>");
        }

        $password = PassHash($password2);
        $status = 0;
        $token  = uniqid(md5('__token__'));

        $reg = $db->prepare("INSERT INTO users (Username, Name, Surname, EMail, Password, Status, Session_Token) VALUES (:username, :name, :surname, :email, :password, :status, :token)");
        $reg->bindParam(":username", $username, PDO::PARAM_STR);
        $reg->bindParam(":name", $name, PDO::PARAM_STR);
        $reg->bindParam(":surname", $surname, PDO::PARAM_STR);
        $reg->bindParam(":email", $email, PDO::PARAM_STR);
        $reg->bindParam(":password", $password, PDO::PARAM_STR);
        $reg->bindParam(":status", $status, PDO::PARAM_INT);
        $reg->bindParam(":token", $token, PDO::PARAM_STR);
        $reg->execute();
        if ($db->lastInsertId()) {
            echo "<div class='container'><div class='alert alert-success' role='alert'>Registration successful.</div></div>";
            header("Refresh: 1; url=./login.php");
        } else {
            echo "<div class='container'><div class='alert alert-danger' role='alert'>Registration failed or an error occurred, please contact the administrator!</div></div>";
        }
    }
    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>