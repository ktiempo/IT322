<?php
include("../../dB/config.php");
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
?>

<!-- Main Content -->
<main id="main" class="main container-fluid">
    <div class="pagetitle">
        <h1>Low Stock Alerts</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Low Stock Alerts</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="LowStock">
        <div class="row g-3">
            <div class="container mt-5 px-0">
                <h2 class="mb-4">Items That Need Restocking</h2>

                <?php
                $sql = "SELECT * FROM inventory WHERE stock_quantity <= low_stock_threshold";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<div class='alert alert-warning'><strong>Warning:</strong> The following items need restocking!</div>";
                    echo "<table class='table table-bordered table-striped'>";
                    echo "<thead class='table-danger'><tr><th>Item</th><th>Stock</th><th>Threshold</th></tr></thead>";
                    echo "<tbody>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['car_name']}</td>
                                <td>{$row['stock_quantity']}</td>
                                <td>{$row['low_stock_threshold']}</td>
                              </tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<div class='alert alert-success'>All items are sufficiently stocked.</div>";
                }
                ?>
            </div>
        </div>
    </section>
</main>

<?php
include("./includes/footer.php");
?>
