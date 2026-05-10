<?php

session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoDeal - Premium Car Dealership</title>

    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../utils.css">

</head>

<body>

    <header>

        <nav>

            <a href="dashboard.php" class="logo">
                Auto<span>Deal</span>
            </a>

            <ul class="nav-links">

                <li><a href="dashboard.php">Home</a></li>

                <li><a href="../products.html">Products</a></li>

                <li><a href="../comparison.html">Comparison</a></li>

                <li><a href="../reviews.html">Reviews</a></li>

                <li><a href="../about.html">About</a></li>

                <li><a href="../contact.html">Contact</a></li>

            </ul>

            <div class="nav-actions">

                <a href="../wishlist.html" class="icon-btn">

                    <img src="../images/heart_icon.png"
                         alt="wishlist"
                         class="emoji-icon">

                    <span class="badge">3</span>

                </a>

                <a href="../cart.html" class="icon-btn">

                    <img src="../images/cart_icon.png"
                         alt="cart"
                         class="emoji-icon">

                    <span class="badge">2</span>

                </a>

                <span class="welcome-text">

                    Welcome,
                    <?php echo $_SESSION['user_name']; ?>

                </span>

                <a href="logout.php" class="btn btn-outline">

                    Logout

                </a>

            </div>

        </nav>

    </header>

    <section class="hero">

        <h1>Find Your Dream Car Today</h1>

        <p>
            Discover premium vehicles at unbeatable prices
        </p>

        <div class="hero-buttons">

            <a href="../products.html"
               class="btn btn-primary">

               Browse Cars

            </a>

            <a href="../contact.html"
               class="btn btn-secondary">

               Contact Us

            </a>

        </div>

    </section>

    <section class="section">

        <div class="container">

            <h2 class="section-title">

                Featured <span>Vehicles</span>

            </h2>

            <div class="cards-grid">

                <!-- CARD 1 -->

                <div class="card">

                    <img class="card-image-img"
                         src="../images/luxury_sedan.png"
                         alt="Vehicle"
                         style="width: 100%; height: 200px; object-fit: cover; display: block;">

                    <div class="card-content">

                        <h3 class="card-title">
                            2024 Luxury Sedan
                        </h3>

                        <div class="card-price">
                            $45,999
                        </div>

                        <ul class="card-details">

                            <li>
                                <img src="../images/engine_icon.png"
                                     alt="engine"
                                     class="emoji-icon">

                                250 HP Engine
                            </li>

                            <li>
                                <img src="../images/fuel_icon.png"
                                     alt="fuel"
                                     class="emoji-icon">

                                28 MPG City
                            </li>

                            <li>
                                <img src="../images/shield_icon.png"
                                     alt="warranty"
                                     class="emoji-icon">

                                5-Year Warranty
                            </li>

                        </ul>

                        <div class="card-actions">

                            <a href="#"
                               class="btn btn-primary">

                               Add to Cart

                            </a>

                            <a href="#"
                               class="btn btn-outline">

                               <img src="../images/heart_icon.png"
                                    alt="wishlist"
                                    class="emoji-icon">

                            </a>

                            <a href="#"
                               class="btn btn-secondary">

                               View Details

                            </a>

                        </div>

                    </div>

                </div>

                <!-- CARD 2 -->

                <div class="card">

                    <img class="card-image-img"
                         src="../images/sport_suv.png"
                         alt="Vehicle"
                         style="width: 100%; height: 200px; object-fit: cover; display: block;">

                    <div class="card-content">

                        <h3 class="card-title">
                            2024 Sport SUV
                        </h3>

                        <div class="card-price">
                            $52,999
                        </div>

                        <ul class="card-details">

                            <li>
                                <img src="../images/engine_icon.png"
                                     alt="engine"
                                     class="emoji-icon">

                                300 HP Engine
                            </li>

                            <li>
                                <img src="../images/fuel_icon.png"
                                     alt="fuel"
                                     class="emoji-icon">

                                24 MPG City
                            </li>

                            <li>
                                <img src="../images/shield_icon.png"
                                     alt="warranty"
                                     class="emoji-icon">

                                AWD Included
                            </li>

                        </ul>

                        <div class="card-actions">

                            <a href="#"
                               class="btn btn-primary">

                               Add to Cart

                            </a>

                            <a href="#"
                               class="btn btn-outline">

                               <img src="../images/heart_icon.png"
                                    alt="wishlist"
                                    class="emoji-icon">

                            </a>

                            <a href="#"
                               class="btn btn-secondary">

                               View Details

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <section class="section bg-white">

        <div class="container">

            <h2 class="section-title">

                Why Choose <span>AutoDeal</span>

            </h2>

            <div class="cards-grid">

                <div class="card">

                    <div class="card-content">

                        <h3 class="card-title">

                            <img src="../images/trophy_icon.png"
                                 alt="best prices"
                                 class="emoji-icon">

                            Best Prices

                        </h3>

                        <p>
                            We offer competitive pricing on all vehicles.
                        </p>

                    </div>

                </div>

                <div class="card">

                    <div class="card-content">

                        <h3 class="card-title">

                            <img src="../images/shield_icon.png"
                                 alt="warranty"
                                 class="emoji-icon">

                            Warranty Included

                        </h3>

                        <p>
                            Every vehicle comes with warranty support.
                        </p>

                    </div>

                </div>

                <div class="card">

                    <div class="card-content">

                        <h3 class="card-title">

                            <img src="../images/rocket_icon.png"
                                 alt="delivery"
                                 class="emoji-icon">

                            Fast Delivery

                        </h3>

                        <p>
                            Get your vehicle delivered quickly and safely.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>

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

                    <li><a href="dashboard.php">Home</a></li>

                    <li><a href="../products.html">Products</a></li>

                    <li><a href="../about.html">About Us</a></li>

                    <li><a href="../contact.html">Contact</a></li>

                </ul>

            </div>

            <div class="footer-section">

                <h3>Customer Service</h3>

                <ul>

                    <li><a href="../reviews.html">Reviews</a></li>

                    <li><a href="../comparison.html">Compare Cars</a></li>

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