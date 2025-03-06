<?php
include("../../../dB/config.php");

// Fetch all inventory items
$query = "SELECT * FROM inventory";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<head>
<title>Wheels Я Us</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../../../assets/img/car_logo2.png" rel="icon">
  <link href="../../assets/img/apple-touch-icon.png" rel="apple-touch-icon">    
</head>
<body>

<h1>All Stocks</h1>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Car Name</th>
            <th>Series</th>
            <th>Year Release</th>
            <th>Price</th>
            <th>Stock Quantity</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['car_name']); ?></td>
                <td><?php echo htmlspecialchars($row['series']); ?></td>
                <td><?php echo htmlspecialchars($row['year_release']); ?></td>
                <td><?php echo htmlspecialchars($row['price']); ?></td>
                <td><?php echo htmlspecialchars($row['stock_quantity']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td>
                    <a href="inventory-edit.php?id=<?php echo $row['id']; ?>">Edit</a> |
                    <a href="inventory-delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<a href="../../view/admin/inventory/inventory-add.php">Add New Item</a>
<button type="button" onclick="window.location.href='../../../view/admin/index.php';">Exit</button>


</body>
</html>

<?php $conn->close(); ?>
