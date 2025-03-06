<?php
include("../../../dB/config.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $delete_query = "DELETE FROM inventory WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Item deleted successfully!'); window.location.href = 'inventory-view.php';</script>";
    } else {
        echo "Error deleting item: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Invalid item ID.";
}

$conn->close();
?>
