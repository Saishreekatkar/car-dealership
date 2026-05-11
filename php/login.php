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

    <title>Login - AutoDeal</title>

    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../utils.css">

</head>

<body>

<header>

    <nav>

        <a href="../index.php"
           class="logo">

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

            <a href="signup.php"
               class="btn btn-primary">

               Sign Up

            </a>

            <a href="admin-login.php"
               style="
                    background:orange;
                    color:white;
                    padding:10px 14px;
                    border-radius:8px;
                    margin-left:10px;
                    text-decoration:none;
                    font-weight:bold;
                    font-size:14px;
               ">

               Admin

            </a>

        </div>

    </nav>

</header>

<div class="form-container">

    <h2 class="form-title">

        Login to Your Account

    </h2>

    <form action="login-process.php"
          method="POST">

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
                placeholder="Enter your password"
                required
            >

        </div>

        <div class="form-group">

            <label>

                <input
                    type="checkbox"
                    name="remember"
                >

                Remember me

            </label>

        </div>

        <button
            type="submit"
            class="btn btn-primary btn-full">

            Login

        </button>

    </form>

    <div class="form-footer">

        <p>

            Don't have an account?

            <a href="signup.php">

                Sign up here

            </a>

        </p>

        <p>

            <a href="#">

                Forgot your password?

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