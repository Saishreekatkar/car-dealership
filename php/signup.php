<?php

session_start();

if(isset($_SESSION['user_id'])){
    header("Location: dashboard.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Sign Up - AutoDeal</title>

    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../utils.css">

</head>

<body>

<header>

    <nav>

        <a href="../index.php" class="logo">

            Auto<span>Deal</span>

        </a>

        <ul class="nav-links">

            <li><a href="../index.php">Home</a></li>

            <li><a href="products.php">Products</a></li>

            <li><a href="comparison.php">Comparison</a></li>

            <li><a href="reviews.php">Reviews</a></li>

            <li><a href="about.php">About</a></li>

            <li><a href="contact.php">Contact</a></li>

        </ul>

        <div class="nav-actions">

            <a href="wishlist.php"
               class="icon-btn"
               style="position:relative;">

                <img src="../images/heart_icon.png"
                     alt="wishlist"
                     class="emoji-icon">

                <span class="badge">

                    0

                </span>

            </a>

            <a href="cart.php"
               class="icon-btn"
               style="position:relative;">

                <img src="../images/cart_icon.png"
                     alt="cart"
                     class="emoji-icon">

                <span class="badge">

                    0

                </span>

            </a>

            <a href="login.php"
               class="btn btn-outline">

               Login

            </a>

        </div>

    </nav>

</header>

<div class="form-container">

    <h2 class="form-title">

        Create Your Account

    </h2>

    <form action="register.php" method="POST">

        <div class="form-group">

            <label for="fullname">
                Full Name
            </label>

            <input
                type="text"
                id="fullname"
                name="fullname"
                placeholder="Enter your full name"
                required
            >

        </div>

        <div class="form-group">

            <label for="email">
                Email Address
            </label>

            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter your email"
                required
            >

        </div>

        <div class="form-group">

            <label for="password">
                Password
            </label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Create a password"
                required
            >

        </div>

        <button
            type="submit"
            class="btn btn-primary btn-full"
        >

            Create Account

        </button>

    </form>

    <div class="form-footer">

        <p>

            Already have an account?

            <a href="login.php">
                Login here
            </a>

        </p>

    </div>

</div>

<footer>

    <div class="footer-content">

        <div class="footer-section">

            <h3>AutoDeal</h3>

            <p>
                Your trusted partner in finding the perfect vehicle.
            </p>

        </div>

        <div class="footer-section">

            <h3>Quick Links</h3>

            <ul>

                <li><a href="../index.php">Home</a></li>

                <li><a href="products.php">Products</a></li>

                <li><a href="about.php">About Us</a></li>

                <li><a href="contact.php">Contact</a></li>

            </ul>

        </div>

        <div class="footer-section">

            <h3>Customer Service</h3>

            <ul>

                <li><a href="reviews.php">Reviews</a></li>

                <li><a href="comparison.php">Compare Cars</a></li>

                <li><a href="#">FAQ</a></li>

                <li><a href="#">Support</a></li>

            </ul>

        </div>

        <div class="footer-section">

            <h3>Contact Info</h3>

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

            <p>

                <img src="../images/address_icon.png"
                     alt="address"
                     class="emoji-icon">

                123 Car Street, Auto City

            </p>

        </div>

    </div>

    <div class="footer-bottom">

        <p>
            &copy; 2024 AutoDeal. All rights reserved.
        </p>

    </div>

</footer>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="../scripts/app.js"></script>

</body>
</html>