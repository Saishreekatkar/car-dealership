<?php

session_start();

include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM cars ORDER BY id DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Products - AutoDeal</title>

    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../utils.css">

    <style>

        .card-details{

            margin-top:12px;
            margin-bottom:18px;

        }

        .card-details p{

            color:#666;
            font-size:14px;
            margin-bottom:6px;

        }

        .card-actions{

            display:flex;
            gap:10px;
            align-items:center;
            flex-wrap:wrap;

        }

    </style>

</head>

<body>

<?php include 'components/navbar.php'; ?>

<section class="section">

    <div class="container">

        <h2 class="section-title">

            Available <span>Vehicles</span>

        </h2>

        <div class="cards-grid">

            <?php while($car = mysqli_fetch_assoc($result)): ?>

                <div class="card">

                    <img
                        class="card-image-img"

                        src="../uploads/<?php echo $car['image']; ?>"

                        alt="car"

                        style="
                            width:100%;
                            height:220px;
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

                        <div class="card-details">

                            <p>

                                <?php echo $car['year']; ?>

                                •

                                <?php echo $car['fuel_type']; ?>

                            </p>

                            <p>

                                <?php echo number_format($car['kilometers_driven']); ?>

                                KM Driven

                            </p>

                        </div>

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

                            <a href="car-details.php?id=<?php echo $car['id']; ?>"
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

        const currentButton = this;

        fetch(`add-to-cart.php?id=${carId}`)

        .then(response => response.text())

        .then(data => {

            // SUCCESS

            if(data.includes("success")){

                // UPDATE BADGE

                const badge =
                    document.getElementById("cart-badge");

                badge.innerText =
                    parseInt(badge.innerText) + 1;

                // BUTTON CHANGE

                currentButton.innerText =
                    "Added ✓";

                currentButton.disabled = true;

                currentButton.style.background =
                    "#28a745";

                // FLOATING ANIMATION

                const cartIcon =
                    document.querySelector('a[href="cart.php"] img');

                const circle =
                    document.createElement("div");

                circle.style.position = "fixed";
                circle.style.width = "20px";
                circle.style.height = "20px";
                circle.style.borderRadius = "50%";
                circle.style.background = "#ff4d4d";
                circle.style.zIndex = "9999";

                const rect =
                    currentButton.getBoundingClientRect();

                circle.style.left = rect.left + "px";
                circle.style.top = rect.top + "px";

                document.body.appendChild(circle);

                const cartRect =
                    cartIcon.getBoundingClientRect();

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

            }

            // DUPLICATE

            else if(data.includes("exists")){

                currentButton.innerText =
                    "Already Added";

                currentButton.style.background =
                    "#6c757d";

            }

            // LOGIN

            else if(data.includes("login")){

                alert("Please login first");

            }

            // ERROR

            else{

                alert("Something went wrong");

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

                if(data.includes("success")){

                    this.style.background = "#ff4d4d";

                    const badge =
                        document.getElementById("wishlist-badge");

                    if(badge){

                        badge.innerText =
                            parseInt(badge.innerText) + 1;

                    }

                }

            });

    });

});

</script>

</body>
</html>