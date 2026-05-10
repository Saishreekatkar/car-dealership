<?php

session_start();

include 'db.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Reviews - AutoDeal</title>

    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../utils.css">

</head>

<body>

<?php include 'components/navbar.php'; ?>

<section class="section">

    <div class="container">

        <h2 class="section-title">

            Customer <span>Reviews</span>

        </h2>

        <!-- REVIEW 1 -->

        <div class="review-card">

            <div class="review-header">

                <div>

                    <div class="reviewer-name">

                        John Smith

                    </div>

                    <div class="review-date">

                        March 15, 2024

                    </div>

                </div>

                <div class="review-rating">

                    ⭐⭐⭐⭐⭐

                </div>

            </div>

            <h3 class="mb-05 text-dark">

                2024 Luxury Sedan

            </h3>

            <p>

                Absolutely love my new sedan! The buying process
                was smooth, and the car exceeded all my expectations.
                Highly recommend AutoDeal for their excellent service
                and quality vehicles.

            </p>

        </div>

        <!-- REVIEW 2 -->

        <div class="review-card">

            <div class="review-header">

                <div>

                    <div class="reviewer-name">

                        Sarah Johnson

                    </div>

                    <div class="review-date">

                        March 10, 2024

                    </div>

                </div>

                <div class="review-rating">

                    ⭐⭐⭐⭐⭐

                </div>

            </div>

            <h3 class="mb-05 text-dark">

                2024 Sport SUV

            </h3>

            <p>

                Best car buying experience I've ever had!
                The team was knowledgeable and helped me
                find the perfect SUV for my family.

            </p>

        </div>

        <!-- REVIEW 3 -->

        <div class="review-card">

            <div class="review-header">

                <div>

                    <div class="reviewer-name">

                        Michael Chen

                    </div>

                    <div class="review-date">

                        March 5, 2024

                    </div>

                </div>

                <div class="review-rating">

                    ⭐⭐⭐⭐

                </div>

            </div>

            <h3 class="mb-05 text-dark">

                2024 Electric Car

            </h3>

            <p>

                Great electric vehicle with impressive range.
                Charging is fast and the eco-friendly aspect
                was important to me.

            </p>

        </div>

        <!-- REVIEW 4 -->

        <div class="review-card">

            <div class="review-header">

                <div>

                    <div class="reviewer-name">

                        Emily Davis

                    </div>

                    <div class="review-date">

                        February 28, 2024

                    </div>

                </div>

                <div class="review-rating">

                    ⭐⭐⭐⭐⭐

                </div>

            </div>

            <h3 class="mb-05 text-dark">

                2024 Family Van

            </h3>

            <p>

                Perfect for our large family!
                The van has plenty of space and
                the customer service was excellent.

            </p>

        </div>

        <!-- REVIEW 5 -->

        <div class="review-card">

            <div class="review-header">

                <div>

                    <div class="reviewer-name">

                        David Wilson

                    </div>

                    <div class="review-date">

                        February 20, 2024

                    </div>

                </div>

                <div class="review-rating">

                    ⭐⭐⭐⭐⭐

                </div>

            </div>

            <h3 class="mb-05 text-dark">

                2024 Sports Car

            </h3>

            <p>

                Dream car achieved! The performance
                is incredible and the financing process
                was very easy.

            </p>

        </div>

        <!-- REVIEW 6 -->

        <div class="review-card">

            <div class="review-header">

                <div>

                    <div class="reviewer-name">

                        Lisa Anderson

                    </div>

                    <div class="review-date">

                        February 15, 2024

                    </div>

                </div>

                <div class="review-rating">

                    ⭐⭐⭐⭐

                </div>

            </div>

            <h3 class="mb-05 text-dark">

                2024 Compact SUV

            </h3>

            <p>

                Love my compact SUV!
                Great fuel economy and perfect
                size for city driving.

            </p>

        </div>

        <!-- REVIEW 7 -->

        <div class="review-card">

            <div class="review-header">

                <div>

                    <div class="reviewer-name">

                        Robert Taylor

                    </div>

                    <div class="review-date">

                        February 8, 2024

                    </div>

                </div>

                <div class="review-rating">

                    ⭐⭐⭐⭐⭐

                </div>

            </div>

            <h3 class="mb-05 text-dark">

                2023 Premium Sedan

            </h3>

            <p>

                Excellent value for money!
                The comfort package makes
                long drives a pleasure.

            </p>

        </div>

        <!-- REVIEW 8 -->

        <div class="review-card">

            <div class="review-header">

                <div>

                    <div class="reviewer-name">

                        Jennifer Martinez

                    </div>

                    <div class="review-date">

                        February 1, 2024

                    </div>

                </div>

                <div class="review-rating">

                    ⭐⭐⭐⭐⭐

                </div>

            </div>

            <h3 class="mb-05 text-dark">

                2024 Luxury SUV

            </h3>

            <p>

                Outstanding vehicle and service!
                The luxury package is top-notch
                and the delivery was prompt.

            </p>

        </div>

        <div class="text-center mt-3">

            <h3 class="mb-1 text-dark">

                Share Your Experience

            </h3>

            <p class="text-light mb-15">

                Have you purchased a vehicle from us?
                We'd love to hear about your experience!

            </p>

            <a href="contact.php"
               class="btn btn-primary">

               Write A Review

            </a>

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