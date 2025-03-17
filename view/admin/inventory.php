<?php
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
include("../../dB/config.php");

// Fetch all inventory items
$query = "SELECT * FROM inventory";
$result = mysqli_query($conn, $query);
?>

<main id="main" class="main flex-grow-1 p-5">
    <div class="pagetitle text-center mb-4">
        <h1 class="fw-bold text-primary">Car Inventory List</h1>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <button class="btn btn-primary shadow" data-bs-toggle="modal" data-bs-target="#addInventoryModal">+ Add Item</button>
    </div>

    <section class="inventory">
        <div class="card shadow-sm p-4 border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered text-center rounded overflow-hidden">
                        <thead class="table-primary text-white">
                            <tr>
                                <th>ID</th>
                                <th>Car Name</th>
                                <th>Series</th>
                                <th>Year</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['id']); ?></td>
                                    <td><?= htmlspecialchars($row['car_name']); ?></td>
                                    <td><?= htmlspecialchars($row['series']); ?></td>
                                    <td><?= htmlspecialchars($row['year_release']); ?></td>
                                    <td>₱<?= number_format($row['price'], 2); ?></td>
                                    <td><?= htmlspecialchars($row['stock_quantity']); ?></td>
                                    <td><?= htmlspecialchars($row['description']); ?></td>
                                    <td class="text-nowrap">
                                        <button class="btn btn-warning btn-sm me-1 shadow" data-bs-toggle="modal" data-bs-target="#editInventoryModal" onclick="populateEditModal(<?= $row['id']; ?>, '<?= htmlspecialchars(addslashes($row['car_name'])); ?>', '<?= htmlspecialchars(addslashes($row['series'])); ?>', '<?= $row['year_release']; ?>', '<?= $row['price']; ?>', '<?= $row['stock_quantity']; ?>', '<?= htmlspecialchars(addslashes($row['description'])); ?>')">Edit</button>
                                        <a href="../../view/admin/delete.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm shadow" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
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

<!-- Add Modal -->
<div class="modal fade" id="addInventoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Inventory Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addInventoryForm" method="POST" action="../../view/admin/add_car.php">
                    <div class="mb-3">
                        <label class="form-label">Car Name</label>
                        <input type="text" class="form-control" name="car_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Series</label>
                        <input type="text" class="form-control" name="series" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Year Release</label>
                        <input type="number" class="form-control" name="year_release" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" class="form-control" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stock Quantity</label>
                        <input type="number" class="form-control" name="stock_quantity" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Item</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editInventoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Inventory Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editInventoryForm" method="POST" action="../../view/admin/update_car.php">
                    <input type="hidden" name="id" id="editInventoryId">
                    <div class="mb-3">
                        <label class="form-label">Car Name</label>
                        <input type="text" class="form-control" name="car_name" id="edit_car_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Series</label>
                        <input type="text" class="form-control" name="series" id="edit_series" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Year Release</label>
                        <input type="number" class="form-control" name="year_release" id="edit_year_release" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" class="form-control" name="price" id="edit_price" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stock Quantity</label>
                        <input type="number" class="form-control" name="stock_quantity" id="edit_stock_quantity" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="edit_description" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function populateEditModal(id, name, series, year, price, stock, description) {
    document.getElementById('editInventoryId').value = id;
    document.getElementById('edit_car_name').value = name;
    document.getElementById('edit_series').value = series;
    document.getElementById('edit_year_release').value = year;
    document.getElementById('edit_price').value = price;
    document.getElementById('edit_stock_quantity').value = stock;
    document.getElementById('edit_description').value = description;
}
</script>

<?php include("./includes/footer.php"); ?>
