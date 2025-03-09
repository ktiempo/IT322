<?php
include("../../dB/config.php");
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hot Wheels Gallery</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            text-align: center;
            padding: 20px;
        }
        .gallery img {
            width: 100%;
            border-radius: 10px;
            transition: transform 0.3s;
        }
        .gallery img:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>

    <h2><b>Welcome to the Hot Wheels Collection</b></h2>

    <div class="container">
        <div class="row gallery">
            <div class="col-md-4">
                <img src="../../assets/img/HW1.jpg" alt="Hot Wheels 1">
            </div>
            <div class="col-md-4">
                <img src="../../assets/img/HW2.jpg" alt="Hot Wheels 2">
            </div>
            <div class="col-md-4">
                <img src="../../assets/img/HW3.jpg" alt="Hot Wheels 3">
            </div>
            <div class="col-md-4">
                <img src="../../assets/img/HW4.jpg" alt="Hot Wheels 4">
            </div>
            <div class="col-md-4">
                <img src="../../assets/img/HW5.jpg" alt="Hot Wheels 5">
            </div>
            <div class="col-md-4">
                <img src="../../assets/img/HW6.jpg" alt="Hot Wheels 6">
            </div>
        </div>
    </div>

</body>
</html>

<?php
include("./includes/footer.php");
?>
