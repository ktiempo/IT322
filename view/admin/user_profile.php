<?php
session_start();
include("../../dB/config.php");
include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");

// Fetch user details
$userId = $_SESSION["authUser"]["userId"];
$query = "SELECT * FROM users WHERE userId='$userId'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<div class="container mt-4">
    <h2 class="text-center">User Profile</h2>

    <div class="card shadow-sm p-4">
        <div class="text-center">
            <?php if (!empty($user["profile_picture"])): ?>
                <img src="../../uploads/profile_pictures/<?php echo $user["profile_picture"]; ?>" alt="Profile Picture" class="rounded-circle" width="150">
            <?php else: ?>
                <img src="../../uploads/profile_pictures/default.png" alt="Default Profile Picture" class="rounded-circle" width="150">
            <?php endif; ?>
        </div>

        <div class="mt-3">
            <p><strong>Full Name:</strong> <?php echo $user["firstName"] . " " . $user["lastName"]; ?></p>
            <p><strong>Email:</strong> <?php echo $user["email"]; ?></p>
            <p><strong>Phone Number:</strong> <?php echo $user["phoneNumber"]; ?></p>
            <p><strong>Gender:</strong> <?php echo ucfirst($user["gender"]); ?></p>
            <p><strong>Birthday:</strong> <?php echo date("F d, Y", strtotime($user["birthday"])); ?></p>
        </div>

        <div class="text-center">
            <a href="edit-profile.php" class="btn btn-primary">Edit Profile</a>
            <a href="change-password.php" class="btn btn-warning">Change Password</a>
        </div>
    </div>
</div>

<?php
include("./includes/footer.php");
?>
