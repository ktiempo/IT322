<?php
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
include("../../dB/config.php");

// Total Inventory Stock
$totalStockQuery = "SELECT SUM(stock_quantity) AS total_stock FROM inventory";
$totalStockResult = $conn->query($totalStockQuery);
$totalStock = $totalStockResult->fetch_assoc()['total_stock'];

// Total Users
$totalUsersQuery = "SELECT COUNT(*) AS total_users FROM users";
$totalUsersResult = $conn->query($totalUsersQuery);
$totalUsers = $totalUsersResult->fetch_assoc()['total_users'];

// Total Pending Orders
$pendingOrdersQuery = "SELECT COUNT(*) AS pending_orders FROM orders WHERE status = 'pending'";
$pendingOrdersResult = $conn->query($pendingOrdersQuery);
$pendingOrders = $pendingOrdersResult->fetch_assoc()['pending_orders'];

// Most Recent Update
$recentActivityQuery = "SELECT car_name, stock_quantity, created_at FROM inventory ORDER BY created_at DESC LIMIT 1";
$recentActivityResult = $conn->query($recentActivityQuery);
$recentActivity = $recentActivityResult->fetch_assoc();

// Low Stock Alert
$lowStockQuery = "SELECT car_name, stock_quantity FROM inventory WHERE stock_quantity <= 5";
$lowStockResult = $conn->query($lowStockQuery);

// Inventory Summary
$inventorySummaryQuery = "SELECT series, COUNT(DISTINCT car_name) AS total_models FROM inventory GROUP BY series";
$inventorySummaryResult = $conn->query($inventorySummaryQuery);
?>

<main id="main" class="main flex-grow-1">
    <div class="pagetitle">
        <h1>Dashboard</h1>
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
                        <h5>Total Users</h5>
                        <h3 class="text-success"><?php echo $totalUsers; ?></h3>
                        <p>Registered Users</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 text-center shadow">
                        <h5>Pending Orders</h5>
                        <h3 class="text-danger"><?php echo $pendingOrders; ?></h3>
                        <p>Orders awaiting approval</p>
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
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card p-3 shadow">
                        <h5>Low Stock Items</h5>
                        <ul>
                            <?php while ($row = $lowStockResult->fetch_assoc()): ?>
                                <li class="text-danger"><?php echo $row['car_name'] . " - " . $row['stock_quantity'] . " left"; ?></li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-3 shadow">
                        <h5>Inventory Summary</h5>
                        <ul>
                            <?php while ($row = $inventorySummaryResult->fetch_assoc()): ?>
                                <li><?php echo $row['series'] . " - " . $row['total_models'] . " models"; ?></li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
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
                    $inventorySummaryResult->data_seek(0);
                    $labels = [];
                    $data = [];
                    while ($row = $inventorySummaryResult->fetch_assoc()) {
                        $labels[] = "'" . addslashes($row['series']) . "'";
                        $data[] = (int)$row['total_models'];
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
<?php include("./includes/footer.php"); ?>