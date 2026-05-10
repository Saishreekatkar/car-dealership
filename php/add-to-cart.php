<?php

session_start();

include 'db.php';

if(!isset($_SESSION['user_id'])){
    exit();
}

$user_id = $_SESSION['user_id'];

$car_id = $_GET['id'];

// CHECK IF ALREADY EXISTS

$check = "SELECT *
          FROM cart
          WHERE user_id='$user_id'
          AND car_id='$car_id'";

$check_result = mysqli_query($conn, $check);

if(mysqli_num_rows($check_result) > 0){

    echo "already added";
    exit();

}

// INSERT INTO CART

$sql = "INSERT INTO cart(user_id, car_id)
        VALUES('$user_id', '$car_id')";

if(mysqli_query($conn, $sql)){

    echo "success";

}else{

    echo "error";

}

?>