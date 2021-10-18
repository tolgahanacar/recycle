<?php
//recycle
try{
    $db = new PDO("mysql:host=localhost;dbname=recycle;charset=UTF8","tolga","123456");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    die($e->getMessage());
    
}