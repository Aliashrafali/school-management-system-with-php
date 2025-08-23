<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Password Strength Checker</title>
  <style>
    #strength {
      font-weight: bold;
      margin-top: 5px;
    }
    .weak { color: red; }
    .medium { color: orange; }
    .strong { color: green; }
  </style>
</head>
<body>

<form>
  <label>Password:</label><br>
  <input type="password" id="password" onkeyup="checkStrength(this.value)">
  <div id="strength"></div>
</form>

<script>
function checkStrength(password) {
    let strengthBar = document.getElementById("strength");

    // conditions
    let hasLower = /[a-z]/.test(password);
    let hasUpper = /[A-Z]/.test(password);
    let hasNumber = /[0-9]/.test(password);
    let hasSpecial = /[@$!%*?&^#~]/.test(password);
    let isLength = password.length >= 8;

    let score = [hasLower, hasUpper, hasNumber, hasSpecial, isLength].filter(Boolean).length;

    if (password.length === 0) {
        strengthBar.textContent = "";
    } else if (score <= 2) {
        strengthBar.textContent = "Weak Password ❌";
        strengthBar.className = "weak";
    } else if (score === 3 || score === 4) {
        strengthBar.textContent = "Medium Password ⚠️";
        strengthBar.className = "medium";
    } else if (score === 5) {
        strengthBar.textContent = "Strong Password ✅";
        strengthBar.className = "strong";
    }
}
</script>

</body>
</html>
