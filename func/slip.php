<?php

use Employee\Factory\Privileged\VPMO;

include_once '../includes/autoloader.inc.php';


session_start();

if (!isset($_SESSION['employee'])) {
    header('Location: ../Layout/login.php');
    exit;
}
// if($_SESSION['employee'] !== VPMO::class)
//     die("Only VPMO is authorized to generate a handout slip.");

if (!isset($_GET['id'])) {
    header('Location: ../Layout/404.php');
    exit;
}
$employee = $_SESSION['employee'];
$employee->generateVehicleHandoutSlip((int)$_GET['id']);