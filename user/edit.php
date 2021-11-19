<?php
require_once '../user/userinfo.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include '../inc/seotags.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../src/css/style.css">
    <script src="../src/js/main.js" type="text/javascript"></script>
</head>
<?php include '../inc/header.php'; ?>

<body>
    <div class="container">
        <div class="form-control">
            <?php if (isset($_GET['my'])) { ?>
                <form method="post">
                    <div class="mb-3">
                        <label for="Username">Username</label><br>
                        <input type="text" name="username" id="username" value="<?php echo $username; ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="Name">Name</label><br>
                        <input type="text" name="name" id="name" value="<?php echo $name; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="Surname">Surname</label><br>
                        <input type="text" name="surname" id="surname" value="<?php echo $surname; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="E-Mail">E-Mail</label><br>
                        <input type="email" name="email" id="email" value="<?php echo DecryptData($email); ?>" required>
                    </div>
                    <div class="mb-3">
                        <input type="submit" value="Update" name="update" class="btn btn-primary">
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>
    <?php
    if (isset($_POST['update'])) {
        $name      = Security(ucwords(strtolower($_POST['name'])));
        $surname   = Security(ucwords(strtolower($_POST['surname'])));
        $email     = Security($_POST['email']);

        if (empty($name) || empty($surname) || empty($email)) {
            die("<div class='container'><div class='alert alert-danger'>Empty Blank!</div></div>");
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

        $query = $db->prepare("SELECT * FROM users WHERE EMail = :email");
        $query->bindParam(":email", $email, PDO::PARAM_STR);
        $query->execute();
        $count = $query->rowCount();
        if ($count > 0) {
            die("<div class='container'><div class='alert alert-danger' role='alert'>This user is registered in the system!</div></div>");
        }

        $encryptEmail = EncryptData($email);
        $update = $db->prepare("UPDATE users SET Name = :name, Surname = :surname, EMail = :email WHERE Session_Token = :token");
        $update->bindParam("name", $name, PDO::PARAM_STR);
        $update->bindParam("surname", $surname, PDO::PARAM_STR);
        $update->bindParam("email", $encryptEmail, PDO::PARAM_STR);
        $update->bindParam("token", $token, PDO::PARAM_STR);
        $update->execute();
        if($update){
            echo "<div class='container'><div class='alert alert-success'>The update was successful.</div></div>";
        }else{
            die("<div class='container'><div class='alert alert-danger>The update process failed. Please try again later.</div></div>");
        }
    }
    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<?php include '../inc/footer.php'; ?>

</html>