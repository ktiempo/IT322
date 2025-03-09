<?php
include("../../dB/config.php");
include("./includes/header.php");
include("./includes/topbar.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM inventory WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();

    if (!$item) {
        die("<div class='alert alert-danger'>Item not found.</div>");
    }
} else {
    die("<div class='alert alert-danger'>Invalid item ID.</div>");
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
        echo "<div class='alert alert-danger'>Error updating item: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .content-wrapper {
        margin-left: 250px; /* Adjust according to the actual sidebar width */
        padding: 20px;
        max-width: calc(100% - 250px); /* Ensures content fits within available space */
        overflow-x: auto;
    }
    </style>
</head>
<body>

<main class="content-wrapper">
    <div class="card">
        <div class="card-header bg-primary text-white text-center">
            <h2>Edit Hot Wheels Car</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label">Car Name:</label>
                    <input type="text" name="car_name" class="form-control" value="<?= htmlspecialchars($item['car_name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Series:</label>
                    <input type="text" name="series" class="form-control" value="<?= htmlspecialchars($item['series']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Year Release:</label>
                    <input type="number" name="year_release" class="form-control" value="<?= htmlspecialchars($item['year_release']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Price:</label>
                    <input type="text" name="price" class="form-control" value="<?= htmlspecialchars($item['price']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Stock Quantity:</label>
                    <input type="number" name="stock_quantity" class="form-control" value="<?= htmlspecialchars($item['stock_quantity']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description:</label>
                    <textarea name="description" class="form-control" required><?= htmlspecialchars($item['description']) ?></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success">Update Item</button>
                    <a href="inventory-view.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $stmt->close(); $conn->close(); ?>
