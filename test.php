<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Beautiful Bootstrap 5 Form</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 CSS -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #74ebd5, #ACB6E5);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .form-container {
      max-width: 500px;
      margin: 80px auto;
      background: white;
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }
    .form-title {
      font-size: 28px;
      font-weight: 600;
      text-align: center;
      margin-bottom: 25px;
      color: #333;
    }
    .form-control {
      border-radius: 10px;
    }
    .btn-custom {
      border-radius: 10px;
      background: #4CAF50;
      color: white;
      transition: background 0.3s ease;
    }
    .btn-custom:hover {
      background: #45a049;
    }
  </style>
</head>
<body>



<div class="mb-3 position-relative">
  <label for="date2" class="form-label">Choose a Date</label>
  <div class="input-group">
    <span class="input-group-text bg-primary text-white"><i class="fas fa-calendar-alt"></i></span>
    <input type="date" class="form-control" id="date2">
  </div>
</div>

  <!-- Bootstrap 5 JS (optional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
