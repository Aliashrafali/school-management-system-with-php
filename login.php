<?php include 'include/header.php'; ?>
<?php
    session_start();
    $error = $_GET['error'] ?? '';
    $msg = '';
    $type = 'error';

    if ($error === 'required') {
        $msg = '⚠ Username and Password required';
    } elseif ($error === 'invalid') {
        $msg = '❌ Invalid username or password';
    } elseif ($error === 'method') {
        $msg = '⚠ Invalid request method';
    } elseif ($error === 'logout') {
        $msg = '✅ You have been logged out';
        $type = 'success';
    }
?>
<style>
    main{
        padding-top: 10%!important; 
        margin-top: 0!important; 
    }
</style>
<main>
    <section>
        <div class="top-login">
            <h1 class="erp-title">
                Welcome to <span>Kid’s Blooming World School</span>
            </h1>
            <div class="erp-badge">
                <i class="fas fa-school"></i>
                ERP School Software
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <form action="api/login/login.php" method="POST">
                <div class="row mt-2">
                    <div class="col-lg-4 col-md-4 col-sm-12"></div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <?php if (isset($error) && !empty($msg)): ?>
                            <div class="alert alert-danger text-center shadow-sm rounded-3 py-2 px-3" role="alert">
                                <i class="bi bi-exclamation-circle"></i> 
                                <?php echo htmlspecialchars($msg); ?>
                            </div>
                        <?php elseif (isset($success) && !empty($msg)): ?>
                            <div class="alert alert-success text-center shadow-sm rounded-3 py-2 px-3" role="alert">
                                <i class="bi bi-check-circle"></i> 
                                <?php echo htmlspecialchars($msg); ?>
                            </div>
                        <?php endif; ?>
                        <div class="login-form p-3">
                            <div class="login-img">
                                <img src="img/account-protection.png" alt="account-protection" height="80px" width="80px">
                                <p><b>Account Login</b></p>
                            </div>
                            <div class="form-group erp-input">
                                <i class="fas fa-user"></i>
                                <input type="email" name="username" class="form-control" id="username" placeholder="Enter your username">
                            </div>

                            <div class="form-group erp-input mt-2">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password">
                            </div>

                            <!-- <div class="form-group erp-input mt-2">
                                <i class="fas fa-users"></i>
                                <select class="form-control" id="usertype">
                                    <option value="">Select User Type</option>
                                    <option value="admin">Admin</option>
                                    <option value="teacher">Teacher</option>
                                    <option value="student">Student</option>
                                </select>
                            </div> -->
                            <button type="submit" class="btn erp-btn w-100 mt-3">
                                Login
                            </button>
                            <div style="display: block; text-align: center; padding-top: 10px;">
                                <a href="" style="text-decoration: none;">Forget Password</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>                
        </div>
    </section>
</main>

<?php include 'include/footer.php'; ?>