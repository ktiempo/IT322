<?php
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
?>

<!--content -->
<main id="main" class="main flex-grow-1">

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="dashboard">
        <div class="container mt-4">

            <!-- Statistics Cards -->
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card p-3 text-center shadow">
                        <h5>Total Inventory</h5>
                        <h3>1,024</h3>
                        <p class="text-muted">Items in stock</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 text-center shadow">
                        <h5>Orders Today</h5>
                        <h3>37</h3>
                        <p class="text-muted">New customer orders</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 text-center shadow">
                        <h5>Pending Deliveries</h5>
                        <h3 class="text-warning">12</h3>
                        <p class="text-muted">Orders awaiting shipment</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 text-center shadow">
                        <h5>Low Stock Items</h5>
                        <h3 class="text-danger">5</h3>
                        <p class="text-muted">Needs restocking</p>
                    </div>
                </div>
            </div>

            <!-- Sales Overview & Recent Transactions -->
            <div class="row mt-4">
                <!-- Sales Overview -->
                <div class="col-md-6">
                    <div class="card p-2 shadow">
                        <h5 class="mb-2">Sales Overview</h5>

                        <!-- Sales Summary -->
                        <div class="row text-center">
                            <div class="col-4">
                                <h6 class="mb-1">Today</h6>
                                <h5 class="text-success mb-1">$520</h5>
                                <small class="text-muted">+5%</small>
                            </div>
                            <div class="col-4">
                                <h6 class="mb-1">This Week</h6>
                                <h5 class="text-primary mb-1">$3,800</h5>
                                <small class="text-muted">+12%</small>
                            </div>
                            <div class="col-4">
                                <h6 class="mb-1">This Month</h6>
                                <h5 class="text-warning mb-1">$15,200</h5>
                                <small class="text-muted">+8%</small>
                            </div>
                        </div>

                        <!-- Sales Chart (Even Smaller) -->
                        <canvas id="salesChart" style="height: 50px;"></canvas>

                        <p class="text-muted text-center mb-0 small">Monthly sales growth</p>
                    </div>
                </div>

                <!-- Recent Transactions -->
                <div class="col-md-6">
                    <div class="card p-2 shadow">
                        <h5 class="mb-2">Recent Transactions</h5>
                        <ul class="list-group small">
                            <li class="list-group-item py-1"><strong>John Doe</strong> bought <strong>5 Hot Wheels Ferrari</strong> - <span class="text-success">$50</span></li>
                            <li class="list-group-item py-1"><strong>Jane Smith</strong> ordered <strong>3 Hot Wheels Mustang</strong> - <span class="text-success">$30</span></li>
                            <li class="list-group-item py-1"><strong>Mark Lee</strong> purchased <strong>2 Hot Wheels Camaro</strong> - <span class="text-success">$20</span></li>
                            <li class="list-group-item py-1"><strong>Sarah Adams</strong> bought <strong>1 Hot Wheels Porsche</strong> - <span class="text-success">$10</span></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Top Selling Items -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card p-2 shadow">
                        <h5 class="mb-2">Top-Selling Items</h5>
                        <canvas id="topSellingChart" style="width: 100%; max-height: 80px;"></canvas>
                        <p class="text-muted text-center mb-0 small">Most sold items this month</p>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    var ctx2 = document.getElementById('topSellingChart').getContext('2d');
                    var topSellingChart = new Chart(ctx2, {
                        type: 'bar',
                        data: {
                            labels: ['Ferrari', 'Mustang', 'Porsche', 'Camaro', 'Lamborghini'],
                            datasets: [{
                                label: 'Units Sold',
                                data: [200, 180, 150, 130, 120],
                                backgroundColor: ['#FF5733', '#FFC300', '#36A2EB', '#4CAF50', '#8E44AD']
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    max: 250,
                                    ticks: {
                                        font: {
                                            size: 8 // Smaller font for better fit
                                        }
                                    }
                                },
                                x: {
                                    ticks: {
                                        font: {
                                            size: 8 // Smaller labels
                                        }
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false // Hide legend to save space
                                }
                            }
                        }
                    });
                });
            </script>
    </section>
</main>


<?php
include("./includes/footer.php");
?>