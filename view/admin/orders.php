<?php
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
include("../../dB/config.php");

// Fetch inventory items
$itemQuery = "SELECT id, car_name, stock_quantity, price FROM inventory";
$itemResult = $conn->query($itemQuery);

// Fetch orders
$orderQuery = "SELECT orders.*, inventory.car_name FROM orders JOIN inventory ON orders.item_id = inventory.id ORDER BY orders.created_at DESC";
$orderResult = $conn->query($orderQuery);

// Handle adding a new order
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_order'])) {
    $customer_name = $_POST['customer_name'];
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];

    // Get item price
    $stmt = $conn->prepare("SELECT price FROM inventory WHERE id = ?");
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $priceResult = $stmt->get_result();
    $itemPrice = $priceResult->fetch_assoc()['price'];

    $total_price = $itemPrice * $quantity;

    $stmt = $conn->prepare("INSERT INTO orders (customer_name, item_id, quantity, total_price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siii", $customer_name, $item_id, $quantity, $total_price);
    $stmt->execute();

    header("Location: orders.php");
    exit();
}

// Handle updating an order
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_order'])) {
    $order_id = $_POST['order_id'];
    $customer_name = $_POST['customer_name'];
    $quantity = $_POST['quantity'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE orders SET customer_name = ?, quantity = ?, status = ? WHERE order_id = ?");
    $stmt->bind_param("sisi", $customer_name, $quantity, $status, $order_id);
    $stmt->execute();

    header("Location: orders.php");
    exit();
}

// Handle deleting an order
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();

    header("Location: orders.php");
    exit();
}
?>

<main class="container mt-4">
    <div class="pagetitle text-center">
        <h1>Orders</h1>
    </div>

    <section class="order-management">
        <div class="card">
            <div class="card-body">
                <h1>Orders</h1>
                <form method="POST" class="mb-3">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <input type="text" name="customer_name" class="form-control" placeholder="Customer Name" required>
                        </div>
                        <div class="col-md-4">
                            <select name="item_id" class="form-select" required onchange="updateStock(this)">
                                <option value="">Select an Item</option>
                                <?php while ($row = $itemResult->fetch_assoc()): ?>
                                    <option value="<?= $row['id']; ?>" data-stock="<?= $row['stock_quantity']; ?>" data-price="<?= $row['price']; ?>">
                                        <?= $row['car_name']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Quantity" required min="1">
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="total_price" id="total_price" class="form-control" placeholder="Total Price" readonly>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" name="add_order" class="btn btn-primary">Add Order</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-primary">
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $orderResult->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['order_id']; ?></td>
                                <td><?= $row['customer_name']; ?></td>
                                <td><?= $row['car_name']; ?></td>
                                <td><?= $row['quantity']; ?></td>
                                <td>₱<?= $row['total_price']; ?></td>
                                <td><?= $row['status']; ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="openEditModal(<?= htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8'); ?>)">Edit</button>
                                    <a href="orders.php?delete_id=<?= $row['order_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this order?');">Delete</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Edit Order Modal -->
<div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOrderLabel">Edit Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <input type="hidden" name="order_id" id="edit_order_id">
                    
                    <div class="mb-3">
                        <label class="form-label">Customer Name</label>
                        <input type="text" name="customer_name" id="edit_customer_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" id="edit_quantity" class="form-control" required min="1">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="edit_status" class="form-select">
                            <option value="Pending">Pending</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>

                    <button type="submit" name="update_order" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function updateStock(select) {
    let selectedOption = select.options[select.selectedIndex];
    let price = selectedOption.getAttribute("data-price");
    document.getElementById("quantity").addEventListener("input", function() {
        document.getElementById("total_price").value = this.value * price;
    });
}

function openEditModal(order) {
    document.getElementById("edit_order_id").value = order.order_id;
    document.getElementById("edit_customer_name").value = order.customer_name;
    document.getElementById("edit_quantity").value = order.quantity;
    document.getElementById("edit_status").value = order.status;
    new bootstrap.Modal(document.getElementById("editOrderModal")).show();
}
</script>

<?php include("./includes/footer.php"); ?>
