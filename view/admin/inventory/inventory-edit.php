<?php
include("../../../dB/config.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM inventory WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();

    if (!$item) {
        die("Item not found.");
    }
} else {
    die("Invalid item ID.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $car_name = $_POST['car_name'];
    $series = $_POST['series'];
    $year_release = $_POST['year_release'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];
    $description = $_POST['description'];

    $update_query = "UPDATE inventory SET car_name = ?, series = ?, year_release = ?, price = ?, stock_quantity = ?, description = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ssidisi", $car_name, $series, $year_release, $price, $stock_quantity, $description, $id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Item updated successfully!'); window.location.href = 'inventory-view.php';</script>";
    } else {
        echo "Error updating item: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Item</title>
</head>

<body>

<h1>Edit Hot Wheels Car</h1>
<form method="POST" action="">
    <label>Car Name:</label><input type="text" name="car_name" value="<?= htmlspecialchars($item['car_name']) ?>" required><br>
    <label>Series:</label><input type="text" name="series" value="<?= htmlspecialchars($item['series']) ?>" required><br>
    <label>Year Release:</label><input type="number" name="year_release" value="<?= htmlspecialchars($item['year_release']) ?>" required><br>
    <label>Price:</label><input type="text" name="price" value="<?= htmlspecialchars($item['price']) ?>" required><br>
    <label>Stock Quantity:</label><input type="number" name="stock_quantity" value="<?= htmlspecialchars($item['stock_quantity']) ?>" required><br>
    <label>Description:</label><textarea name="description" required><?= htmlspecialchars($item['description']) ?></textarea><br>
    <button type="submit">Update Item</button>
    <button type="button" onclick="window.location.href='inventory-view.php';">Cancel</button>
</form>

</body>
</html>

<?php $stmt->close(); $conn->close(); ?>
