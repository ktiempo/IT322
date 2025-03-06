<?php
include("../../../dB/config.php");

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
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<title>Wheels Я Us</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../../../assets/img/car_logo2.png" rel="icon">
  <link href="../../assets/img/apple-touch-icon.png" rel="apple-touch-icon">    
    <script>
        // Auto-hide success message after 3 seconds
        setTimeout(() => {
            const message = document.getElementById('success-message');
            if (message) message.style.display = 'none';
        }, 3000);
    </script>
</head>

<body>
    <h1>Add New Hot Wheels Car</h1>

    <?php if ($success_message): ?>
        <p id="success-message" style="color: green;"><?php echo $success_message; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Car Name:</label><input type="text" name="car_name" required><br>
        <label>Series:</label><input type="text" name="series" required><br>
        <label>Year Release:</label><input type="number" name="year_release" required><br>
        <label>Price:</label><input type="text" name="price" required><br>
        <label>Stock Quantity:</label><input type="number" name="stock_quantity" required><br>
        <label>Description:</label><textarea name="description" required></textarea><br>

        <button type="submit">Add Item</button>
        <!-- Exit Button -->
        <button type="button" onclick="window.location.href='../../../view/admin/index.php';">Exit</button>
    </form>

</body>

</html>
