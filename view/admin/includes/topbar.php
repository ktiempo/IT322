<?php
session_start(); // Start session to access logged-in user details

// Redirect if user is not logged in
if (!isset($_SESSION["authUser"])) {
    header("Location: ../../login.php");
    exit();
}

// Get logged-in user details safely
$loggedInUser = isset($_SESSION["authUser"]["fullName"]) 
    ? $_SESSION["authUser"]["fullName"] 
    : (isset($_SESSION["authUser"]["firstName"]) && isset($_SESSION["authUser"]["lastName"]) 
        ? $_SESSION["authUser"]["firstName"] . " " . $_SESSION["authUser"]["lastName"] 
        : "Unknown User");

$profilePicture = !empty($_SESSION["authUser"]["profilePicture"]) 
    ? "../../assets/img/" . $_SESSION["authUser"]["profilePicture"] 
    : "../../assets/img/prof.jpg";

?>

<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center" style="background-color: #D95A00;">

    <div class="d-flex align-items-center justify-content-between">
        <a href="homepage.php" class="logo d-flex align-items-center">
            <img src="../../assets/img/car_logo2.png" alt="">
            <span class="d-none d-lg-block">Wheels Я Us</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="POST" action="#">
            <input type="text" name="query" placeholder="Search" title="Enter search keyword">
            <button type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle" href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li><!-- End Search Icon-->

            <li class="nav-item dropdown">
                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>
                    <span class="badge bg-primary badge-number">4</span>
                </a><!-- End Notification Icon -->
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                    <li class="dropdown-header">
                        You have 4 new notifications
                        <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                    </li>
                    <li><hr class="dropdown-divider"></li>

                    <li class="notification-item">
                        <i class="bi bi-exclamation-circle text-warning"></i>
                        <div>
                            <h4>System Alert</h4>
                            <p>Important system update available.</p>
                            <p>30 min. ago</p>
                        </div>
                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li class="dropdown-footer">
                        <a href="#">Show all notifications</a>
                    </li>
                </ul><!-- End Notification Dropdown Items -->
            </li><!-- End Notification Nav -->

            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <!-- Profile Picture -->
                    <img src="<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile" class="rounded-circle" width="40" height="40">
                    
                    <!-- Username -->
                    <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo htmlspecialchars($loggedInUser); ?></span>
                </a><!-- End Profile Image Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6><?php echo htmlspecialchars($loggedInUser); ?></h6>
                        <span>User</span>
                    </li>
                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="user_profile.php">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="settings.php">
                            <i class="bi bi-gear"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="http://localhost/IT322/view/users/logout.php">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>
                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->
