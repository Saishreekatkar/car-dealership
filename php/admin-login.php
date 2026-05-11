<?php

session_start();

include 'db.php';

if(isset($_POST['admin_login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    if($username == "admin" && $password == "admin"){

        $_SESSION['is_admin'] = true;

        header("Location: admin-dashboard.php");
        exit();

    }else{

        $error = "Invalid Admin Credentials";

    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Login</title>

    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../utils.css">

    <style>

        body{

            background:#f5f5f5;

        }

        .login-box{

            width:400px;
            margin:100px auto;
            background:white;
            padding:40px;
            border-radius:12px;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);

        }

        .login-box h2{

            text-align:center;
            margin-bottom:30px;

        }

        .login-box input{

            width:100%;
            padding:14px;
            margin-bottom:20px;
            border:1px solid #ccc;
            border-radius:8px;

        }

        .error{

            background:#ffdddd;
            color:red;
            padding:12px;
            margin-bottom:20px;
            border-radius:8px;

        }

    </style>

</head>

<body>

<div class="login-box">

    <h2>

        Admin Login

    </h2>

    <?php if(isset($error)): ?>

        <div class="error">

            <?php echo $error; ?>

        </div>

    <?php endif; ?>

    <form method="POST">

        <input
            type="text"
            name="username"
            placeholder="Admin Username"
            required
        >

        <input
            type="password"
            name="password"
            placeholder="Admin Password"
            required
        >

        <button
            type="submit"
            name="admin_login"
            class="btn btn-primary btn-full">

            Login

        </button>

    </form>

</div>

</body>
</html>