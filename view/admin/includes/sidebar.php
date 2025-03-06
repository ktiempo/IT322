<!-- ======= Admin Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <!-- Dashboard -->
    <li class="nav-item">
      <a class="nav-link" href="../../view/admin/dashboard/dashboard.php">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard -->

    <!-- Inventory -->
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#inventory-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-box"></i><span>Inventory</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="inventory-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <li><a href="../../view/admin/inventory/inventory-view.php"><i class="bi bi-circle"></i><span>View All Items</span></a></li>
        <li><a href="../../view/admin/inventory/inventory-add.php"><i class="bi bi-circle"></i><span>Add New Item</span></a></li>
        <li><a href="inventory-stock-logs.html"><i class="bi bi-circle"></i><span>Stock Logs</span></a></li>
      </ul>
    </li><!-- End Inventory -->

    <!-- Orders -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="orders.html">
        <i class="bi bi-cart"></i>
        <span>Orders</span>
      </a>
    </li><!-- End Orders -->

    <!-- Users -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="users.html">
        <i class="bi bi-people"></i>
        <span>Users</span>
      </a>
    </li><!-- End Users -->

  </ul>

</aside><!-- End Admin Sidebar -->
