<?php

session_start();

include 'db.php';

$search = $_GET['search'] ?? '';

$sql = "SELECT *
        FROM cars
        WHERE car_name LIKE '%$search%'
        OR brand LIKE '%$search%'
        OR model LIKE '%$search%'
        ORDER BY id DESC";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){

    while($car = mysqli_fetch_assoc($result)){

?>

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

                Year:
                <?php echo $car['year']; ?>

            </li>

            <li>

                Fuel:
                <?php echo $car['fuel_type']; ?>

            </li>

        </ul>

        <div class="card-actions">

            <a href="car-details.php?id=<?php echo $car['id']; ?>"
               class="btn btn-secondary">

               View Details

            </a>

        </div>

    </div>

</div>

<?php

    }

}else{

    echo "<h3>No Cars Found</h3>";

}

?>