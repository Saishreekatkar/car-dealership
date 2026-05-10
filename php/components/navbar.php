<?php

include 'db.php';

$cart_count = 0;

if(isset($_SESSION['user_id'])){

    $user_id = $_SESSION['user_id'];

    $cart_query = "SELECT COUNT(*) as total
                   FROM cart
                   WHERE user_id='$user_id'";

    $cart_result = mysqli_query($conn, $cart_query);

    $cart_data = mysqli_fetch_assoc($cart_result);

    $cart_count = $cart_data['total'];

}

?>

<header>

    <nav>

        <a href="dashboard.php" class="logo">

            Auto<span>Deal</span>

        </a>

        <ul class="nav-links">

            <li><a href="dashboard.php">Home</a></li>

            <li><a href="products.php">Products</a></li>

            <li><a href="sell-car.php">Sell Car</a></li>

            <li><a href="../comparison.html">Comparison</a></li>

            <li><a href="../reviews.html">Reviews</a></li>

            <li><a href="../about.html">About</a></li>

            <li><a href="../contact.html">Contact</a></li>

        </ul>

        <div class="nav-actions">

            <a href="wishlist.php"
               class="icon-btn">

                <img src="../images/heart_icon.png"
                     alt="wishlist"
                     class="emoji-icon">

                <span class="badge">
                    0
                </span>

            </a>

            <a href="cart.php"
               class="icon-btn">

                <img src="../images/cart_icon.png"
                     alt="cart"
                     class="emoji-icon">

                <span class="badge"
                      id="cart-badge">

                    <?php echo $cart_count; ?>

                </span>

            </a>

            <span class="welcome-text">

                Welcome,
                <?php echo $_SESSION['user_name']; ?>

            </span>

            <a href="logout.php"
               class="btn btn-outline">

               Logout

            </a>

        </div>

    </nav>

</header>