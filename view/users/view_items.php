<?php
include("../../dB/config.php");
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
?>

<!-- Main Content -->
<main id="main" class="main container-fluid">

    <div class="pagetitle">
        <h1>Inventory</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Inventory</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="Inventory">
        <div class="row g-3">

            <div class="container mt-5 mb-0 px-0">
                <h2 class="mb-4">Inventory Items</h2>

                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead class="table-primary">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Series</th>
                                    <th>Year Release</th>
                                    <th>Price</th>
                                    <th>Stock Quantity</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM inventory";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                            <td>{$row['id']}</td>
                                            <td>{$row['car_name']}</td>
                                            <td>{$row['series']}</td>
                                            <td>{$row['year_release']}</td>
                                            <td>\${$row['price']}</td>
                                            <td>{$row['stock_quantity']}</td>
                                            <td>{$row['description']}</td>
                                            <td>
                                                <button class='btn btn-warning btn-sm' onclick='openUpdateModal({$row['id']}, {$row['stock_quantity']})'>Update</button>
                                            </td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='8' class='text-center'>No items found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
</main>

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateModalLabel">Update Stock</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="updateForm">
          <!-- Hidden input to store item ID -->
          <input type="hidden" id="updateId">

          <!-- Input field for stock quantity -->
          <div class="mb-3">
            <label for="updateStock" class="form-label">Stock Quantity</label>
            <input type="number" class="form-control" id="updateStock" required>
          </div>

          <!-- Save button -->
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
include("./includes/footer.php");
?>

<script>
  // Function to open the update modal and set values
  function openUpdateModal(id, stock) {
      document.getElementById('updateId').value = id;
      document.getElementById('updateStock').value = stock;
      var updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
      updateModal.show();
  }

  // Handle form submission
  document.getElementById('updateForm').addEventListener('submit', function(event) {
      event.preventDefault(); // Prevent default form submission

      let id = document.getElementById('updateId').value;
      let stock = document.getElementById('updateStock').value;

      // Send an AJAX request to update_stock.php
      fetch('update_stock.php', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `id=${id}&stock_quantity=${stock}`
      })
      .then(response => response.text())
      .then(data => {
          alert(data); // Show response message
          location.reload(); // Reload page to update stock
      })
      .catch(error => console.error('Error:', error));
  });
</script>
