<?php
require_once '../root/root.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Recycle</title>
    <?php include '../inc/seotags.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="form-control">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="Username"><b>Username</b></label><br>
                    <input type="text" name="username" id="username" required>
                </div>
                <div class="mb-3">
                    <label for="Password"><b>Password</b></label><br>
                    <input type="password" name="pass" id="pass" required>
                </div>
                <div class="mb-3">
                    <span>Not a member? </span><a href="./register.php">Register now</a>
                </div>
                <div>
                    <input type="submit" value="Login" name="login" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>

    <?php
    if (isset($_POST['login'])) {
        $username = Security($_POST['username']);
        $password2     = Security($_POST['pass']);

        if (empty($username) || empty($password2)) {
            die("Empty blank!");
        }

        $pass = PassHash($password2);
        $status = 1;
        $query = $db->prepare("SELECT * FROM users WHERE Username = :username AND Password = :pass AND Status = :status");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->bindParam("pass", $pass, PDO::PARAM_STR);
        $query->bindParam("status", $status, PDO::PARAM_INT);
        $query->execute();
        $count = $query->rowCount();
        if ($count > 0) {
            $query2 = $query->fetchAll(PDO::FETCH_OBJ);
            foreach ($query2 as $item) {
                $_SESSION['user_session'] = $item->Session_Token;
            }
            echo "<div class='container'><div class='alert alert-success' role='alert'>You log in successfully, you are redirected to the homepage.</div></div>";
            header("Refresh: 1; url=../user/dashboard.php");
        } else {
            die("<div class='container'><div class='alert alert-danger' role='alert'>Login failed, Please check and try again.</div></div>");
        }
    }
    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>