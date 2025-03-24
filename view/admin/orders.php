<?php
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
include("../../dB/config.php");

// Fetch cars from inventory
$inventoryQuery = "SELECT id, car_name, series, year_release, stock_quantity, price FROM inventory WHERE stock_quantity > 0";
$inventoryResult = $conn->query($inventoryQuery);

// Fetch pending orders
$orderQuery = "
    SELECT o.order_id, o.customer_name, i.car_name, i.series, i.year_release, 
           o.quantity, o.total_price, o.status, o.created_at 
    FROM orders o 
    JOIN inventory i ON o.item_id = i.id 
    WHERE o.status = 'Pending'
    ORDER BY o.created_at DESC
";
$orderResult = $conn->query($orderQuery);
?>

<main id="main" class="main flex-grow-1">
    <section class="container mt-4">
        <!-- Add Order Form -->
        <div class="card p-4 shadow mb-4">
            <h3 class="mb-3 text-center">New Order</h3>
            <form id="orderForm">
                <div class="d-flex align-items-center flex-wrap gap-3">
                    <!-- Customer Name -->
                    <label for="customer_name" class="form-label mb-0">Customer Name:</label>
                    <input type="text" class="form-control w-auto" id="customer_name" name="customer_name">
                    <div id="customerError" class="text-danger mt-1" style="display: none;">Required!</div>

                    <!-- Select Car -->
                    <label for="car" class="form-label mb-0">Select Car:</label>
                    <select class="form-select w-auto" id="car" name="car_id" required onchange="updateStockAndPrice()">
                        <option value="" data-stock="0" data-price="0">Choose a car</option>
                        <?php while ($row = $inventoryResult->fetch_assoc()): ?>
                            <option value="<?= $row['id']; ?>" 
                                    data-stock="<?= $row['stock_quantity']; ?>" 
                                    data-price="<?= $row['price']; ?>">
                                <?= htmlspecialchars($row['car_name'] . " " . $row['series'] . " (" . $row['year_release'] . ") - ₱" . number_format($row['price'], 2)); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <span id="stockLabel" class="badge bg-danger">Stock: 0</span>

                    <!-- Quantity -->
                    <label for="quantity" class="form-label mb-0">Quantity:</label>
                    <input type="number" class="form-control w-auto" id="quantity" name="quantity" min="1" oninput="validateQuantity()">

                    <!-- Total Price -->
                    <label class="form-label mb-0">Total Price:</label>
                    <input type="text" class="form-control w-auto" id="totalPrice" name="total_price" readonly>

                    <!-- Submit Button -->
                    <button type="button" class="btn btn-primary" onclick="submitOrder()">Add Order</button>
                </div>
            </form>
        </div>

        <!-- Pending Orders Table -->
        <div class="card p-4 shadow">
            <h3 class="mb-3 text-center">Pending Orders</h3>
            <table class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>Customer Name</th>
                        <th>Car</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $orderResult->fetch_assoc()): ?>
                        <tr class="<?= ($row['order_id'] % 2 == 0) ? 'table-light' : 'table-primary'; ?>">
                            <td><?= htmlspecialchars($row['customer_name']); ?></td>
                            <td><?= htmlspecialchars($row['car_name'] . " " . $row['series'] . " (" . $row['year_release'] . ")"); ?></td>
                            <td><?= $row['quantity']; ?></td>
                            <td>₱<?= isset($row['total_price']) ? number_format($row['total_price'], 2) : '0.00'; ?></td>
                            <td>
                                <span class="badge 
                                    <?= ($row['status'] == 'Pending') ? 'bg-warning text-dark' : 'bg-info'; ?>">
                                    <?= $row['status']; ?>
                                </span>
                            </td>
                            <td>
                                <a href="complete_order.php?id=<?= $row['order_id']; ?>" class="btn btn-success btn-sm">Complete</a>
                                <a href="cancel_order.php?id=<?= $row['order_id']; ?>" class="btn btn-danger btn-sm">Cancel</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function updateStockAndPrice() {
    let carSelect = document.getElementById("car");
    let stockLabel = document.getElementById("stockLabel");
    let stock = carSelect.options[carSelect.selectedIndex].getAttribute("data-stock");
    let price = carSelect.options[carSelect.selectedIndex].getAttribute("data-price");

    stockLabel.textContent = "Stock: " + stock; 
    stockLabel.className = "badge " + (parseInt(stock) > 5 ? "bg-success" : "bg-danger");

    document.getElementById("quantity").value = "";
    document.getElementById("totalPrice").value = "";
}

function validateQuantity() {
    let carSelect = document.getElementById("car");
    let stock = parseInt(carSelect.options[carSelect.selectedIndex].getAttribute("data-stock"));
    let price = parseFloat(carSelect.options[carSelect.selectedIndex].getAttribute("data-price"));
    let quantityInput = document.getElementById("quantity");
    let totalPriceInput = document.getElementById("totalPrice");

    let quantity = parseInt(quantityInput.value);
    
    if (quantity > stock) {
        Swal.fire({
            icon: 'warning',
            title: 'Not enough stock!',
            text: `Only ${stock} available.`,
        });
        quantityInput.value = stock;
    }

    if (!isNaN(quantity) && quantity > 0) {
        totalPriceInput.value = "₱" + (quantity * price).toFixed(2);
    } else {
        totalPriceInput.value = "";
    }
}

function submitOrder() {
    let customerName = document.getElementById("customer_name");
    let errorDiv = document.getElementById("customerError");

    if (customerName.value.trim() === "") {
        customerName.classList.add("is-invalid");
        errorDiv.style.display = "block";
        return false;
    } else {
        customerName.classList.remove("is-invalid");
        errorDiv.style.display = "none";
    }

    let formData = new FormData(document.getElementById("orderForm"));
    fetch('process_order.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(() => {
        Swal.fire({
            icon: 'success',
            title: 'Order Placed!',
            text: 'Your order has been successfully added.',
            confirmButtonText: 'OK'
        }).then(() => {
            document.getElementById("orderForm").reset();
            document.getElementById("stockLabel").textContent = "Stock: 0";
            document.getElementById("stockLabel").className = "badge bg-danger";
            document.getElementById("totalPrice").value = "";
            location.reload();
        });
    })
    .catch(error => console.error('Error:', error));

    return false;
}
</script>

<?php include("./includes/footer.php"); ?>
