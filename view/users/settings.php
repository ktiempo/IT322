<?php
session_start();
include("../../dB/config.php");

// Redirect if user is not logged in
if (!isset($_SESSION["authUser"])) {
    header("Location: ../../login.php");
    exit();
}

$userId = $_SESSION["authUser"]["userId"];

// Fetch user settings
$query = "SELECT notifications, darkMode, password FROM users WHERE userId=?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}

$user = mysqli_fetch_assoc($result);

// Set default values
$notifications = isset($user["notifications"]) ? $user["notifications"] : 0;
$darkMode = isset($user["darkMode"]) ? $user["darkMode"] : 0;

// Handle settings update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateSettings"])) {
    $notifications = isset($_POST["notifications"]) ? 1 : 0;
    $darkMode = isset($_POST["darkMode"]) ? 1 : 0;

    $updateQuery = "UPDATE users SET notifications=?, darkMode=? WHERE userId=?";
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, "iii", $notifications, $darkMode, $userId);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION["message"] = "Settings updated successfully!";
        $_SESSION["authUser"]["notifications"] = $notifications;
        $_SESSION["authUser"]["darkMode"] = $darkMode;
    } else {
        $_SESSION["message"] = "Error updating settings.";
    }

    header("Location: settings.php");
    exit();
}

// Handle password change (WITHOUT HASHING)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["changePassword"])) {
    $currentPassword = $_POST["currentPassword"];
    $newPassword = $_POST["newPassword"];
    $confirmPassword = $_POST["confirmPassword"];

    // Verify current password (without hashing)
    if ($currentPassword !== $user["password"]) {
        $_SESSION["message"] = "Current password is incorrect.";
    } elseif ($newPassword !== $confirmPassword) {
        $_SESSION["message"] = "New passwords do not match.";
    } else {
        // Update the password directly (NO HASHING)
        $updatePasswordQuery = "UPDATE users SET password=? WHERE userId=?";
        $stmt = mysqli_prepare($conn, $updatePasswordQuery);
        mysqli_stmt_bind_param($stmt, "si", $newPassword, $userId);
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION["message"] = "Password changed successfully!";
        } else {
            $_SESSION["message"] = "Error changing password.";
        }
    }

    header("Location: settings.php");
    exit();
}
?>

<?php include("./includes/header.php"); ?>
<?php include("./includes/topbar.php"); ?>
<?php include("./includes/sidebar.php"); ?>

<div class="container mt-4">
    <h2 class="text-center">User Settings</h2>

    <?php if (isset($_SESSION["message"])): ?>
        <div class="alert alert-info">
            <?php 
                echo $_SESSION["message"]; 
                unset($_SESSION["message"]);
            ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm p-4">
        <form action="" method="POST">
            <input type="hidden" name="updateSettings" value="1">
            <!-- Notification Preferences -->
            <div class="mb-3 form-check">
                <input type="checkbox" name="notifications" class="form-check-input" id="notifications" <?php echo $notifications ? "checked" : ""; ?>>
                <label class="form-check-label" for="notifications">Enable Notifications</label>
            </div>

            <!-- Dark Mode -->
            <div class="mb-3 form-check">
                <input type="checkbox" name="darkMode" class="form-check-input" id="darkMode" <?php echo $darkMode ? "checked" : ""; ?>>
                <label class="form-check-label" for="darkMode">Enable Dark Mode</label>
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>

    <div class="card shadow-sm p-4 mt-4">
        <h4>Change Password</h4>
        <form action="" method="POST">
            <input type="hidden" name="changePassword" value="1">
            <div class="mb-3">
                <label>Current Password:</label>
                <input type="password" name="currentPassword" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>New Password:</label>
                <input type="password" name="newPassword" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Confirm New Password:</label>
                <input type="password" name="confirmPassword" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-danger">Change Password</button>
        </form>
    </div>
</div>

<?php include("./includes/footer.php"); ?>
