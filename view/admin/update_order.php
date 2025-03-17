<?php
include("../../dB/config.php");

// Check if the form was submitted
if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $quantity = $_POST['quantity'];
    $total_price = $_POST['total_price'];
    $status = $_POST['status'];

    // Check if the status is "Completed", then we handle the inventory update
    if ($status == 'Completed') {
        // Fetch the current order details
        $orderQuery = "SELECT * FROM orders WHERE order_id = '$order_id'";
        $orderResult = mysqli_query($conn, $orderQuery);
        $order = mysqli_fetch_assoc($orderResult);

        $item_id = $order['item_id'];
        $order_quantity = $order['quantity'];

        // Update inventory by deducting the quantity from stock
        $inventoryQuery = "UPDATE inventory SET stock_quantity = stock_quantity - '$order_quantity' WHERE id = '$item_id'";
        if (!mysqli_query($conn, $inventoryQuery)) {
            echo "<script>alert('Failed to update inventory.'); window.history.back();</script>";
            exit;
        }

        // Update the order status and completion date
        $completionDate = date('Y-m-d H:i:s');
        $updateOrderQuery = "UPDATE orders SET customer_name = '$customer_name', quantity = '$quantity', total_price = '$total_price', status = 'Completed', completed_at = '$completionDate' WHERE order_id = '$order_id'";
    } else {
        // Update the order without affecting inventory (for other statuses like "Pending" or "Cancelled")
        $updateOrderQuery = "UPDATE orders SET customer_name = '$customer_name', quantity = '$quantity', total_price = '$total_price', status = '$status' WHERE order_id = '$order_id'";
    }

    // Execute the update query
    if (mysqli_query($conn, $updateOrderQuery)) {
        echo "<script>alert('Order updated successfully.'); window.location.href = 'orders.php';</script>";
    } else {
        echo "<script>alert('Failed to update order.'); window.history.back();</script>";
    }
}
?>
