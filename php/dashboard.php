<?php

session_start();

include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM cars ORDER BY id DESC LIMIT 6";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>AutoDeal - Premium Car Dealership</title>

    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../utils.css">

</head>

<body>

<?php include 'components/navbar.php'; ?>

<section class="hero">

    <h1>
        Find Your Dream Car Today
    </h1>

    <p>
        Discover premium vehicles at unbeatable prices
    </p>

    <div class="hero-buttons">

        <a href="products.php"
           class="btn btn-primary">

           Browse Cars

        </a>

        <a href="sell-car.php"
           class="btn btn-secondary">

           Sell Your Vehicle

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

            Latest <span>Vehicles</span>

        </h2>

        <div class="cards-grid">

            <?php while($car = mysqli_fetch_assoc($result)): ?>

                <div class="card">

                    <img
                        class="card-image-img"

                        src="../uploads/<?php echo $car['image']; ?>"

                        alt="Vehicle"

                        style="
                            width:100%;
                            height:200px;
                            object-fit:cover;
                            display:block;
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

                                <img src="../images/engine_icon.png"
                                     alt="brand"
                                     class="emoji-icon">

                                <?php echo $car['brand']; ?>

                            </li>

                            <li>

                                <img src="../images/fuel_icon.png"
                                     alt="fuel"
                                     class="emoji-icon">

                                <?php echo $car['fuel_type']; ?>

                            </li>

                            <li>

                                <img src="../images/shield_icon.png"
                                     alt="year"
                                     class="emoji-icon">

                                <?php echo $car['year']; ?>

                            </li>

                            <li>

                                <img src="../images/target_icon.png"
                                     alt="km"
                                     class="emoji-icon">

                                <?php echo $car['kilometers_driven']; ?>

                                KM Driven

                            </li>

                        </ul>

                        <div class="card-actions">

                            <button
                                class="btn btn-primary add-cart-btn"
                                data-id="<?php echo $car['id']; ?>">

                                Add to Cart

                            </button>

                            <button
                                class="btn btn-outline add-wishlist-btn"
                                data-id="<?php echo $car['id']; ?>">

                                <img src="../images/heart_icon.png"
                                     alt="wishlist"
                                     class="emoji-icon">

                            </button>

                            <a href="#"
                               class="btn btn-secondary">

                               View Details

                            </a>

                        </div>

                    </div>

                </div>

            <?php endwhile; ?>

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

                <li><a href="products.php">Products</a></li>

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

<script>

document.querySelectorAll(".add-cart-btn").forEach(button => {

    button.addEventListener("click", function(){

        const carId = this.dataset.id;

        const cartIcon =
            document.querySelector('a[href="cart.php"] img');

        const circle = document.createElement("div");

        circle.style.position = "fixed";
        circle.style.width = "20px";
        circle.style.height = "20px";
        circle.style.borderRadius = "50%";
        circle.style.background = "#ff4d4d";
        circle.style.zIndex = "9999";

        const rect = this.getBoundingClientRect();

        circle.style.left = rect.left + "px";
        circle.style.top = rect.top + "px";

        document.body.appendChild(circle);

        const cartRect = cartIcon.getBoundingClientRect();

        circle.animate([

            {
                transform: "translate(0,0) scale(1)",
                opacity: 1
            },

            {
                transform: `translate(
                    ${cartRect.left - rect.left}px,
                    ${cartRect.top - rect.top}px
                ) scale(0.2)`,

                opacity: 0.2
            }

        ], {

            duration: 800,
            easing: "ease-in-out"

        });

        setTimeout(() => {

            circle.remove();

        }, 800);

        fetch(`add-to-cart.php?id=${carId}`)
            .then(response => response.text())
            .then(data => {

                const badge =
                    document.getElementById("cart-badge");

                if(badge){

                    badge.innerText =
                        parseInt(badge.innerText) + 1;

                }

            });

    });

});

document.querySelectorAll(".add-wishlist-btn").forEach(button => {

    button.addEventListener("click", function(){

        const carId = this.dataset.id;

        fetch(`add-to-wishlist.php?id=${carId}`)
            .then(response => response.text())
            .then(data => {

                this.style.background = "#ff4d4d";

const badge =
    document.getElementById("wishlist-badge");

badge.innerText =
    parseInt(badge.innerText) + 1;
            });

    });

});

</script>

</body>
</html>