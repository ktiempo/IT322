<?php
session_start();
include("../dB/config.php");

if(isset($_POST["login"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $query = "SELECT userId, firstName, lastName, email, password, phoneNumber, gender, birthday, verification, role, profilePicture 
    FROM users WHERE email = '$email' AND password = '$password' LIMIT 1;";

    $query_run = mysqli_query($conn, $query);

    if($query_run) {
        if(mysqli_num_rows($query_run) > 0) {
            $data = mysqli_fetch_assoc($query_run);

            $userId = $data["userId"];
            $fullname = $data["firstName"]." ".$data["lastName"];
            $emailAddress = $data["email"];
            $userRole = $data["role"];
            $profilePicture = !empty($data["profilePicture"]) ? $data["profilePicture"] : "default.png"; // Set default if empty

            $_SESSION["auth"] = true;
            $_SESSION["role"] = $userRole;
            $_SESSION["authUser"] = [
                'userId' => $userId,
                'fullName' => $fullname,
                'emailAddress' => $emailAddress,
                'profilePicture' => $profilePicture  // ✅ Add this line
            ];

            if($userRole == 'admin'){
                header("Location: ../view/admin/index.php");
            } else if ($userRole == "user"){
                // Redirect user to the landing page with Hot Wheels pictures
                header("Location: ../view/users/homepage.php");
            } else {
                $_SESSION['message'] = "Invalid Credentials";
                $_SESSION["code"] = "error";
                header("Location: ../login.php");
            }
            exit();
        } else {
            $_SESSION['status'] = "There is something wrong";
            $_SESSION["code"] = "error";
            header("Location: ../login.php");
            exit();
        }

    } else {
        $_SESSION['status'] = "Invalid request";
        $_SESSION["code"] = "error";
        header("Location: ../login.php");
        exit();
    } 
}
?>
