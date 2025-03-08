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
                                    <th></th>
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
                                                <a href='update_stock.php?id={$row['id']}' class='btn btn-warning btn-sm'>Update</a>
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

<?php
include("./includes/footer.php");
?>
