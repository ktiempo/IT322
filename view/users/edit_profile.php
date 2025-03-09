<?php
session_start();
include("../../dB/config.php");

if (!isset($_SESSION["authUser"])) {
    header("Location: ../../login.php");
    exit();
}

$userId = $_SESSION["authUser"]["userId"];
$query = "SELECT * FROM users WHERE userId='$userId'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (isset($_POST["updateProfile"])) {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $phoneNumber = $_POST["phoneNumber"];
    
    // Handle Profile Picture Upload
    if (!empty($_FILES["profilePicture"]["name"])) {
        $targetDir = "../../assets/img/";
        $fileName = basename($_FILES["profilePicture"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Allow only JPG, PNG, and JPEG files
        $allowedTypes = ["jpg", "png", "jpeg"];
        if (in_array(strtolower($fileType), $allowedTypes)) {
            if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $targetFilePath)) {
                $profilePicture = $fileName;
                $updateQuery = "UPDATE users SET profilePicture='$profilePicture' WHERE userId='$userId'";
                mysqli_query($conn, $updateQuery);
            }
        }
    }

    // Update other profile details
    $updateQuery = "UPDATE users SET firstName='$firstName', lastName='$lastName', email='$email', phoneNumber='$phoneNumber' WHERE userId='$userId'";
    if (mysqli_query($conn, $updateQuery)) {
        $_SESSION["message"] = "Profile updated successfully!";
    } else {
        $_SESSION["message"] = "Error updating profile.";
    }

    header("Location: user_profile.php");
    exit();
}
?>

<?php include("./includes/header.php"); ?>
<?php include("./includes/topbar.php"); ?>
<?php include("./includes/sidebar.php"); ?>

<div class="container mt-4">
    <h2 class="text-center">Edit Profile</h2>
    <div class="card shadow-sm p-4">
        <form action="" method="POST" enctype="multipart/form-data">
            <!-- Profile Picture -->
            <div class="text-center mb-3">
                <img src="../../assets/img/<?php echo !empty($user["profilePicture"]) ? $user["profilePicture"] : 'default.png'; ?>" 
                     alt="Profile Picture" class="rounded-circle" width="150" height="150">
                <input type="file" name="profilePicture" class="form-control mt-2">
            </div>

            <!-- Profile Details -->
            <div class="mb-3">
                <label>First Name:</label>
                <input type="text" name="firstName" class="form-control" value="<?php echo $user["firstName"]; ?>" required>
            </div>
            <div class="mb-3">
                <label>Last Name:</label>
                <input type="text" name="lastName" class="form-control" value="<?php echo $user["lastName"]; ?>" required>
            </div>
            <div class="mb-3">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" value="<?php echo $user["email"]; ?>" required>
            </div>
            <div class="mb-3">
                <label>Phone Number:</label>
                <input type="text" name="phoneNumber" class="form-control" value="<?php echo $user["phoneNumber"]; ?>" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" name="updateProfile" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</div>

<?php include("./includes/footer.php"); ?>
