<?php
include("../../dB/config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $stock_quantity = $_POST['stock_quantity'];

    $sql = "UPDATE inventory SET stock_quantity = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $stock_quantity, $id);

    if ($stmt->execute()) {
        echo "Stock updated successfully!";
    } else {
        echo "Error updating stock.";
    }

    $stmt->close();
    $conn->close();
}
?>
