<?php

session_start();

include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT cart.id as cart_id,

               cars.*

        FROM cart

        INNER JOIN cars

        ON cart.car_id = cars.id

        WHERE cart.user_id='$user_id'";

$result = mysqli_query($conn, $sql);

$total = 0;
$item_count = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Shopping Cart - AutoDeal</title>

    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../utils.css">

</head>

<body>

<?php include 'components/navbar.php'; ?>

<section class="section">

    <div class="container">

        <h2 class="section-title">

            Shopping <span>Cart</span>

        </h2>

        <?php if(mysqli_num_rows($result) > 0): ?>

            <div class="cards-grid">

                <?php while($car = mysqli_fetch_assoc($result)): ?>

                    <?php

                        $total += $car['price'];
                        $item_count++;

                    ?>

                    <div class="card">

                        <img
                            class="card-image-img"

                            src="../uploads/<?php echo $car['image']; ?>"

                            alt="car"

                            style="
                                width:100%;
                                height:200px;
                                object-fit:cover;
                            "
                        >

                        <div class="card-content">

                            <h3 class="card-title">

                                <?php echo $car['car_name']; ?>

                            </h3>

                            <div class="card-price">

                                ₹<?php echo number_format($car['price']); ?>

                            </div>

                            <ul class="card-details">

                                <li>

                                    Brand:
                                    <?php echo $car['brand']; ?>

                                </li>

                                <li>

                                    Model:
                                    <?php echo $car['model']; ?>

                                </li>

                                <li>

                                    Year:
                                    <?php echo $car['year']; ?>

                                </li>

                                <li>

                                    Fuel:
                                    <?php echo $car['fuel_type']; ?>

                                </li>

                            </ul>

                            <div class="card-actions">

                                <a href="remove-cart.php?id=<?php echo $car['cart_id']; ?>"
                                   class="btn btn-secondary">

                                   Remove

                                </a>

                            </div>

                        </div>

                    </div>

                <?php endwhile; ?>

            </div>

            <div class="cart-summary mt-2">

                <h3>
                    Order Summary
                </h3>

                <div class="summary-row">

                    <span>
                        Total Items
                    </span>

                    <span>
                        <?php echo $item_count; ?>
                    </span>

                </div>

                <div class="summary-row">

                    <span>
                        Total Price
                    </span>

                    <span class="text-primary">

                        ₹<?php echo number_format($total); ?>

                    </span>

                </div>

                <div class="mt-2">

                   <a href="checkout.php"
   class="btn btn-primary btn-full">

   Proceed To Checkout

</a>

                </div>

            </div>

        <?php else: ?>

            <div class="bg-white p-2 rounded-12 shadow text-center">

                <h3 class="mb-1">
                    Your cart is empty
                </h3>

                <p class="mb-2">
                    Browse vehicles and add them to your cart.
                </p>

                <a href="products.php"
                   class="btn btn-primary">

                   Browse Vehicles

                </a>

            </div>

        <?php endif; ?>

    </div>

</section>

</body>
</html>