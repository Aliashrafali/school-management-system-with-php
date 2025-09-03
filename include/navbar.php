<div class="container-fluid top-header">
  <div class="row" style="border-bottom: 0.1px solid #EEE;">
    <div class="col-12 col-md-4 p-0 m-0">
      <div class="top-header-left">
        <a href="">Mobile : +91- 9006861511, +91-6201675471 </a><br>
        <a href="mailto:akhileshsingh90068@gmail.com">Email: akhileshsingh90068@gmail.com</a>
      </div>
    </div>

    <div class="col-12 col-md-4 p-0 m-0 text-center">
      <div class="top-header-middile">
        <h1 class="school-name">RN MISSION PUBLIC SCHOOL</h1>
        <p class="school-address">Mujauna bazar,Parsa( Saran )</p>
      </div>
    </div>

    <div class="col-12 col-md-4 p-0 m-0">
      <div class="top-header-right" style="padding-right: 20px!important;">
        <span><input type="search" name="search" placeholder="Search..."></span>
        <span><i class="far fa-bell"></i></span>
        <span><i class="far fa-envelope-open"></i></span>
        <span><img src="img/profile.png" onclick="Profile()" height="40px" width="40px"></span>

        <div id="profile">
          <div class="logout">
            <!-- <a href="#" class="admin-active"><i class="far fa-user"></i> Hello, <?= htmlspecialchars($claims['name'], ENT_QUOTES, 'UTF-8') ?></a> -->
            <form action="api/login/logout.php" method="POST">
                <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ✅ Desktop Navbar -->
  <div class="row mt-2 d-none d-md-flex">
    <div class="col-12 d-flex justify-content-center" id="desktop">
      <div class="navbar-btn">
        <nav>
          <a href="index"><button id="active"><i class="fas fa-tachometer-alt"></i> Dashboard</button></a>

          <div class="dropdown">
            <button class="dropbtn"><i class="fas fa-graduation-cap"></i> Student</button>
            <div class="dropdown-content">
              <a href="registration"><i class="fas fa-book me-2"></i> Registration</a>
              <a href="student"><i class="fas fa-user-graduate me-2"></i> Admission</a>
            </div>
          </div>

          <a href="" id="desk-top"><button><i class="fas fa-user"></i> Teacher</button></a>
          <a href="parents" id="desk-top"><button><i class="fas fa-users"></i> Parents</button></a>

          <div class="dropdown">
            <button class="dropbtn"><i class="fas fa-user"></i> Users</button>
            <div class="dropdown-content">
              <a href="add-users"><i class="fas fa-user-plus me-2"></i> Add Users</a>
              <a href="#"><i class="fas fa-user-friends me-2"></i> View Users</a>
            </div>
          </div>

          <div class="dropdown">
            <button class="dropbtn"><i class="fas fa-male"></i> Staff</button>
            <div class="dropdown-content">
              <a href="#"><i class="fas fa-users-cog me-2"></i> Staffs</a>
              <a href="#"><i class="fas fa-clipboard-check me-2"></i> Take Attendance</a>
              <a href="#"><i class="fas fa-table me-2"></i> View Attendance</a>
            </div>
          </div>

          <div class="dropdown">
            <button class="dropbtn"><i class="fas fa-book"></i> Attendance</button>
            <div class="dropdown-content">
              <a href="#"><i class="fas fa-clipboard-check me-2"></i> Take Attendance</a>
              <a href="#"><i class="fas fa-table me-2"></i> View Attendance</a>
            </div>
          </div>

          <div class="dropdown">
            <button class="dropbtn"><i class="fas fa-clipboard-check"></i> Exam</button>
            <div class="dropdown-content">
              <a href="admit-cards"><i class="fas fa-id-card me-2"></i> Admit Card</a>
              <a href="question-paper"><i class="fas fa-tasks me-2"></i> Question Paper</a>
              <a href="edit-marks"><i class="fas fa-edit me-2"></i> Edit Marks</a>
              <a href="marksheet"><i class="fas fa-scroll me-2"></i> Marksheet</a>
              <a href="id-cards"><i class="fas fa-user-circle me-2"></i> ID Card</a>
            </div>
          </div>

          <div class="dropdown">
            <button class="dropbtn"><i class="fas fa-rupee-sign"></i> Account</button>
            <div class="dropdown-content">
              <a href="demand-bill"><i class="fas fa-file-invoice-dollar me-2"></i> Demand Bill</a>
              <a href="invoice-reports"><i class="fas fa-chart-line me-2"></i> Invoice & Reports</a>
              <a href="previous-reports"><i class="fas fa-chart-bar me-2"></i> Previous Reports</a>
            </div>
          </div>

          <div class="dropdown">
            <button class="dropbtn"><i class="fas fa-chart-bar"></i> Payment Reports</button>
            <div class="dropdown-content">
              <a href="collection-reports"><i class="fas fa-file-invoice-dollar me-2"></i> Collection Report</a>
              <a href="dues-reports"><i class="fas fa-wallet me-2"></i> Dues Reports</a>
            </div>
          </div>

          <a href="" id="desk-top"><button><i class="fas fa-user-shield"></i> Administrator</button></a>
          <a href="" id="desk-top"><button><i class="fas fa-cog"></i> Setting</button></a>
        </nav>
      </div>
    </div>
  </div>

  <!-- ✅ Mobile Navbar (Hamburger + Offcanvas) -->
  <div class="row d-md-none mt-2 mobile-view-area">
    <div class="col-12 d-flex justify-content-between align-items-center px-3">
      <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" style="background-color: #4300ff;">
        <i class="fas fa-bars"></i>
      </button>
      <span class="fw-bold text-white">ERP School Software</span>
    </div>
  </div>
</div>
<!-- ✅ Offcanvas Sidebar Menu -->
<div class="offcanvas offcanvas-start" id="mobileMenu">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title text-white">RN MISSION PUBLIC SCHOOL</h5><hr>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="list-unstyled">
      <li><a href="index" class="d-block mb-2"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
      <li>
        <a class="d-block mb-2" data-bs-toggle="collapse" href="#studentMenu"><i class="fas fa-graduation-cap me-2"></i> Student</a>
        <div class="collapse ps-3" id="studentMenu">
          <a href="registration" class="d-block mb-1"><i class="fas fa-book me-2"></i> Registration</a>
          <a href="student" class="d-block mb-1"><i class="fas fa-user-graduate me-2"></i> Admission</a>
        </div>
      </li>
      <li><a href="#" class="d-block mb-1"><i class="fas fa-user me-2"></i> Teacher </a></li>
      <li><a href="parents" class="d-block mb-1"><i class="fas fa-users me-2"></i> Parents </a></li>
      <li>
        <a class="d-block mb-2" data-bs-toggle="collapse" href="#usersMenu"><i class="fas fa-user me-2"></i> Users</a>
        <div class="collapse ps-3" id="usersMenu">
          <a href="add-users" class="d-block mb-1"><i class="fas fa-user-plus me-2"></i> Add Users</a>
          <a href="#" class="d-block mb-1"><i class="fas fa-user-friends me-2"></i> View Users</a>
        </div>
      </li>
      <li>
        <a class="d-block mb-2" data-bs-toggle="collapse" href="#staffMenu"><i class="fas fa-male me-2"></i> Staff</a>
        <div class="collapse ps-3" id="staffMenu">
          <a href="#"><i class="fas fa-users-cog me-2"></i> Staffs</a>
          <a href="#"><i class="fas fa-clipboard-check me-2"></i> Take Attendance</a>
          <a href="#"><i class="fas fa-table me-2"></i> View Attendance</a>
        </div>
      </li>
      <li>
        <a class="d-block mb-2" data-bs-toggle="collapse" href="#attendanceMenu"><i class="fas fa-book me-2"></i> Attendance</a>
        <div class="collapse ps-3" id="attendanceMenu">
          <a href="#"><i class="fas fa-clipboard-check me-2"></i> Take Attendance</a>
          <a href="#"><i class="fas fa-table me-2"></i> View Attendance</a>
        </div>
      </li>
      <li>
        <a class="d-block mb-2" data-bs-toggle="collapse" href="#examMenu"><i class="fas fa-clipboard-check me-2"></i> Exam</a>
        <div class="collapse ps-3" id="examMenu">
          <a href="admit-cards"><i class="fas fa-id-card me-2"></i> Admit Card</a>
          <a href="question-paper"><i class="fas fa-tasks me-2"></i> Question Paper</a>
          <a href="edit-marks"><i class="fas fa-edit me-2"></i> Edit Marks</a>
          <a href="marksheet"><i class="fas fa-scroll me-2"></i> Marksheet</a>
          <a href="id-cards"><i class="fas fa-user-circle me-2"></i> ID Card</a>
        </div>
      </li>
      <li>
        <a class="d-block mb-2" data-bs-toggle="collapse" href="#accountMenu"><i class="fas fa-rupee-sign me-2"></i> Account</a>
        <div class="collapse ps-3" id="accountMenu">
          <a href="demand-bill"><i class="fas fa-file-invoice-dollar me-2"></i> Demand Bill</a>
          <a href="invoice-reports"><i class="fas fa-chart-line me-2"></i> Invoice & Reports</a>
          <a href="previous-reports"><i class="fas fa-chart-bar me-2"></i> Previous Reports</a>
        </div>
      </li>
      <li>
        <a class="d-block mb-2" data-bs-toggle="collapse" href="#paymentMenu"><i class="fas fa-chart-bar me-2"></i> Payment Reports</a>
        <div class="collapse ps-3" id="paymentMenu">
          <a href="collection-reports"><i class="fas fa-file-invoice-dollar me-2"></i> Collection Report</a>
          <a href="dues-reports"><i class="fas fa-wallet me-2"></i> Dues Reports</a>
        </div>
      </li>
      <li><a href="#"><i class="fas fa-user-shield me-2"></i> Administrator</a></li>
      <li><a href="#"><i class="fas fa-cog me-2"></i> Setting</a></li>
      <li><a href="javascript:void(0)">
        <form action="api/login/logout.php" method="POST">
                <button type="submit"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
        </form>
      </a></li>
    </ul>
  </div>
</div>
