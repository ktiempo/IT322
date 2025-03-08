<!-- update_stock.php -->
<?php include 'connect.php'; ?>
<?php
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $new_stock = $_POST['stock'];
    $sql = "UPDATE inventory SET stock='$new_stock' WHERE id='$id'";
    if ($conn->query($sql)) {
        echo "<script>alert('Stock updated!'); window.location='view_items.php';</script>";
    }
}
$id = $_GET['id'];
$sql = "SELECT * FROM inventory WHERE id='$id'";
$result = $conn->query($sql);
$item = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Stock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Update Stock for <?php echo $item['name']; ?></h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
            <div class="mb-3">
                <label class="form-label">New Stock Quantity</label>
                <input type="number" name="stock" class="form-control" value="<?php echo $item['stock']; ?>" required>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update Stock</button>
            <a href="view_items.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>