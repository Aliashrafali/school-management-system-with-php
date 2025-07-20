<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Floating Label Fixed Top</title>
  <style>
    .form-group {
      position: relative;
      margin: 20px;
      width: 100%;
    }

    .form-group input {
      width: 100%;
      padding: 14px 10px 10px 10px;
      font-size: 16px;
      border: 2px solid #007bff;
      border-radius: 6px;
      outline: none;
    }

    .form-group label {
      position: absolute;
      top: -8px;
      left: 10px;
      background: white;
      padding: 0 5px;
      font-size: 13px;
      color: #007bff;
      pointer-events: none;
      transition: 0.2s ease;
    }
  </style>
</head>
<body>

  <div class="form-group">
    <label for="name">Full Width</label>
    <input type="text" id="name" name="name">
  </div>

</body>
</html>
