<?php

session_start();

include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$seller_id = $_SESSION['user_id'];

$car_name = $_POST['car_name'];
$brand = $_POST['brand'];
$model = $_POST['model'];
$year = $_POST['year'];
$fuel_type = $_POST['fuel_type'];
$transmission = $_POST['transmission'];
$kilometers_driven = $_POST['kilometers_driven'];
$price = $_POST['price'];
$description = $_POST['description'];

$image_name = $_FILES['image']['name'];
$image_tmp = $_FILES['image']['tmp_name'];

move_uploaded_file(
    $image_tmp,
    "../uploads/" . $image_name
);

$sql = "INSERT INTO cars(

            seller_id,
            car_name,
            brand,
            model,
            year,
            fuel_type,
            transmission,
            kilometers_driven,
            price,
            description,
            image

        )

        VALUES(

            '$seller_id',
            '$car_name',
            '$brand',
            '$model',
            '$year',
            '$fuel_type',
            '$transmission',
            '$kilometers_driven',
            '$price',
            '$description',
            '$image_name'

        )";

if(mysqli_query($conn, $sql)){

    header("Location: products.php");
    exit();

}
else{

    echo "Error: " . mysqli_error($conn);

}

?>