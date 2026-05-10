<?php

session_start();

include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$car_id = $_GET['id'];

$check = "SELECT * FROM cart
          WHERE user_id='$user_id'
          AND car_id='$car_id'";

$result = mysqli_query($conn, $check);

if(mysqli_num_rows($result) == 0){

    $sql = "INSERT INTO cart(user_id, car_id)
            VALUES('$user_id', '$car_id')";

    mysqli_query($conn, $sql);

}
echo "Added to cart";

?>