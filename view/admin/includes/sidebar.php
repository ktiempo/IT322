<head>
  <style>
    /* Default Sidebar Styles */
    .sidebar {
      background-color: #00215E;
      color: white;
      transition: background 0.3s, color 0.3s;
    }

    /* Sidebar in Dark Mode */
    .sidebar.dark-mode {
      background-color: #0A2A66; /* Adjusted to a shade of blue */
      color: #F0DE36;
    }

    /* Sidebar Navigation */
    .sidebar-nav .nav-item {
      background-color: #F0DE36;
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
      color: black; /* Keep text color dark in dark mode */
    }

    /* Dark Mode Toggle Button */
    .dark-mode-toggle-container {
      position: absolute;
      bottom: 20px;
      right: 20px;
    }

    .dark-mode-toggle {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 10px;
      cursor: pointer;
      font-weight: bold;
      background: #F0DE36;
      border-radius: 5px;
      margin-bottom: 10px;
      border: none;
    }
  </style>
  <!-- Import Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <!-- Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="../../view/admin/dashboard.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard -->

      <!-- Inventory -->
      <li class="nav-item">
        <a class="nav-link" href="inventory.php">
            <i class="material-icons">directions_car</i>
            <span>Inventory Management</span>
        </a>
      </li><!-- End Inventory --> 

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
    
    <div class="dark-mode-toggle-container">
      <button id="dark-mode-toggle" class="dark-mode-toggle">
        <i class="bi bi-moon-fill"></i>
      </button>
    </div>
  </aside><!-- End Admin Sidebar -->
  
  <script>
    const toggle = document.getElementById('dark-mode-toggle');
    const sidebar = document.getElementById('sidebar');

    toggle.addEventListener('click', () => {
      document.body.classList.toggle('dark-mode');
      sidebar.classList.toggle('dark-mode');
      localStorage.setItem('dark-mode', document.body.classList.contains('dark-mode'));
    });

    if (localStorage.getItem('dark-mode') === 'true') {
      document.body.classList.add('dark-mode');
      sidebar.classList.add('dark-mode');
    }
  </script>
</body>
