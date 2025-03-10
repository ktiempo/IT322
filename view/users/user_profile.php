<?php
session_start();
include("../../dB/config.php");  // Database connection
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");

if (!isset($_SESSION["authUser"])) {
    header("Location: ../../login.php"); // Redirect to login if not authenticated
    exit();
}

$userId = $_SESSION["authUser"]["userId"];
$query = "SELECT * FROM users WHERE userId='$userId'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<div class="container mt-4">
    <h2 class="text-center">User Profile</h2>
    <div class="card shadow-sm p-4 text-center">
        <!-- Profile Picture (Centered) -->
        <div class="d-flex justify-content-center">
            <img src="../../assets/img/<?php echo !empty($user["profilePicture"]) ? $user["profilePicture"] : 'default.png'; ?>" 
                 alt="Profile Picture" class="rounded-circle mb-3" width="150" height="150">
        </div>

        <!-- User Information -->
        <p><strong>Name:</strong> <?php echo $user["firstName"] . " " . $user["lastName"]; ?></p>
        <p><strong>Email:</strong> <?php echo $user["email"]; ?></p>
        <p><strong>Phone:</strong> <?php echo $user["phoneNumber"]; ?></p>

        <!-- Navigate to Edit Profile -->
        <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
    </div>
</div>

<?php include("./includes/footer.php"); ?>
