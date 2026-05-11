<?php

session_start();

include 'db.php';

if(!isset($_SESSION['is_admin'])){

    header("Location: admin-login.php");
    exit();

}

// TOTAL USERS

$users_query = "SELECT COUNT(*) as total FROM users";
$users_result = mysqli_query($conn, $users_query);
$users_data = mysqli_fetch_assoc($users_result);

// TOTAL CARS

$cars_query = "SELECT COUNT(*) as total FROM cars";
$cars_result = mysqli_query($conn, $cars_query);
$cars_data = mysqli_fetch_assoc($cars_result);

// FETCH ALL CARS

$cars_sql = "SELECT * FROM cars ORDER BY id DESC";
$cars_result_full = mysqli_query($conn, $cars_sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../utils.css">

    <style>

        body{

            background:#f5f5f5;

        }

        .admin-container{

            width:90%;
            margin:40px auto;

        }

        .top-bar{

            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:30px;

        }

        .stats{

            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
            gap:20px;
            margin-bottom:40px;

        }

        .stat-card{

            background:white;
            padding:25px;
            border-radius:12px;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);
            text-align:center;

        }

        .stat-card h2{

            font-size:40px;
            color:#ff4d4d;

        }

        table{

            width:100%;
            border-collapse:collapse;
            background:white;
            border-radius:12px;
            overflow:hidden;

        }

        table th,
        table td{

            padding:15px;
            border-bottom:1px solid #eee;

        }

        table th{

            background:#ff4d4d;
            color:white;

        }

        .car-image{

            width:120px;
            height:80px;
            object-fit:cover;
            border-radius:8px;

        }

    </style>

</head>

<body>

<div class="admin-container">

    <div class="top-bar">

        <h1>

            Admin Dashboard

        </h1>

        <a href="admin-logout.php"
           class="btn btn-outline">

           Logout

        </a>

    </div>

    <div class="stats">

        <div class="stat-card">

            <h2>

                <?php echo $users_data['total']; ?>

            </h2>

            <p>

                Total Users

            </p>

        </div>

        <div class="stat-card">

            <h2>

                <?php echo $cars_data['total']; ?>

            </h2>

            <p>

                Total Cars

            </p>

        </div>

    </div>

    <h2 style="margin-bottom:20px;">

        Manage Cars

    </h2>

    <table>

        <tr>

            <th>ID</th>

            <th>Image</th>

            <th>Car Name</th>

            <th>Brand</th>

            <th>Price</th>

            <th>Year</th>

            <th>Action</th>

        </tr>

        <?php while($car = mysqli_fetch_assoc($cars_result_full)): ?>

            <tr>

                <td>

                    <?php echo $car['id']; ?>

                </td>

                <td>

                    <img
                        src="../uploads/<?php echo $car['image']; ?>"
                        class="car-image"
                    >

                </td>

                <td>

                    <?php echo $car['car_name']; ?>

                </td>

                <td>

                    <?php echo $car['brand']; ?>

                </td>

                <td>

                    ₹<?php echo number_format($car['price']); ?>

                </td>

                <td>

                    <?php echo $car['year']; ?>

                </td>

                <td>

                    <a href="delete-car.php?id=<?php echo $car['id']; ?>"
                       class="btn btn-secondary">

                       Delete

                    </a>

                </td>

            </tr>

        <?php endwhile; ?>

    </table>

</div>

</body>
</html>