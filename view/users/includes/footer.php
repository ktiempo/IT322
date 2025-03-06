<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Wheels R Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .card {
            border-radius: 10px;
        }
        .low-stock {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <h2 class="mt-4">User Dashboard</h2>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card p-3">
                    <h5>Items in Stock</h5>
                    <h3>720</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <h5>Sold Items (Today)</h5>
                    <h3>15</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <h5>Low Stock Items</h5>
                    <h3 class="low-stock">8</h3>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card p-3">
                    <h5>Inventory Updates</h5>
                    <ul>
                        <li>Restocked: Hot Wheels Mustang (+10)</li>
                        <li>Sold: Hot Wheels Camaro (-2)</li>
                        <li>Low Stock: Hot Wheels Porsche (Only 1 left!)</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3">
                    <h5>Stock Activity Chart</h5>
                    <canvas id="stockChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        var ctx = document.getElementById('stockChart').getContext('2d');
        var stockChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Restocked', 'Sold', 'Low Stock'],
                datasets: [{
                    label: 'Stock Updates',
                    data: [30, 15, 8],
                    backgroundColor: ['green', 'blue', 'red'],
                    borderColor: ['green', 'blue', 'red'],
                    borderWidth: 1
                }]
            }
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>