<?php
    date_default_timezone_set('Asia/Kolkata');
    require __DIR__ . '/api/login/check_auth.php';
    require __DIR__ . '/api/login/auth.php';

    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Expires: 0");
    $claims = require_auth();

    include 'sql/config.php';
    include 'include/header.php';

    $reg_id = $_GET['reg_no'];
    $fetch = $conn->prepare("SELECT * FROM registration WHERE reg_no  = ?");
    $fetch->bind_param('s', $reg_id);
    $fetch->execute();
    $result = $fetch->get_result();
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
    }else{
        $row = 'Not Found';
    }
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
                        <a href="registration.php" style="margin-left: 20px; font-family: 'Exo 2';"><i class="fas fa-user" style="padding-right: 5px;"></i> Student Registration Panel</a>
                        <span><i class="fas fa-angle-right" style="padding-left: 5px;"></i><i class="fas fa-angle-right" style="padding-right: 5px;"></i> Student's Record</span>
                    </div>
                </div> 
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="student-view">
                        <div class="all_records">
                            <a href="registration"><button type="button" class="btn btn-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem; background-color: #091057;">
                                Back
                            </button></a><br>
                            <h6 class="pt-3">Student's Information</h6><hr>
                            <div class="table-responsive">
                                <table class="table table-bordered w-100">
                                    <tbody>
                                        <tr>
                                            <td colspan="2"><span>Registration No. : <?php echo $row['reg_no']; ?></span></td>
                                            <td colspan="2"><span>Registration Date. :      
                                                <?php 
                                                    $rdate = new DateTime($row['registration_date']);
                                                    $orgrdate = $rdate->format('d-m-Y h:i:s A');
                                                    echo $orgrdate;
                                                ?>
                                            </span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><span style="text-transform: uppercase;">Name : <?= $row['name']; ?></span></td>
                                            <td><span style="text-transform: uppercase;">Fathre's Name : <?= $row['fname']; ?></span></td>
                                            <td><span style="text-transform: uppercase;">Mother's Name : <?= $row['mname']; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td><span style="text-transform: uppercase;">
                                                <?php
                                                    $date = $row['dob'];
                                                    $newdate = date('d-m-Y', strtotime($date));
                                                ?>
                                                    Date of Birth : <?= $newdate; ?>
                                                </span>
                                            </td>
                                            <td><span style="text-transform: uppercase;">Mobile : <?= $row['mobile']; ?></span></td>
                                            <td><span style="text-transform: uppercase;">Alt. Mobile : <?= $row['altmobile']; ?></span></td>
                                            <td><span style="text-transform: uppercase;">Email Id : </span> <?= $row['email']; ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <span style="text-transform: uppercase;">Permanent Address : <br> <?= $row['parmanent_address']; ?></span><br><br>
                                                <span style="text-transform: uppercase;">Present Address : <br> <?= $row['parmanent_address']; ?></span>
                                            </td>
                                            <td>
                                                <?php
                                                    if(empty($row['image'])){
                                                ?>
                                                    <img src="img/office-man.png" alt="office" height="200px" width="200px" class="img-thumbnail">
                                                <?php
                                                    }else{
                                                ?>
                                                    <img src="sql/students/<?php echo $row['image']; ?>" alt="sql/students/<?php echo $row['image']; ?>" height="100px" width="100px" class="img-thumbnail">
                                                <?php
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <?php
                                                    $adhar = $row['adhar'];
                                                    $space = chunk_split($adhar, 4, ' ');
                                                    $newadhar = trim($space);
                                                ?>
                                                <span style="text-transform: uppercase;">Aadhaar No. : <?= $newadhar; ?>
                                            </span></td>
                                            <td><span style="text-transform: uppercase;">Blood Group : <?= $row['bgroup']; ?></span></td>
                                            <td><span style="text-transform: uppercase;">Gender : <?= $row['gender']; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <span style="text-transform: uppercase;">Religion : <?= $row['religion']; ?>
                                            </span></td>
                                            <td><span style="text-transform: uppercase;">Category : <?= $row['category']; ?></span></td>
                                            <td><span style="text-transform: uppercase;">Class : <?= $row['class']; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <span style="text-transform: uppercase;">Registration Fees : INR. <?= number_format($row['registration_fee'], 2); ?>
                                            </span></td>
                                            <td><span style="text-transform: uppercase;">Session : <?= $row['session']; ?></span></td>
                                            <td><span style="letter-spacing: 1px;">
                                                <?php
                                                    if($row['status'] == 0){
                                                ?>
                                                    <span class="badge text-bg-warning">Admission Pending</span>
                                                <?php
                                                    }else{
                                                ?>
                                                    <span class="badge text-bg-success">Admission Done</span>
                                                <?php
                                                    }
                                                ?>
                                            </span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div> 
                    </div>
                </div>   
            </div>
        </div>
    </section>
</main>

<?php
    include 'include/footer.php';
?>