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
    if(!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    include 'include/header.php';
?>
<header>
    <?php include 'include/navbar.php'; ?>
</header>
<main>
    <section>
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-5">
                    <div class="home-title">
                        <a href="" style="font-size: 25px; border-right: 0.1px solid #313131; padding-right: 20px;">Dashboard</a>
                        <a href="parents" style="margin-left: 20px; font-family: 'Exo 2';"><i class="fas fa-user" style="padding-right: 5px;"></i> Parents Panel</a>
                        <span style="margin-left: 7px; margin-right: 7px; font-weight: 200; font-family: 'Exo 2';"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i></span><span>Add Parents</span>
                    </div>
                </div> 
            </div>
        </div>
    </section>
    <section>
        <div id="toast" class="toast hidden"></div>
        <div class="container-fluid">
            <form id="parentDetails" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div class="row">
                    <div class="col-12">
                        <div class="student-view">
                            <span>Fill Parents Details --</span><hr>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="parents-form">
                                        <p>Father's Details</p>
                                        <div class="p-3">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="mb-3 row">
                                                        <label for="inputPassword" class="col-sm-3 col-form-label">Name <sup><span style="color: red;">*</span></sup> : </label>
                                                        <div class="col-sm-9">
                                                        <input type="text" name="name" class="form-control" id="pname" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" aria-describedby="emailHelp" placeholder="Enter Name" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="mb-3 row">
                                                        <label for="inputPassword" class="col-sm-3 col-form-label">Mobile No. <sup><span style="color: red;">*</span></sup> : </label>
                                                        <div class="col-sm-9">
                                                        <input type="text" name="mobile" class="form-control" id="pmobile" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Enter Your Mobile No." required>
                                                        </div>
                                                    </div>
                                                </div>

                                                 <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="mb-3 row">
                                                        <label for="inputPassword" class="col-sm-3 col-form-label">Alt. Mobile No. : </label>
                                                        <div class="col-sm-9">
                                                        <input type="text" name="altmobile" class="form-control" id="paltmobile" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Enter Your Alt. Mobile No.">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="mb-3 row">
                                                        <label for="inputPassword" class="col-sm-3 col-form-label">Email Id : </label>
                                                        <div class="col-sm-9">
                                                        <input type="email" name="email" class="form-control" id="pemail" placeholder="Enter Your Email Id" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            </div>
                            <div class="row mt-3 student-btn">
                                <div class="col-12">
                                    <div style="display: block; text-align: right;">
                                        <input type="reset" value="Reset">
                                        <input type="submit" name="ok" onclick="return validParents()" value="Submit">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>   
                </div>
            </form>
        </div>
    </section>
</main>
<!-- occupation -->

<!-- occupation end here -->

<script>
    // insert
    let parentDetails = document.getElementById('parentDetails');
    parentDetails.addEventListener('submit', async function(e) {
        e.preventDefault();
        if (document.getElementById('same-address').checked) {
            document.getElementById('present-address').value = document.getElementById('address').value;
        }
        const formData = new FormData(parentDetails);
        try{
            const response = await fetch('api/parents/create.php', {
                method : 'POST',
                body:formData
            });
            const result = await response.json();
            showToast(result.message, !result.success);
            setTimeout(() => {
                window.location.reload();
            }, 3000);
        }catch(error){
            alert("Something Went Wrong");
            console.error(error);
        }
    })
</script>

<?php
    include 'include/footer.php';
?>