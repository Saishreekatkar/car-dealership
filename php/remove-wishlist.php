<?php

session_start();

include 'db.php';

$id = $_GET['id'];

$sql = "DELETE FROM wishlist WHERE id='$id'";

mysqli_query($conn, $sql);

header("Location: wishlist.php");
exit();

?>