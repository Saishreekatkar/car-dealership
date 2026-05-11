<?php

session_start();

include 'db.php';

if(!isset($_SESSION['is_admin'])){

    header("Location: admin-login.php");
    exit();

}

$id = $_GET['id'];

$sql = "DELETE FROM cars WHERE id='$id'";

mysqli_query($conn, $sql);

header("Location: admin-dashboard.php");

exit();

?>