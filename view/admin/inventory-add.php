<?php
include("../../dB/config.php");
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");

$success_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $car_name = $_POST['car_name'];
    $series = $_POST['series'];
    $year_release = $_POST['year_release'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO inventory (car_name, series, year_release, price, stock_quantity, description) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssidis", $car_name, $series, $year_release, $price, $stock_quantity, $description);

    if ($stmt->execute()) {
        $success_message = "Item added successfully!";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add New Hot Wheels Car</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
        }
        #sidebar {
            width: 250px;
            transition: all 0.3s;
        }
        #sidebar.collapsed {
            width: 0;
            overflow: hidden;
        }
        .content-wrapper {
            flex-grow: 1;
            padding: 20px;
            transition: margin-left 0.3s;
        }
        .content-wrapper.expanded {
            margin-left: 0;
        }
        .toggle-btn {
            position: fixed;
            left: 10px;
            top: 10px;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <button class="btn btn-primary toggle-btn" onclick="toggleSidebar()">☰</button>
    
    <div id="sidebar">
        <?php include("./includes/sidebar.php"); ?>
    </div>
    
    <main class="content-wrapper">
        <div class="card">
            <div class="card-header bg-primary text-white text-center">
                <h2>Add New Hot Wheels Car</h2>
            </div>
            <div class="card-body">
                <?php if ($success_message): ?>
                    <div class="alert alert-success" id="success-message">
                        <?php echo $success_message; ?>
                    </div>
                    <script>
                        setTimeout(() => document.getElementById('success-message').style.display = 'none', 3000);
                    </script>
                <?php endif; ?>

                <form method="POST" action="">
                <h2>Add New Hot Wheels Car</h2>
                    <div class="mb-3">
                        <label class="form-label">Car Name:</label>
                        <input type="text" name="car_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Series:</label>
                        <input type="text" name="series" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Year Release:</label>
                        <input type="number" name="year_release" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price:</label>
                        <input type="text" name="price" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stock Quantity:</label>
                        <input type="number" name="stock_quantity" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description:</label>
                        <textarea name="description" class="form-control" required></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Add Item</button>
                        <a href="../../../view/admin/index.php" class="btn btn-secondary">Exit</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        function toggleSidebar() {
            let sidebar = document.getElementById("sidebar");
            let content = document.querySelector(".content-wrapper");
            sidebar.classList.toggle("collapsed");
            content.classList.toggle("expanded");
        }
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
