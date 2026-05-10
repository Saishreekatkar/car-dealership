<?php

session_start();

include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT wishlist.id as wishlist_id,

               cars.*

        FROM wishlist

        INNER JOIN cars

        ON wishlist.car_id = cars.id

        WHERE wishlist.user_id='$user_id'";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Wishlist - AutoDeal</title>

    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../utils.css">

</head>

<body>

<?php include 'components/navbar.php'; ?>

<section class="section">

    <div class="container">

        <h2 class="section-title">

            My <span>Wishlist</span>

        </h2>

        <?php if(mysqli_num_rows($result) > 0): ?>

            <div class="cards-grid">

                <?php while($car = mysqli_fetch_assoc($result)): ?>

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

                            </ul>

                            <div class="card-actions">

                                <button
                                    class="btn btn-primary add-cart-btn"
                                    data-id="<?php echo $car['id']; ?>">

                                    Add to Cart

                                </button>

                                <a href="remove-wishlist.php?id=<?php echo $car['wishlist_id']; ?>"
                                   class="btn btn-secondary">

                                   Remove

                                </a>

                            </div>

                        </div>

                    </div>

                <?php endwhile; ?>

            </div>

        <?php else: ?>

            <div class="bg-white p-2 rounded-12 shadow text-center">

                <h3 class="mb-1">

                    Your wishlist is empty

                </h3>

                <p class="mb-2">

                    Save vehicles you like here.

                </p>

                <a href="products.php"
                   class="btn btn-primary">

                   Browse Vehicles

                </a>

            </div>

        <?php endif; ?>

        <div class="mt-3 text-center">

            <h3 class="mb-1 text-dark">

                Want to Compare These Vehicles?

            </h3>

            <p class="text-light mb-15">

                Add them to comparison to see side-by-side specifications

            </p>

            <a href="../comparison.html"
               class="btn btn-primary">

               Compare Now

            </a>

            <a href="products.php"
               class="btn btn-outline ml-1">

               Continue Shopping

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

</script>

</body>
</html>