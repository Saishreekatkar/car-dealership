<?php

session_start();

include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// FETCH WISHLIST CARS ONLY

$allCarsQuery = "SELECT cars.*

                 FROM wishlist

                 INNER JOIN cars
                 ON wishlist.car_id = cars.id

                 WHERE wishlist.user_id='$user_id'

                 ORDER BY cars.car_name ASC";

$allCarsResult = mysqli_query($conn, $allCarsQuery);

// GET SELECTED CARS

$car1 = $_GET['car1'] ?? '';
$car2 = $_GET['car2'] ?? '';
$car3 = $_GET['car3'] ?? '';

$selectedCars = [];

$carIds = array_filter([$car1, $car2, $car3]);

if(count($carIds) > 0){

    $ids = implode(",", $carIds);

    $compareQuery = "SELECT * FROM cars WHERE id IN ($ids)";

    $compareResult = mysqli_query($conn, $compareQuery);

    while($row = mysqli_fetch_assoc($compareResult)){

        $selectedCars[] = $row;

    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Compare Cars - AutoDeal</title>

    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../utils.css">

    <style>

        .compare-form{

            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
            gap:20px;
            margin-bottom:40px;

        }

        .compare-form select{

            width:100%;
            padding:12px;
            border:1px solid #ccc;
            border-radius:8px;
            font-size:16px;
            background:white;

        }

        .compare-grid{

            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
            gap:25px;

        }

        .compare-card{

            background:white;
            border-radius:14px;
            overflow:hidden;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);

        }

        .compare-card img{

            width:100%;
            height:220px;
            object-fit:cover;

        }

        .compare-content{

            padding:20px;

        }

        .compare-content h3{

            margin-bottom:10px;
            font-size:24px;

        }

        .compare-price{

            color:#ff4d4d;
            font-size:24px;
            font-weight:bold;
            margin-bottom:20px;

        }

        .spec{

            margin-bottom:12px;
            color:#555;
            line-height:1.5;

        }

        .empty-box{

            background:white;
            padding:40px;
            border-radius:14px;
            text-align:center;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);

        }

    </style>

</head>

<body>

<?php include 'components/navbar.php'; ?>

<section class="section">

    <div class="container">

        <h2 class="section-title">

            Compare Your <span>Wishlist</span>

        </h2>

        <?php if(mysqli_num_rows($allCarsResult) > 0): ?>

        <form method="GET"
              class="compare-form">

            <select name="car1">

                <option value="">
                    Select Wishlist Car 1
                </option>

                <?php

                mysqli_data_seek($allCarsResult, 0);

                while($car = mysqli_fetch_assoc($allCarsResult)):

                ?>

                    <option
                        value="<?php echo $car['id']; ?>"

                        <?php
                        if($car1 == $car['id']) echo "selected";
                        ?>

                    >

                        <?php echo $car['car_name']; ?>

                    </option>

                <?php endwhile; ?>

            </select>

            <select name="car2">

                <option value="">
                    Select Wishlist Car 2
                </option>

                <?php

                mysqli_data_seek($allCarsResult, 0);

                while($car = mysqli_fetch_assoc($allCarsResult)):

                ?>

                    <option
                        value="<?php echo $car['id']; ?>"

                        <?php
                        if($car2 == $car['id']) echo "selected";
                        ?>

                    >

                        <?php echo $car['car_name']; ?>

                    </option>

                <?php endwhile; ?>

            </select>

            <select name="car3">

                <option value="">
                    Select Wishlist Car 3
                </option>

                <?php

                mysqli_data_seek($allCarsResult, 0);

                while($car = mysqli_fetch_assoc($allCarsResult)):

                ?>

                    <option
                        value="<?php echo $car['id']; ?>"

                        <?php
                        if($car3 == $car['id']) echo "selected";
                        ?>

                    >

                        <?php echo $car['car_name']; ?>

                    </option>

                <?php endwhile; ?>

            </select>

            <button
                type="submit"
                class="btn btn-primary">

                Compare Cars

            </button>

        </form>

        <?php else: ?>

            <div class="empty-box">

                <h3 class="mb-1">

                    Your wishlist is empty

                </h3>

                <p class="mb-2">

                    Add some vehicles to your wishlist first.

                </p>

                <a href="products.php"
                   class="btn btn-primary">

                   Browse Vehicles

                </a>

            </div>

        <?php endif; ?>

        <?php if(count($selectedCars) > 0): ?>

            <div class="compare-grid">

                <?php foreach($selectedCars as $car): ?>

                    <div class="compare-card">

                        <img
                            src="../uploads/<?php echo $car['image']; ?>"
                            alt="car"
                        >

                        <div class="compare-content">

                            <h3>

                                <?php echo $car['car_name']; ?>

                            </h3>

                            <div class="compare-price">

                                ₹<?php echo number_format($car['price']); ?>

                            </div>

                            <div class="spec">

                                <strong>Brand:</strong>

                                <?php echo $car['brand']; ?>

                            </div>

                            <div class="spec">

                                <strong>Model:</strong>

                                <?php echo $car['model']; ?>

                            </div>

                            <div class="spec">

                                <strong>Year:</strong>

                                <?php echo $car['year']; ?>

                            </div>

                            <div class="spec">

                                <strong>Fuel Type:</strong>

                                <?php echo $car['fuel_type']; ?>

                            </div>

                            <div class="spec">

                                <strong>Transmission:</strong>

                                <?php echo $car['transmission']; ?>

                            </div>

                            <div class="spec">

                                <strong>KM Driven:</strong>

                                <?php echo number_format($car['kilometers_driven']); ?>

                            </div>

                            <div class="spec">

                                <strong>Description:</strong>

                                <?php echo $car['description']; ?>

                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</section>

</body>
</html>