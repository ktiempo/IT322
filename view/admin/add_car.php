<?php
include("../../dB/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $car_name = mysqli_real_escape_string($conn, $_POST['car_name']);
    $series = mysqli_real_escape_string($conn, $_POST['series']);
    $year_release = mysqli_real_escape_string($conn, $_POST['year_release']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $stock_quantity = mysqli_real_escape_string($conn, $_POST['stock_quantity']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $query = "INSERT INTO inventory (car_name, series, year_release, price, stock_quantity, description) 
              VALUES ('$car_name', '$series', '$year_release', '$price', '$stock_quantity', '$description')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Car added successfully!'); window.location.href='inventory.php';</script>";
    } else {
        echo "<script>alert('Error adding car: " . mysqli_error($conn) . "'); window.location.href='inventory.php';</script>";
    }
}
?>
