<head>
  <style>
    /* Default Sidebar Styles */
    .sidebar {
      background-color: #0074E4;
      color: white;
      transition: background 0.3s, color 0.3s;
    }

    /* Sidebar in Dark Mode */
    .sidebar.dark-mode {
      background-color: #1E1E1E;
      color: #D95A00;
    }

    /* Sidebar Navigation */
    .sidebar-nav .nav-item {
      background-color: #D95A00;
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
      color: #D95A00;
    }

    /* Dark Mode Toggle Button */
    .dark-mode-toggle {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 10px;
      cursor: pointer;
      font-weight: bold;
      background: #D95A00;
      border-radius: 5px;
      margin-bottom: 10px;
    }
  </style>
</head>
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <!-- Dashboard -->
    <li class="nav-item">
      <a class="nav-link" href="../../view/admin/index.php">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard -->

    <!-- Inventory -->
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#inventory-nav" data-bs-toggle="collapse" href="#" 
        aria-expanded="false">
          <i class="bi bi-box"></i>
          <span>Inventory</span>
          <i class="bi bi-chevron-down ms-auto toggle-icon"></i> 
      </a>
      <ul id="inventory-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li><a href="../../view/admin/inventory-view.php"><i class="bi bi-circle"></i><span>View All Items</span></a></li>
          <li><a href="../../view/admin/inventory-add.php"><i class="bi bi-circle"></i><span>Add New Item</span></a></li>
      </ul>
    </li>


    <!-- Orders -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="../../view/admin/orders.php">
        <i class="bi bi-cart"></i>
        <span>Orders</span>
      </a>
    </li><!-- End Orders -->

    <!-- Users -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="../../view/admin/user.php">
        <i class="bi bi-people"></i>
        <span>Users</span>
      </a>
    </li><!-- End Users -->

  </ul>

</aside><!-- End Admin Sidebar -->
