<?php 
    date_default_timezone_set('Asia/Kolkata');
    // declare(strict_types=1);
    require __DIR__ . '/api/login/check_auth.php';
    require __DIR__ . '/api/login/auth.php';

    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Expires: 0");
    $claims = require_auth();

    include 'title.php'; 
    include 'include/header.php';
    if(!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
?>
<style>
    body{
        background-color: #fff;
    }
</style>
<body>
  <div class="container register-container">
    <div class="row w-100">
      <div class="col-lg-12 mx-auto">
        <div class="row register-card">
          <div class="col-md-8 left-section d-none d-md-flex">
            <img src="img/signup.jpg" alt="Illustration">
          </div>
          <div class="col-md-4 p-5">
            <div class="text-center mb-4">
              <h3 class="fw-bold">Welcome to Kid's Blooming World School</h3>
              <p class="text-muted small-text" style="color: #c9b4c5!important;">Sign up to create your secure admin.</p>
            </div>
            <form id="add_user" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
              <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Full Name">
              </div>
              <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="username" class="form-control" placeholder="info@example.com">
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="password-container">
                    <input type="password" name="password" id="password" onkeyup="checkStrength(this.value)" class="form-control" placeholder="********">
                    <span onclick="togglePassword()" style="margin-top: -31px!important; margin-right:5px; display: block; float:right;">
                        👁️
                    </span>
                </div>
                <div id="strength"></div>  
              </div>
              <div class="mb-3 form-check">
                <input type="checkbox" name="term" class="form-check-input" id="agree">
                <label class="form-check-label small-text" for="agree">
                  I agree to <a href="#">privacy policy</a> & <a href="#">terms</a>
                </label>
              </div>
              <div class="d-grid mb-3">
                <button type="submit" class="btn btn-custom">Sign up</button>
              </div>
              <p class="text-center small-text">
                Have any account? <a href="#">No need add user</a>
              </p>
              <hr>
              <p class="text-center small-text">Or Continue With</p>
              <div class="d-flex justify-content-center gap-2">
                <button type="button" class="btn btn-outline-secondary" onclick="return alert('Update Soon !');">SignUp with Face</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    const userType = () => {
        if(document.getElementById('usertype').value == 'teacher'){
            document.getElementById('teacher_class').style.display = 'block';
        }else{
            document.getElementById('teacher_class').style.display = 'none';
        }
    };
    function togglePassword() {
        const passwordField = document.getElementById("password");
        if (passwordField.type === "password") {
        passwordField.type = "text"; // Show password
        } else {
        passwordField.type = "password"; // Hide password
        }
    }

    function checkStrength(password){
        let strengthBar = document.getElementById('strength');
        let hasLower = /[a-z]/.test(password);
        let hasUpper = /[A-Z]/.test(password);
        let hasNumber = /[0-9]/.test(password);
        let hasSpecial = /[@$!%*?&^#~]/.test(password);
        let isLength = password.length >= 8;
        let score = [hasLower, hasNumber, hasUpper, hasSpecial, isLength].filter(Boolean).length;

        if(password.length == 0){
            strengthBar.textContent = "";
        }else if(score <= 2){
            strengthBar.innerHTML = "<span style='font-size:13px;'>Weak Password <span style='font-size:10px;'>❌</span></span>";
            strengthBar.className = "weak";
        }else if(score === 3 || score === 4){
            strengthBar.innerHTML = "<span style='font-size:13px;'>Medium Password <span style='font-size:10px;'>⚠️</span></span>";
            strengthBar.className = "medium";
        }else if(score === 5){
            strengthBar.innerHTML = "<span style='font-size:13px;'><span style='font-size:10px;'>Strong Password ✅</span></span>";
            strengthBar.className = "strong";
        }
    }
  </script>
  <script>
    const add_user = document.getElementById('add_user');
    add_user.addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(add_user);
        try{
            const response = await fetch('api/auth/create.php' ,{
                method:'POST',
                body:formData
            });
            const res = await response.json();
            if(res.success){
                Toastify({
                    text: res.message,
                    duration: 5000,   
                    gravity: "top",  
                    position: "right", 
                    backgroundColor: "#27a243",
                    stopOnFocus: true, 
                }).showToast();
            } else {
                Toastify({
                    text: res.message,
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#f72b2a",
                    stopOnFocus: true,
                }).showToast();
            }
        }catch(error){
            alert("Something Went Wrong");
            console.error(error);
        }
    });
  </script>
</body>
</html>
