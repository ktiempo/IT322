<?php
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
include("../../dB/config.php");

// Fetch cars from inventory
$queryCars = "SELECT id, car_name FROM inventory";
$resultCars = mysqli_query($conn, $queryCars);

// Fetch all pending orders
$queryPending = "
SELECT o.*, i.car_name
FROM orders o
JOIN inventory i ON o.item_id = i.id
WHERE o.status != 'Completed'
";
$resultPending = mysqli_query($conn, $queryPending);

// Fetch all completed orders
$queryCompleted = "
SELECT o.*, i.car_name
FROM orders o
JOIN inventory i ON o.item_id = i.id
WHERE o.status = 'Completed'
";
$resultCompleted = mysqli_query($conn, $queryCompleted);

// Handle order completion
if (isset($_POST['complete_order'])) {
    $order_id = $_POST['order_id'];

    // First, get the order details
    $orderQuery = "SELECT * FROM orders WHERE order_id = '$order_id'";
    $orderResult = mysqli_query($conn, $orderQuery);
    $order = mysqli_fetch_assoc($orderResult);

    $item_id = $order['item_id'];
    $quantity = $order['quantity'];

    // Now, update the inventory by deducting the quantity from stock
    $inventoryQuery = "UPDATE inventory SET stock_quantity = stock_quantity - '$quantity' WHERE id = '$item_id'";
    if (mysqli_query($conn, $inventoryQuery)) {
        // Update the order status to "Completed" and set the completion date
        $completionDate = date('Y-m-d H:i:s');
        $updateOrderQuery = "UPDATE orders SET status = 'Completed', completed_at = '$completionDate' WHERE order_id = '$order_id'";
        if (mysqli_query($conn, $updateOrderQuery)) {
            echo "<script>alert('Order marked as completed and inventory updated.'); window.location.href = 'orders.php';</script>";
        } else {
            echo "<script>alert('Failed to update order status.');</script>";
        }
    } else {
        echo "<script>alert('Failed to update inventory.');</script>";
    }
}

// Handle order deletion
if (isset($_POST['delete_order'])) {
    $order_id = $_POST['order_id'];

    // Delete the order
    $deleteOrderQuery = "DELETE FROM orders WHERE order_id = '$order_id'";
    if (mysqli_query($conn, $deleteOrderQuery)) {
        echo "<script>alert('Order deleted successfully.'); window.location.href = 'orders.php';</script>";
    } else {
        echo "<script>alert('Failed to delete order.');</script>";
    }
}
?>

<main id="main" class="main flex-grow-1 p-5">
    <div class="pagetitle text-center mb-4">
        <h1 class="fw-bold text-primary">Order List</h1>
    </div>

    <!-- Add Order Button (Trigger Modal) -->
    <div class="d-flex justify-content-end mb-4">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addOrderModal">Add Order</button>
    </div>

    <!-- Pending Orders -->
    <section class="orders">
        <h2>Pending Orders</h2>
        <div class="card shadow-sm p-4 border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center rounded overflow-hidden">
                        <thead class="table-primary text-white">
                            <tr>
                                <th>Customer Name</th>
                                <th>Car</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($resultPending)) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['customer_name']); ?></td>
                                    <td><?= htmlspecialchars($row['car_name']); ?></td>
                                    <td><?= htmlspecialchars($row['quantity']); ?></td>
                                    <td>₱<?= number_format($row['total_price'], 2); ?></td>
                                    <td><?= htmlspecialchars($row['status']); ?></td>
                                    <td class="text-nowrap">
                                        <button class="btn btn-warning btn-sm me-1 shadow" data-bs-toggle="modal" data-bs-target="#editOrderModal" onclick="populateEditModal(<?= $row['order_id']; ?>, '<?= htmlspecialchars(addslashes($row['customer_name'])); ?>', '<?= htmlspecialchars(addslashes($row['car_name'])); ?>', '<?= $row['quantity']; ?>', '<?= $row['total_price']; ?>', '<?= $row['status']; ?>')">Edit</button>
                                        <!-- Delete Button -->
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="order_id" value="<?= $row['order_id']; ?>">
                                            <button type="submit" name="delete_order" class="btn btn-danger btn-sm shadow">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Completed Orders (Green Table) -->
    <section class="orders mt-5">
        <h2>Completed Orders</h2>
        <div class="card shadow-sm p-4 border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center rounded overflow-hidden" style="background-color: #d4edda;">
                        <thead class="table-success text-white">
                            <tr>
                                <th>Customer Name</th>
                                <th>Car</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($resultCompleted)) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['customer_name']); ?></td>
                                    <td><?= htmlspecialchars($row['car_name']); ?></td>
                                    <td><?= htmlspecialchars($row['quantity']); ?></td>
                                    <td>₱<?= number_format($row['total_price'], 2); ?></td>
                                    <td><?= htmlspecialchars($row['status']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Add Order Modal -->
<div class="modal fade" id="addOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addOrderForm" method="POST" action="add_order.php">
                    <div class="mb-3">
                        <label class="form-label">Customer Name</label>
                        <input type="text" class="form-control" name="customer_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Car</label>
                        <select class="form-select" name="car_id" required>
                            <option value="" disabled selected>Select Car</option>
                            <?php while ($car = mysqli_fetch_assoc($resultCars)) : ?>
                                <option value="<?= $car['id']; ?>"><?= htmlspecialchars($car['car_name']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="quantity" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Total Price</label>
                        <input type="number" class="form-control" name="total_price" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Order</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Order Modal -->
<div class="modal fade" id="editOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editOrderForm" method="POST" action="../../view/admin/update_order.php">
                    <input type="hidden" name="order_id" id="editOrderId">
                    <div class="mb-3">
                        <label class="form-label">Customer Name</label>
                        <input type="text" class="form-control" name="customer_name" id="edit_customer_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Car</label>
                        <select class="form-select" name="car_id" id="edit_car_id" required>
                            <option value="" disabled selected>Select Car</option>
                            <?php
                            mysqli_data_seek($resultCars, 0); // Reset the result set pointer
                            while ($car = mysqli_fetch_assoc($resultCars)) : ?>
                                <option value="<?= $car['id']; ?>"><?= htmlspecialchars($car['car_name']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="quantity" id="edit_quantity" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Total Price</label>
                        <input type="number" class="form-control" name="total_price" id="edit_total_price" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" id="edit_status" required>
                            <option value="Pending">Pending</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success mt-2">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function populateEditModal(id, customer_name, car_name, quantity, total_price, status) {
    document.getElementById('editOrderId').value = id;
    document.getElementById('edit_customer_name').value = customer_name;
    document.getElementById('edit_quantity').value = quantity;
    document.getElementById('edit_total_price').value = total_price;
    document.getElementById('edit_status').value = status;

    // Set the car_id dropdown value
    let carDropdown = document.getElementById('edit_car_id');
    for (let i = 0; i < carDropdown.options.length; i++) {
        if (carDropdown.options[i].text === car_name) {
            carDropdown.selectedIndex = i;
            break;
        }
    }
}
</script>

<?php include("./includes/footer.php"); ?>
