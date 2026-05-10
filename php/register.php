<?php

session_start();

include 'db.php';

$fullname = $_POST['fullname'];
$email = $_POST['email'];
$password = $_POST['password'];

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$checkEmail = "SELECT * FROM users WHERE email='$email'";

$result = mysqli_query($conn, $checkEmail);

if(mysqli_num_rows($result) > 0){

    echo "Email already exists";

}
else{

    $sql = "INSERT INTO users(fullname, email, password)
            VALUES('$fullname', '$email', '$hashedPassword')";

    if(mysqli_query($conn, $sql)){

        $user_id = mysqli_insert_id($conn);

        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $fullname;
        $_SESSION['user_email'] = $email;

        header("Location: dashboard.php");
        exit();

    }
    else{

        echo "Error: " . mysqli_error($conn);

    }

}

?>