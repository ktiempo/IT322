<?php
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
include("../../dB/config.php");
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
            font-family: 'Poppins', sans-serif;
        }
        .gallery-container {
            padding: 30px;
            text-align: center;
        }
        .gallery-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .gallery img {
            width: 100%;
            border-radius: 10px;
            transition: transform 0.3s;
        }
        .gallery img:hover {
            transform: scale(1.1);
        }
        .card {
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
    </style>
</head>
<body>

    <main id="main" class="main flex-grow-1">
        <div class="pagetitle text-center">
            <h1 class="gallery-title">Welcome to the Hot Wheels Collection</h1>
        </div>

        <section class="gallery-container">
            <div class="container">
                <div class="row g-4 gallery">
                    <?php 
                    $images = ["HW1.jpg", "HW2.jpg", "HW3.jpg", "HW4.jpg", "HW5.jpg", "HW6.jpg"];
                    foreach ($images as $image): ?>
                        <div class="col-md-4">
                            <div class="card">
                                <img src="../../assets/img/<?php echo $image; ?>" alt="Hot Wheels">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>

</body>
</html>

<?php $conn->close(); ?>
<?php include("./includes/footer.php"); ?>
