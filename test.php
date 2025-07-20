<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>School Management Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(to right, #667eea, #764ba2);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif;
      color: white;
    }

    .container {
      max-width: 1200px;
    }

    .welcome-section {
      text-align: center;
      margin-bottom: 80px;
    }

    .welcome-section i {
      font-size: 60px;
      color: #ffc107;
      margin-bottom: 15px;
    }

    .welcome-section h2 {
      font-size: 36px;
      font-weight: bold;
    }

    .welcome-section p {
      font-size: 18px;
      color: #e0e0e0;
    }

    .login-card {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(8px);
      border-radius: 20px;
      padding: 30px;
      text-align: center;
      color: white;
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
      transition: transform 0.3s ease;
    }

    .login-card:hover {
      transform: scale(1.05);
    }

    .login-icon {
      font-size: 48px;
      margin-bottom: 15px;
    }

    .admin    { background: linear-gradient(135deg, #ff416c, #ff4b2b); }
    .accountant { background: linear-gradient(135deg, #06beb6, #48b1bf); }
    .teacher  { background: linear-gradient(135deg, #f7971e, #ffd200); }

    .btn-login {
      margin-top: 15px;
      border-radius: 25px;
      padding: 8px 24px;
      font-weight: 600;
      color: #333;
    }
  </style>
</head>
<body>

<div class="container">
  <!-- Welcome Header -->
  <div class="welcome-section">
    <i class="fas fa-school"></i>
    <h2>Welcome to School Management System</h2>
    <p>
      A centralized platform for managing academics, finances, staff, and operations with ease and efficiency.
    </p>
  </div>

  <!-- Cards -->
  <div class="row g-4 justify-content-center">
    <!-- Admin Card -->
    <div class="col-md-4">
      <div class="login-card admin">
        <div class="login-icon"><i class="fas fa-user-shield"></i></div>
        <h4>Admin Login</h4>
        <p>Manage users, roles, settings, and overall school control.</p>
        <a href="admin-login.php" class="btn btn-light btn-login">Login</a>
      </div>
    </div>

    <!-- Accountant Card -->
    <div class="col-md-4">
      <div class="login-card accountant">
        <div class="login-icon"><i class="fas fa-money-check-alt"></i></div>
        <h4>Accountant Login</h4>
        <p>Handle all student fees, dues, transactions, and finance reports.</p>
        <a href="accountant-login.php" class="btn btn-light btn-login">Login</a>
      </div>
    </div>

    <!-- Teacher Card -->
    <div class="col-md-4">
      <div class="login-card teacher">
        <div class="login-icon"><i class="fas fa-chalkboard-teacher"></i></div>
        <h4>Teacher Login</h4>
        <p>Access student reports, attendance, timetable and performance.</p>
        <a href="teacher-login.php" class="btn btn-light btn-login">Login</a>
      </div>
    </div>
  </div>
</div>

</body>
</html>
