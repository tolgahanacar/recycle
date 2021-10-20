<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
setlocale(LC_TIME, 'tr_TR.UTF-8');
date_default_timezone_set('Europe/Istanbul');
/*echo strftime('%e %B %Y %A %H:%M:%S');*/
session_start();
require_once '../root/connect.php';
require_once '../root/functions.php';
