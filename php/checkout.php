<?php

session_start();

include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// FETCH CART ITEMS

$sql = "SELECT cart.id as cart_id,

               cars.*

        FROM cart

        INNER JOIN cars
        ON cart.car_id = cars.id

        WHERE cart.user_id='$user_id'";

$result = mysqli_query($conn, $sql);

$total = 0;

$cartItems = [];

while($row = mysqli_fetch_assoc($result)){

    $cartItems[] = $row;

    $total += $row['price'];

}

// HANDLE CHECKOUT

if(isset($_POST['place_order'])){

    $deleteQuery = "DELETE FROM cart
                    WHERE user_id='$user_id'";

    mysqli_query($conn, $deleteQuery);

    echo "

    <script>

        alert('Order placed successfully!');

        window.location.href='dashboard.php';

    </script>

    ";

    exit();

}

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Checkout - AutoDeal</title>

    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../utils.css">

</head>

<body>

<?php include 'components/navbar.php'; ?>

<section class="section">

    <div class="container">

        <h2 class="section-title">

            Secure <span>Checkout</span>

        </h2>

        <div class="grid-1fr-400">

            <!-- LEFT -->

            <div class="bg-white p-2 rounded-12 shadow">

                <h3 class="mb-2 text-dark">

                    Billing & Shipping Details

                </h3>

                <form method="POST">

                    <div class="grid-2-col gap-1">

                        <div class="form-group">

                            <label>
                                First Name
                            </label>

                            <input type="text"
                                   required>

                        </div>

                        <div class="form-group">

                            <label>
                                Last Name
                            </label>

                            <input type="text"
                                   required>

                        </div>

                    </div>

                    <div class="form-group">

                        <label>
                            Email Address
                        </label>

                        <input type="email"
                               required>

                    </div>

                    <div class="form-group">

                        <label>
                            Shipping Address
                        </label>

                        <input type="text"
                               required>

                    </div>

                    <div class="grid-2-col gap-1">

                        <div class="form-group">

                            <label>
                                City
                            </label>

                            <input type="text"
                                   required>

                        </div>

                        <div class="form-group">

                            <label>
                                ZIP Code
                            </label>

                            <input type="text"
                                   required>

                        </div>

                    </div>

                    <h3 class="mb-1 mt-2 text-dark">

                        Payment Information

                    </h3>

                    <div class="form-group">

                        <label>
                            Name on Card
                        </label>

                        <input type="text"
                               required>

                    </div>

                    <div class="form-group">

                        <label>
                            Card Number
                        </label>

                        <input type="text"
                               placeholder="1111-2222-3333-4444"
                               required>

                    </div>

                    <div class="grid-2-col gap-1">

                        <div class="form-group">

                            <label>
                                Expiration
                            </label>

                            <input type="text"
                                   placeholder="12/25"
                                   required>

                        </div>

                        <div class="form-group">

                            <label>
                                CVV
                            </label>

                            <input type="text"
                                   placeholder="123"
                                   required>

                        </div>

                    </div>

                    <button type="submit"
                            name="place_order"
                            class="btn btn-primary btn-full mt-2"
                            style="
                                font-size:1.1rem;
                                padding:1rem;
                            ">

                        Place Order

                    </button>

                </form>

            </div>

            <!-- RIGHT -->

            <div>

                <div class="cart-summary sticky-top">

                    <h3 class="mb-15 text-dark">

                        Order Summary

                    </h3>

                    <?php if(count($cartItems) > 0): ?>

                        <?php foreach($cartItems as $car): ?>

                            <div class="summary-row"
                                 style="margin-bottom:15px;">

                                <div>

                                    <strong>

                                        <?php echo $car['car_name']; ?>

                                    </strong>

                                    <br>

                                    <small>

                                        <?php echo $car['brand']; ?>

                                    </small>

                                </div>

                                <span>

                                    ₹<?php echo number_format($car['price']); ?>

                                </span>

                            </div>

                        <?php endforeach; ?>

                        <hr class="mb-1 mt-1">

                        <div class="summary-row">

                            <strong>

                                Total

                            </strong>

                            <strong class="text-primary">

                                ₹<?php echo number_format($total); ?>

                            </strong>

                        </div>

                    <?php else: ?>

                        <p>

                            Your cart is empty.

                        </p>

                    <?php endif; ?>

                    <div class="mt-2 text-center text-light"
                         style="font-size:0.85rem;">

                        <p>

                            <img src="../images/shield_icon.png"
                                 alt="secure"
                                 style="
                                    width:16px;
                                    vertical-align:middle;
                                 ">

                            256-bit SSL Secure Checkout

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<footer>

    <div class="footer-content">

        <div class="footer-section">

            <h3>

                AutoDeal

            </h3>

            <p>

                Your trusted partner in finding the perfect vehicle.

            </p>

        </div>

        <div class="footer-section">

            <h3>

                Quick Links

            </h3>

            <ul>

                <li>
                    <a href="dashboard.php">Home</a>
                </li>

                <li>
                    <a href="products.php">Products</a>
                </li>

                <li>
                    <a href="about.php">About Us</a>
                </li>

                <li>
                    <a href="contact.php">Contact</a>
                </li>

            </ul>

        </div>

        <div class="footer-section">

            <h3>

                Customer Service

            </h3>

            <ul>

                <li>
                    <a href="reviews.php">Reviews</a>
                </li>

                <li>
                    <a href="comparison.php">Compare Cars</a>
                </li>

                <li>
                    <a href="#">FAQ</a>
                </li>

                <li>
                    <a href="#">Support</a>
                </li>

            </ul>

        </div>

        <div class="footer-section">

            <h3>

                Contact Info

            </h3>

            <p>

                <img src="../images/phone_icon.png"
                     alt="phone"
                     class="emoji-icon">

                (555) 123-4567

            </p>

            <p>

                <img src="../images/email_icon.png"
                     alt="email"
                     class="emoji-icon">

                info@autodeal.com

            </p>

        </div>

    </div>

    <div class="footer-bottom">

        <p>

            &copy; 2024 AutoDeal. All rights reserved.

        </p>

    </div>

</footer>

</body>
</html>