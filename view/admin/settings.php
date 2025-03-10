<?php
session_start();
if (!isset($_SESSION["authUser"])) {
    header("Location: ../../login.php");
    exit();
}

$loggedInUser = $_SESSION["authUser"]["fullName"];

include("./includes/header.php");
include("./includes/topbar.php");
include("./includes/sidebar.php");
?>

<div class="container mt-5">
    <div class="settings-container p-4 bg-white rounded shadow">
        <h3 class="text-center">Settings</h3>
        <hr>

        <!-- Change Password Button (Opens Modal) -->
        <button class="btn btn-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
            <i class="bi bi-lock"></i> Change Password
        </button>

        <!-- Dark Mode Toggle -->
        <button class="btn btn-dark w-100 mb-2" id="darkModeToggle">
            <i class="bi bi-moon"></i> Toggle Dark Mode
        </button>

        <!-- Need Help -->
        <button class="btn btn-secondary w-100 mb-2" onclick="location.href='help.php'">
            <i class="bi bi-question-circle"></i> Need Help?
        </button>

        <!-- Delete Account Button (Opens Modal) -->
        <button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
            <i class="bi bi-trash"></i> Delete Account
        </button>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="change_password.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" class="form-control" name="currentPassword" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" class="form-control" name="newPassword" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" name="confirmPassword" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Confirmation Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Delete Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <p class="text-danger">⚠ Are you sure you want to delete your account?</p>
                <p>This action cannot be undone.</p>
                <button class="btn btn-danger w-45" onclick="deleteAccount()">Yes, Delete</button>
                <button class="btn btn-secondary w-45" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
// Apply dark mode on page load based on localStorage
document.addEventListener("DOMContentLoaded", function () {
    if (localStorage.getItem("darkMode") === "enabled") {
        document.body.classList.add("dark-mode");
    }
});

// Dark Mode Toggle Function
document.getElementById('darkModeToggle').addEventListener('click', function() {
    document.body.classList.toggle("dark-mode");

    // Store the preference in localStorage
    if (document.body.classList.contains("dark-mode")) {
        localStorage.setItem("darkMode", "enabled");
    } else {
        localStorage.setItem("darkMode", "disabled");
    }
});

// Delete Account Function
function deleteAccount() {
    window.location.href = 'delete_account.php';
}
</script>

<?php
include("./includes/footer.php");
?>
