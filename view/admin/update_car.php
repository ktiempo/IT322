<?php
include("../../dB/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $car_name = mysqli_real_escape_string($conn, $_POST['car_name']);
    $series = mysqli_real_escape_string($conn, $_POST['series']);
    $year_release = $_POST['year_release'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $query = "UPDATE inventory SET car_name='$car_name', series='$series', year_release='$year_release', price='$price', stock_quantity='$stock_quantity', description='$description' WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Inventory updated successfully!'); window.location.href='inventory.php';</script>";
    } else {
        echo "<script>alert('Error updating inventory: " . mysqli_error($conn) . "'); window.history.back();</script>";
    }
}
?>