<?php
require_once '../root/root.php';
if (isset($_SESSION['user_session']) || !empty($_SESSION['user_session'])) {
    $token = $_SESSION['user_session'];
    $query = $db->prepare("SELECT * FROM users WHERE Session_Token = :token");
    $query->bindParam(":token", $token, PDO::PARAM_INT);
    $query->execute();
    $count = $query->rowCount();
    $query2 = $query->fetchAll(PDO::FETCH_OBJ);
    if ($count > 0) {
        foreach ($query2 as $item) {
            $username = $item->Username;
            $name     = $item->Name;
            $surname  = $item->Surname;
            $email    = $item->EMail;
        }
    } else {
        header("Refresh:1;url:../user/exit.php");
        die("User not found!");
    }
} else {
    header("location:../user/exit.php");
}
