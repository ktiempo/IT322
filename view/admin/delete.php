<?php
include("../../dB/config.php"); // Include database configuration

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Prepare and execute the delete query
    $query = "DELETE FROM inventory WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Item deleted successfully!'); window.location.href='inventory.php';</script>";
    } else {
        echo "<script>alert('Error deleting item!'); window.location.href='inventory.php';</script>";
    }
    
    $stmt->close();
} else {
    echo "<script>alert('Invalid request!'); window.location.href='inventory.php';</script>";
}

$conn->close();
?>