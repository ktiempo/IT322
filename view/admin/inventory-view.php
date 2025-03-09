<?php
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
include("../../dB/config.php");

// Fetch all inventory items
$query = "SELECT * FROM inventory";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Wheels Я Us</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="../../../assets/img/car_logo2.png" rel="icon">
    <link href="../../assets/img/apple-touch-icon.png" rel="apple-touch-icon">    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<main class="container mt-4">
    <div class="pagetitle text-center">
        <h1>Inventory</h1>
    </div>

    <section class="Inventory">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-primary">
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
                                    <td><?= htmlspecialchars($row['id']); ?></td>
                                    <td><?= htmlspecialchars($row['car_name']); ?></td>
                                    <td><?= htmlspecialchars($row['series']); ?></td>
                                    <td><?= htmlspecialchars($row['year_release']); ?></td>
                                    <td>₱<?= htmlspecialchars($row['price']); ?></td>
                                    <td><?= htmlspecialchars($row['stock_quantity']); ?></td>
                                    <td><?= htmlspecialchars($row['description']); ?></td>
                                    <td>
                                        <a href="../../view/admin/inventory-edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Update</a>
                                        <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $row['id']; ?>)">Delete</button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div class="text-center mt-3">
        <a href="../../view/admin/inventory-add.php" class="btn btn-primary">Add New Item</a>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='../../../view/admin/index.php';">Exit</button>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function confirmDelete(id) {
    if (confirm("Are you sure you want to delete this item?")) {
        window.location.href = "../../view/admin/inventory-delete.php?id=" + id;
    }
}
</script>

<?php $conn->close(); ?>
<?php
include("./includes/footer.php");
?>
