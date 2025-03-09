<?php
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
include("../../dB/config.php");

// Total Users Count
$totalUsersQuery = "SELECT COUNT(*) AS total_users FROM users";
$totalUsersResult = $conn->query($totalUsersQuery);
$totalUsers = $totalUsersResult->fetch_assoc()['total_users'];

// Most Recent User (Latest Registration)
$recentUserQuery = "SELECT firstName, lastName, createdAt FROM users ORDER BY createdAt DESC LIMIT 1";
$recentUserResult = $conn->query($recentUserQuery);
$recentUser = $recentUserResult->fetch_assoc();

// Users by Role Count
$roleSummaryQuery = "SELECT role, COUNT(*) AS total FROM users GROUP BY role";
$roleSummaryResult = $conn->query($roleSummaryQuery);

// Fetch all users for the table
$allUsersQuery = "SELECT userId, firstName, lastName, email, phoneNumber, gender, role, createdAt FROM users";
$allUsersResult = $conn->query($allUsersQuery);
?>

<main id="main" class="main flex-grow-1">
    <div class="pagetitle">
        <h1>User Management</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Users</li>
            </ol>
        </nav>
    </div>

    <section class="dashboard">
        <div class="row g-3">
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card p-3 text-center shadow">
                        <h5>Total Users</h5>
                        <h3 class="text-primary"><?php echo $totalUsers; ?></h3>
                        <p>Registered Users</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 text-center shadow">
                        <h5>Latest User</h5>
                        <?php if ($recentUser): ?>
                            <h3><?php echo $recentUser['firstName'] . " " . $recentUser['lastName']; ?></h3>
                            <p class="text-success">Joined on <?php echo date("F j, Y", strtotime($recentUser['createdAt'])); ?></p>
                        <?php else: ?>
                            <p>No recent signups</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card p-3 shadow">
                        <h5>Users by Role</h5>
                        <ul>
                        <?php 
                            $roleSummaryResult->data_seek(0); // Reset pointer before fetching again
                            while ($row = $roleSummaryResult->fetch_assoc()): ?>
                                <li><strong><?php echo ucfirst($row['role']); ?></strong>
                                    <span class="text-info"><?php echo $row['total']; ?> users</span>
                                </li>
                        <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
                
            </div>

            <!-- User Table -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card p-3 shadow">
                        <h5>All Users</h5>
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Gender</th>
                                    <th>Role</th>
                                    <th>Registered On</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $allUsersResult->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['userId']; ?></td>
                                        <td><?php echo $row['firstName'] . " " . $row['lastName']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['phoneNumber']; ?></td>
                                        <td><?php echo $row['gender']; ?></td>
                                        <td><?php echo ucfirst($row['role']); ?></td>
                                        <td><?php echo date("F j, Y", strtotime($row['createdAt'])); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var ctx = document.getElementById('userChart').getContext('2d');

        var userChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [<?php 
                    $roleSummaryResult->data_seek(0); // Reset pointer before fetching again
                    $labels = [];
                    $data = [];
                    while ($row = $roleSummaryResult->fetch_assoc()) {
                        $labels[] = "'" . addslashes(ucfirst($row['role'])) . "'";  
                        $data[] = (int)$row['total'];
                    }
                    echo implode(", ", $labels);
                ?>],
                datasets: [{
                    label: 'User Count',
                    data: [<?php echo implode(", ", $data); ?>],
                    backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8'],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });
</script>

<?php $conn->close(); ?>
<?php include("./includes/footer.php"); ?>
