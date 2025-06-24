<!DOCTYPE html>
<html>
<head>
  <title>Address Auto Fill</title>
  <style>
    textarea {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

  <div>
    <label for="permanent-address">Permanent Address</label><br>
    <textarea id="permanent-address" rows="3" placeholder="Enter permanent address"></textarea>
  </div>

  <div>
    <input type="checkbox" id="same-address" onclick="copyAddress()">
    <label for="same-address">Current address is same as permanent address</label>
  </div>

  <div>
    <label for="current-address">Current Address</label><br>
    <textarea id="current-address" rows="3" placeholder="Enter current address"></textarea>
  </div>

  <script>
    function copyAddress() {
      const permanent = document.getElementById("permanent-address");
      const current = document.getElementById("current-address");
      const checkbox = document.getElementById("same-address");

      if (checkbox.checked) {
        current.value = permanent.value;
        current.setAttribute("disabled", true);
      } else {
        current.value = "";
        current.removeAttribute("disabled");
      }
    }
  </script>

</body>
</html>
