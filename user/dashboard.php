<?php
require_once '../user/userinfo.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="">
    <title>Dashboard | Recycle</title>
    <?php include '../inc/seotags.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../src/css/style.css">
    <script src="../src/js/main.js" type="text/javascript"></script>
</head>
<?php include '../inc/header.php'; ?>

<body>
    <div class="container">
        <div class="row">
            <div class="col-6">
                Welcome, <?php echo "<b>" . $name . " " . $surname . "</b>"; ?>
                <a href="../user/exit.php">Exit</a>
            </div>
            <div class="col-6">
                <span><b>Points</b> <span class="badge bg-success">4</span></span>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<?php include '../inc/footer.php'; ?>

</html>