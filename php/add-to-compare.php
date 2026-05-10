<?php

session_start();

if(!isset($_SESSION['compare'])){

    $_SESSION['compare'] = [];

}

$car_id = $_GET['id'];

// PREVENT DUPLICATES

if(in_array($car_id, $_SESSION['compare'])){

    echo "exists";
    exit();

}

// LIMIT TO 3

if(count($_SESSION['compare']) >= 3){

    echo "limit";
    exit();

}

// ADD

$_SESSION['compare'][] = $car_id;

echo "success";

?>