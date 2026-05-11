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

        .search-box{

            margin-bottom:30px;

        }

        .search-box input{

            width:100%;
            padding:15px;
            border:1px solid #ccc;
            border-radius:10px;
            font-size:16px;
            outline:none;

        }

        .search-box input:focus{

            border-color:#ff4d4d;

        }

        .card-details{

            margin-top:15px;
            margin-bottom:20px;

        }

        .card-details p{

            color:#666;
            margin-bottom:8px;
            font-size:14px;

        }

        .card-actions{

            display:flex;
            gap:10px;
            align-items:center;
            margin-top:20px;
            flex-wrap:wrap;

        }

        .wishlist-btn{

            width:45px;
            height:45px;

            display:flex;
            align-items:center;
            justify-content:center;

            font-size:18px;

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

        <!-- LIVE SEARCH -->

        <div class="search-box">

            <input
                type="text"
                id="search-input"
                placeholder="Search by car name, brand or model..."
            >

        </div>

        <!-- CAR LIST -->

        <div class="cards-grid"
             id="cars-container">

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

                                <strong>
                                    <?php echo $car['year']; ?>
                                </strong>

                                •

                                <?php echo $car['fuel_type']; ?>

                            </p>

                            <p>

                                <?php echo number_format($car['kilometers_driven']); ?>

                                KM Driven

                            </p>

                        </div>

                        <div class="card-actions">

                            <a href="car-details.php?id=<?php echo $car['id']; ?>"
                               class="btn btn-primary">

                               View Details

                            </a>

                            <button
                                class="btn btn-outline add-cart-btn"
                                data-id="<?php echo $car['id']; ?>">

                                Add to Cart

                            </button>

                            <button
                                class="btn btn-outline add-wishlist-btn wishlist-btn"
                                data-id="<?php echo $car['id']; ?>">

                                ❤️

                            </button>

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

                <li><a href="comparison.php">Comparison</a></li>

                <li><a href="wishlist.php">Wishlist</a></li>

            </ul>

        </div>

        <div class="footer-section">

            <h3>Customer Service</h3>

            <ul>

                <li><a href="reviews.php">Reviews</a></li>

                <li><a href="contact.php">Contact</a></li>

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

// LIVE SEARCH AJAX

document.getElementById("search-input")
.addEventListener("keyup", function(){

    const searchValue = this.value;

    fetch(`search-cars.php?search=${searchValue}`)

    .then(response => response.text())

    .then(data => {

        document.getElementById("cars-container")
        .innerHTML = data;

    });

});



// WISHLIST AJAX

document.addEventListener("click", function(e){

    if(e.target.closest(".add-wishlist-btn")){

        const button =
            e.target.closest(".add-wishlist-btn");

        const carId =
            button.dataset.id;

        fetch(`add-to-wishlist.php?id=${carId}`)

        .then(response => response.text())

        .then(data => {

            if(data.includes("success")){

                button.style.background =
                    "#ff4d4d";

                button.style.color =
                    "white";

                const badge =
                    document.getElementById("wishlist-badge");

                badge.innerText =
                    parseInt(badge.innerText) + 1;

            }

            else if(data.includes("exists")){

                button.innerHTML = "✓";

                button.style.background =
                    "#6c757d";

                button.style.color =
                    "white";

            }

        });

    }

});



// CART AJAX

document.addEventListener("click", function(e){

    if(e.target.closest(".add-cart-btn")){

        const currentButton =
            e.target.closest(".add-cart-btn");

        const carId =
            currentButton.dataset.id;

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

                circle.style.left =
                    rect.left + "px";

                circle.style.top =
                    rect.top + "px";

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

    }

});

</script>

</body>
</html>