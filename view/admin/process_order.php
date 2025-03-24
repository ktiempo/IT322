<?php
include("../../dB/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = trim($_POST['customer_name']);
    $car_id = intval($_POST['car_id']);
    $quantity = intval($_POST['quantity']);
    $total_price = floatval(str_replace('₱', '', $_POST['total_price']));

    if (empty($customer_name) || $car_id == 0 || $quantity <= 0 || $total_price <= 0) {
        echo "Invalid input.";
        exit;
    }

    // Check stock availability
    $stockCheckQuery = "SELECT stock_quantity FROM inventory WHERE id = ?";
    $stmt = $conn->prepare($stockCheckQuery);
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $car = $result->fetch_assoc();
    
    if (!$car || $car['stock_quantity'] < $quantity) {
        echo "Insufficient stock.";
        exit;
    }

    // Insert the order into the database
    $insertOrderQuery = "INSERT INTO orders (customer_name, item_id, quantity, total_price) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertOrderQuery);
    $stmt->bind_param("siid", $customer_name, $car_id, $quantity, $total_price);

    if ($stmt->execute()) {
        // Reduce stock quantity
        $updateStockQuery = "UPDATE inventory SET stock_quantity = stock_quantity - ? WHERE id = ?";
        $stmt = $conn->prepare($updateStockQuery);
        $stmt->bind_param("ii", $quantity, $car_id);
        $stmt->execute();

        echo "success";
    } else {
        echo "Failed to place order.";
    }
}
?>
