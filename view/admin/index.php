<?php
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
include("../../dB/config.php");

// Total Inventory Stock
$totalStockQuery = "SELECT SUM(stock_quantity) AS total_stock FROM inventory";
$totalStockResult = $conn->query($totalStockQuery);
$totalStock = $totalStockResult->fetch_assoc()['total_stock'];

// Most Recent Update (Latest Action)
$recentActivityQuery = "SELECT car_name, stock_quantity, created_at FROM inventory ORDER BY created_at DESC LIMIT 1";
$recentActivityResult = $conn->query($recentActivityQuery);
$recentActivity = $recentActivityResult->fetch_assoc();

// Low Stock Alert (Items with stock <= 5)
$lowStockQuery = "SELECT car_name, stock_quantity FROM inventory WHERE stock_quantity <= 5";
$lowStockResult = $conn->query($lowStockQuery);

// Inventory Summary by Model Count
$inventorySummaryQuery = "SELECT series, COUNT(DISTINCT car_name) AS total_models FROM inventory GROUP BY series";
$inventorySummaryResult = $conn->query($inventorySummaryQuery);
?>

<main id="main" class="main flex-grow-1">
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>

    <section class="dashboard">
        <div class="row g-3">
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card p-3 text-center shadow">
                        <h5>Total Inventory</h5>
                        <h3 class="text-primary"><?php echo $totalStock; ?></h3>
                        <p>Items in stock</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 text-center shadow">
                        <h5>Latest Update</h5>
                        <?php if ($recentActivity): ?>
                            <h3><?php echo $recentActivity['car_name']; ?></h3>
                            <p class="text-success"><?php echo $recentActivity['stock_quantity']; ?> items added</p>
                        <?php else: ?>
                            <p>No recent activity</p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 text-center shadow">
                        <h5>Low Stock Items</h5>
                        <ul>
                            <?php if ($lowStockResult->num_rows > 0): ?>
                                <?php while ($row = $lowStockResult->fetch_assoc()): ?>
                                    <li class="text-danger"><?php echo $row['car_name'] . " - " . $row['stock_quantity'] . " left"; ?></li>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <li>No items with low stock.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card p-3 shadow">
                        <h5>Inventory Summary by Model Count</h5>
                        <ul>
                            <?php while ($row = $inventorySummaryResult->fetch_assoc()): ?>
                                <li><?php echo $row['series'] . " - <span class='text-info'>" . $row['total_models'] . " models</span>"; ?></li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-3 shadow">
                        <h5>Inventory Stock Distribution</h5>
                        <canvas id="inventoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var ctx = document.getElementById('inventoryChart').getContext('2d');

        var inventoryChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [<?php 
                    $inventorySummaryResult->data_seek(0); // Reset pointer before fetching again
                    $labels = [];
                    $data = [];
                    while ($row = $inventorySummaryResult->fetch_assoc()) {
                        $labels[] = "'" . addslashes($row['series']) . "'";  // Added addslashes() for safety
                        $data[] = (int)$row['total_models']; // Ensure it's an integer
                    }
                    echo implode(", ", $labels);
                ?>],
                datasets: [{
                    label: 'Number of Models',
                    data: [<?php echo implode(", ", $data); ?>],
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>


<?php $conn->close(); ?>
<?php
include("./includes/footer.php");
?>
