<head>
  <style>
    /* Default Sidebar Styles */
    .sidebar {
      background-color: #4251AE;
      color: white;
      transition: background 0.3s, color 0.3s;
    }

    /* Sidebar in Dark Mode */
    .sidebar.dark-mode {
      background-color: #1E1E1E;
      color: #F1D74D;
    }

    /* Sidebar Navigation */
    .sidebar-nav .nav-item {
      background-color: #F1D74D;
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 10px;
    }

    .sidebar-nav .nav-item a {
      text-decoration: none;
      color: black;
      display: block;
    }

    /* Dark Mode Sidebar Links */
    .sidebar.dark-mode .nav-item {
      background-color: #333;
    }

    .sidebar.dark-mode .nav-item a {
      color: #F1D74D;
    }

    /* Dark Mode Toggle Button */
    .dark-mode-toggle {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 10px;
      cursor: pointer;
      font-weight: bold;
      background: #F1D74D;
      border-radius: 5px;
      margin-bottom: 10px;
    }
  </style>
</head>
  
  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item" style="background-color: #F1D74D; padding: 10px; border-radius: 5px">
      <a class="nav-link " href="dashboard.php">
        <i class="bi bi-house-door"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->

    <li class="nav-item" style="background-color: #F1D74D; padding: 10px; border-radius: 5px">
      <a class="nav-link " href="view_items.php">
        <i class="bi bi-list-check"></i>
        <span>Inventory</span>
      </a>
    </li><!-- End Inventory Nav -->

    <li class="nav-item" style="background-color: #F1D74D; padding: 10px; border-radius: 5px">
      <a class="nav-link collapsed" href="low_stock.php">
        <i class="bi bi-exclamation-triangle"></i>
        <span>Low Stock Alerts</span>
      </a>
    </li><!-- End Low Stock Al Nav -->
   
    <!--  <li class="nav-heading">Pages</li> -->

    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">