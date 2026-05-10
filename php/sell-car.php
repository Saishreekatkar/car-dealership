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

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Sell Vehicle - AutoDeal</title>

    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../utils.css">

    <style>

        .sell-wrapper{

            max-width:1100px;
            margin:50px auto;
            padding:20px;

        }

        .sell-grid{

            display:grid;
            grid-template-columns:1fr 1fr;
            gap:30px;

        }

        .sell-card{

            background:white;
            padding:30px;
            border-radius:16px;
            box-shadow:0 4px 12px rgba(0,0,0,0.08);

        }

        .sell-title{

            font-size:32px;
            margin-bottom:10px;
            color:#111;

        }

        .sell-subtitle{

            color:#666;
            margin-bottom:30px;
            line-height:1.6;

        }

        .form-grid{

            display:grid;
            grid-template-columns:1fr 1fr;
            gap:20px;

        }

        .form-group{

            display:flex;
            flex-direction:column;

        }

        .form-group.full{

            grid-column:1 / 3;

        }

        .form-group label{

            margin-bottom:8px;
            font-weight:600;

        }

        .form-group input,
        .form-group textarea{

            padding:14px;
            border:1px solid #ddd;
            border-radius:10px;
            font-size:15px;

        }

        .upload-box{

            border:2px dashed #ccc;
            padding:30px;
            border-radius:12px;
            text-align:center;
            background:#fafafa;

        }

        .tips-list{

            margin-top:20px;

        }

        .tips-list li{

            margin-bottom:15px;
            color:#555;

        }

        @media(max-width:900px){

            .sell-grid{

                grid-template-columns:1fr;

            }

            .form-grid{

                grid-template-columns:1fr;

            }

            .form-group.full{

                grid-column:auto;

            }

        }

    </style>

</head>

<body>

<?php include 'components/navbar.php'; ?>

<div class="sell-wrapper">

    <div class="sell-grid">

        <div class="sell-card">

            <h1 class="sell-title">

                Sell Your Vehicle

            </h1>

            <p class="sell-subtitle">

                Upload your car details and reach thousands
                of buyers instantly through AutoDeal.

            </p>

            <form action="insert-car.php"
                  method="POST"
                  enctype="multipart/form-data">

                <div class="form-grid">

                    <div class="form-group">

                        <label>
                            Car Name
                        </label>

                        <input
                            type="text"
                            name="car_name"
                            placeholder="Ex: Hyundai Creta"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label>
                            Brand
                        </label>

                        <input
                            type="text"
                            name="brand"
                            placeholder="Ex: Hyundai"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label>
                            Model
                        </label>

                        <input
                            type="text"
                            name="model"
                            placeholder="Ex: SX"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label>
                            Year
                        </label>

                        <input
                            type="number"
                            name="year"
                            placeholder="2022"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label>
                            Fuel Type
                        </label>

                        <input
                            type="text"
                            name="fuel_type"
                            placeholder="Petrol / Diesel"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label>
                            Transmission
                        </label>

                        <input
                            type="text"
                            name="transmission"
                            placeholder="Manual / Automatic"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label>
                            Kilometers Driven
                        </label>

                        <input
                            type="number"
                            name="kilometers_driven"
                            placeholder="25000"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label>
                            Price
                        </label>

                        <input
                            type="number"
                            name="price"
                            placeholder="Enter selling price"
                            required
                        >

                    </div>

                    <div class="form-group full">

                        <label>
                            Vehicle Description
                        </label>

                        <textarea
                            name="description"
                            rows="6"
                            placeholder="Describe your vehicle condition, features, ownership, etc."
                        ></textarea>

                    </div>

                    <div class="form-group full">

                        <label>
                            Upload Vehicle Image
                        </label>

                        <div class="upload-box">

                            <input
                                type="file"
                                name="image"
                                required
                            >

                        </div>

                    </div>

                    <div class="form-group full">

                        <button
                            type="submit"
                            class="btn btn-primary btn-full">

                            Upload Vehicle

                        </button>

                    </div>

                </div>

            </form>

        </div>

        <div class="sell-card">

            <h2 class="sell-title">

                Selling Tips

            </h2>

            <p class="sell-subtitle">

                Improve your chances of selling faster with these tips.

            </p>

            <ul class="tips-list">

                <li>
                    📸 Upload clear and high-quality images.
                </li>

                <li>
                    🧼 Clean your car before taking photos.
                </li>

                <li>
                    📝 Add detailed and honest descriptions.
                </li>

                <li>
                    💰 Keep competitive pricing based on market value.
                </li>

                <li>
                    🚗 Mention service history and ownership details.
                </li>

            </ul>

            <img
                src="../images/luxury_sedan.png"
                alt="car"
                style="
                    width:100%;
                    border-radius:16px;
                    margin-top:25px;
                "
            >

        </div>

    </div>

</div>

</body>
</html>