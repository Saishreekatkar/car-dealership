<?php

session_start();

include 'db.php';

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");

    exit();

}

$user_id = $_SESSION['user_id'];

$user_name = $_SESSION['user_name'];

// GET USER LISTINGS

$sql = "SELECT *
        FROM cars
        WHERE seller_id='$user_id'
        ORDER BY id DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Profile - AutoDeal</title>

    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../utils.css">

    <style>

        .profile-wrapper{

            max-width:1200px;
            margin:40px auto;
            padding:20px;

        }

        .profile-card{

            background:white;
            padding:30px;
            border-radius:16px;
            box-shadow:0 4px 12px rgba(0,0,0,0.08);
            margin-bottom:30px;

        }

        .listing-grid{

            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
            gap:20px;

        }

        .listing-card{

            background:white;
            border-radius:14px;
            overflow:hidden;
            box-shadow:0 2px 10px rgba(0,0,0,0.08);

        }

        .listing-card img{

            width:100%;
            height:200px;
            object-fit:cover;

        }

        .listing-content{

            padding:20px;

        }

    </style>

</head>

<body>

<?php include 'components/navbar.php'; ?>

<div class="profile-wrapper">

    <!-- PROFILE SECTION -->

    <div class="profile-card">

        <h2>

            👤 My Profile

        </h2>

        <p>

            Welcome,
            <strong>

                <?php echo $user_name; ?>

            </strong>

        </p>

        <br>

        <form action="change-password.php"
              method="POST">

            <div class="form-group">

                <label>

                    New Password

                </label>

                <input
                    type="password"
                    name="new_password"
                    placeholder="Enter new password"
                    required
                >

            </div>

            <br>

            <button
                type="submit"
                class="btn btn-primary">

                Change Password

            </button>

        </form>

    </div>

    <!-- USER LISTINGS -->

    <div class="profile-card">

        <h2>

            🚗 My Listings

        </h2>

        <br>

        <?php if(mysqli_num_rows($result) > 0): ?>

            <div class="listing-grid">

                <?php while($car = mysqli_fetch_assoc($result)): ?>

                    <div class="listing-card">

                        <img
                            src="../uploads/<?php echo $car['image']; ?>"
                            alt="car"
                        >

                        <div class="listing-content">

                            <h3>

                                <?php echo $car['car_name']; ?>

                            </h3>

                            <p>

                                ₹<?php echo number_format($car['price']); ?>

                            </p>

                            <br>

                            <a href="car-details.php?id=<?php echo $car['id']; ?>"
                               class="btn btn-primary">

                               View

                            </a>

                            <a href="delete-car.php?id=<?php echo $car['id']; ?>"
                               class="btn btn-secondary">

                               Delete

                            </a>

                        </div>

                    </div>

                <?php endwhile; ?>

            </div>

        <?php else: ?>

            <p>

                You have not uploaded any vehicles yet.

            </p>

        <?php endif; ?>

    </div>

</div>

</body>
</html>