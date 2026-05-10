<?php

session_start();

include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id'])){
    die("Car not found");
}

$car_id = $_GET['id'];

$sql = "SELECT * FROM cars
        WHERE id='$car_id'";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 0){
    die("Vehicle not found");
}

$car = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        <?php echo $car['car_name']; ?> - AutoDeal
    </title>

    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../utils.css">

    <style>

        .details-container{

            max-width:1200px;
            margin:50px auto;
            padding:20px;

        }

        .details-grid{

            display:grid;
            grid-template-columns:1fr 1fr;
            gap:40px;

            background:white;
            padding:30px;

            border-radius:16px;
            box-shadow:0 5px 20px rgba(0,0,0,0.1);

        }

        .details-image{

            width:100%;
            height:450px;
            object-fit:cover;
            border-radius:12px;

        }

        .details-info h1{

            margin-bottom:10px;

        }

        .price{

            font-size:32px;
            color:#ff4d4d;
            font-weight:bold;
            margin-bottom:20px;

        }

        .specs{

            margin-top:20px;

        }

        .specs li{

            list-style:none;
            padding:12px 0;
            border-bottom:1px solid #eee;

        }

        .description{

            margin-top:30px;
            line-height:1.8;

        }

        .action-buttons{

            margin-top:30px;
            display:flex;
            gap:15px;

        }

    </style>

</head>

<body>

<?php include 'components/navbar.php'; ?>

<div class="details-container">

    <div class="details-grid">

        <div>

            <img
                src="../uploads/<?php echo $car['image']; ?>"
                alt="car"
                class="details-image"
            >

        </div>

        <div class="details-info">

            <h1>

                <?php echo $car['car_name']; ?>

            </h1>

            <div class="price">

                ₹<?php echo number_format($car['price']); ?>

            </div>

            <ul class="specs">

                <li>
                    <strong>Brand:</strong>
                    <?php echo $car['brand']; ?>
                </li>

                <li>
                    <strong>Model:</strong>
                    <?php echo $car['model']; ?>
                </li>

                <li>
                    <strong>Year:</strong>
                    <?php echo $car['year']; ?>
                </li>

                <li>
                    <strong>Fuel Type:</strong>
                    <?php echo $car['fuel_type']; ?>
                </li>

                <li>
                    <strong>Transmission:</strong>
                    <?php echo $car['transmission']; ?>
                </li>

                <li>
                    <strong>Kilometers Driven:</strong>
                    <?php echo number_format($car['kilometers_driven']); ?> KM
                </li>

            </ul>

            <div class="description">

                <h3>Description</h3>

                <p>

                    <?php echo $car['description']; ?>

                </p>

            </div>

            <div class="action-buttons">

                <button
                    class="btn btn-primary add-cart-btn"
                    data-id="<?php echo $car['id']; ?>">

                    Add to Cart

                </button>

                <button
                    class="btn btn-outline add-wishlist-btn"
                    data-id="<?php echo $car['id']; ?>">

                    Add to Wishlist

                </button>

            </div>

        </div>

    </div>

</div>

<script>

document.querySelector(".add-cart-btn")
.addEventListener("click", function(){

    const carId = this.dataset.id;

    fetch(`add-to-cart.php?id=${carId}`)
        .then(response => response.text())
        .then(data => {

            if(data.includes("success")){

                const badge =
                    document.getElementById("cart-badge");

                badge.innerText =
                    parseInt(badge.innerText) + 1;

            }

        });

});

document.querySelector(".add-wishlist-btn")
.addEventListener("click", function(){

    const carId = this.dataset.id;

    fetch(`add-to-wishlist.php?id=${carId}`)
        .then(response => response.text())
        .then(data => {

            if(data.includes("success")){

                const badge =
                    document.getElementById("wishlist-badge");

                badge.innerText =
                    parseInt(badge.innerText) + 1;

            }

        });

});

</script>

</body>
</html>