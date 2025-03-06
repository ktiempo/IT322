<?php
include("../../../dB/config.php");

// Total Inventory Stock
$totalStockQuery = "SELECT SUM(stock_quantity) AS total_stock FROM inventory";
$totalStockResult = $conn->query($totalStockQuery);
$totalStock = $totalStockResult->fetch_assoc()['total_stock'];

// Most Recent Update (Latest Action)
$recentActivityQuery = "SELECT car_name, stock_quantity, created_at FROM inventory ORDER BY created_at DESC LIMIT 1";
$recentActivityResult = $conn->query($recentActivityQuery);
$recentActivity = $recentActivityResult->fetch_assoc();

// Low Stock Alert (Items with stock <= 5)
$lowStockQuery = "SELECT car_name, stock_quantity FROM inventory WHERE stock_quantity <= 5";
$lowStockResult = $conn->query($lowStockQuery);

// Inventory Summary by Series
$inventorySummaryQuery = "SELECT series, SUM(stock_quantity) AS total FROM inventory GROUP BY series";
$inventorySummaryResult = $conn->query($inventorySummaryQuery);
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
</head>

<body>
    <h1>Dashboard</h1>

    <!-- Total Inventory Stock -->
    <h2>Total Inventory Stock: <?php echo $totalStock; ?> items available</h2>

    <!-- Most Recent Activity -->
    <h3>Latest Update</h3>
    <?php if ($recentActivity): ?>
        <p><?php echo $recentActivity['car_name'] . " - " . $recentActivity['stock_quantity'] . " items  "; ?></p>
    <?php else: ?>
        <p>No recent activity available.</p>
    <?php endif; ?>

    <!-- Low Stock Alert -->
    <h3>Low Stock Alert (<= 5 items)</h3>
    <ul>
        <?php if ($lowStockResult->num_rows > 0): ?>
            <?php while ($row = $lowStockResult->fetch_assoc()): ?>
                <li><?php echo $row['car_name'] . " - " . $row['stock_quantity'] . " left"; ?></li>
            <?php endwhile; ?>
        <?php else: ?>
            <li>No items with low stock.</li>
        <?php endif; ?>
    </ul>

    <!-- Inventory Summary by Series -->
    <h3>Inventory Summary by Series</h3>
    <ul>
        <?php while ($row = $inventorySummaryResult->fetch_assoc()): ?>
            <li><?php echo $row['series'] . " - " . $row['total'] . " items"; ?></li>
        <?php endwhile; ?>
    </ul>

    <a href="../inventory/inventory-add.php">Add New Item</a>
    <button type="button" onclick="window.location.href='../../../view/admin/index.php';">Exit</button>

</body>

</html>

<?php $conn->close(); ?>
