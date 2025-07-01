<?php
    include 'title.php';
    include 'sql/config.php';
    include 'include/header.php';
    session_start();
    $reg_no = $_GET['reg_no'];
    $fetch = $conn->prepare("
        SELECT 
        registration.*,
        tbl_admission.section,
        tbl_admission.admission_date,
        tbl_admission.roll,
        tbl_admission.tution_fee,
        tbl_admission.transport_and_other_fee,
        tbl_admission.total,
        tbl_admission.month_year,
        tbl_admission.status
        FROM registration INNER JOIN tbl_admission ON registration.reg_no = tbl_admission.reg_no AND registration.session = tbl_admission.session WHERE registration.reg_no = ?
    ");
    $fetch->bind_param('s', $reg_no);
    $fetch->execute();
    $result = $fetch->get_result();
    if($result && $result->num_rows > 0){
        $row = $result->fetch_assoc();
    }
?>

<header>
    <?php include 'include/navbar.php'; ?>
</header>

<main>
    <section>
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="home-title">
                        <a href="" style="font-size: 25px; border-right: 0.1px solid #313131; padding-right: 20px;">Dashboard</a>
                        <a href="student" style="margin-left: 20px; font-family: 'Exo 2';"><i class="fas fa-user" style="padding-right: 5px;"></i> Student Registration Panel</a>
                        <span><i class="fas fa-angle-right" style="padding-left: 5px;"></i><i class="fas fa-angle-right" style="padding-right: 5px;"></i> Student Admission Record</span>
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
                            <a href="student"><button type="button" class="btn btn-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                                Back
                            </button></a><br>
                            <h6 class="pt-3">Student's Information</h6><hr>
                            <div class="table-responsive">
                                <div class="details-title">
                                    <span><b>Personal Details</b></span>
                                </div>
                                <table class="table table-bordered w-100">
                                    <tbody>
                                        <tr>
                                            <td colspan="2"><span style="text-transform: capitalize;">Registration No. :</span> <?= $row['reg_no']; ?></td>
                                            <td><span style="text-transform: capitalize;">Registration Date. :</span> 
                                                <?php 
                                                    $date = $row['registration_date'];
                                                    $org_date = date('d-m-Y', strtotime($date));
                                                    echo $org_date;
                                                ?>
                                            </td>
                                            <td><span style="text-transform: capitalize;">Admission Date. :</span> 
                                                <?php 
                                                    $adate = $row['admission_date'];
                                                    $org_adate = date('d-m-Y', strtotime($adate));
                                                    echo $org_adate;
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><span style="text-transform: uppercase;">Name : <?= $row['name']; ?></span></td>
                                            <td><span style="text-transform: uppercase;">Father's Name : <?= $row['fname']; ?></span></td>
                                            <td><span style="text-transform: uppercase;">Mother's Name : <?= $row['mname']; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td><span style="text-transform: uppercase;">Date of Birth : 
                                                <?php
                                                    $dob = $row['dob'];
                                                    $orgdob = date('d-m-Y', strtotime($dob));
                                                    echo $orgdob; 
                                                ?>
                                            </span></td>
                                            <td><span style="text-transform: uppercase;">Mobile : <?= $row['mobile']; ?></span></td>
                                            <td><span style="text-transform: uppercase;">Alt. Mobile No. : <?= $row['altmobile']; ?></span></td>
                                            <td><span>Email Id. : <?= $row['email']; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <span style="text-transform: uppercase;">Permanent Address : <br> <?= $row['parmanent_address']; ?></span><br><br>
                                                <span style="text-transform: uppercase;">Present Address : <br> <?= $row['present_address']; ?></span>
                                            </td>
                                            <td>
                                                <?php
                                                    if(!empty($row['image'])){
                                                ?>
                                                    <img src="sql/students/<?= $row['image']; ?>" alt="sql/students/<?= $row['image']; ?>" height="100px" width="100px" class="img-thumbnail">
                                                <?php
                                                    }
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="2">
                                                <span style="text-transform: uppercase;">Aadhar No. : <?= wordwrap($row['adhar'],4,' ', true); ?></span>
                                            </td>
                                            <td>
                                                <span style="text-transform: uppercase;">Blood Group : <?= $row['bgroup']; ?></span>
                                            </td>
                                            <td>
                                                <span style="text-transform: uppercase;">Gender : <?= $row['gender']; ?></span>
                                            </td>
                                        <tr>
                                            <td>
                                                <span style="text-transform: uppercase;">Religion : <?= $row['religion']; ?></span>
                                            </td>
                                            <td>
                                                <span style="text-transform: uppercase;">Category : <?= $row['category']; ?></span>
                                            </td>
                                            <td>
                                                <span style="text-transform: uppercase;">Registration Fees : <?= 'INR.' . ' '.number_format($row['registration_fee'], 2); ?></span>
                                            </td>
                                            <td>
                                                <span style="text-transform: uppercase;">Session : <?= $row['session']; ?></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="details-title">
                                    <span><b>Admission Details</b></span>
                                </div>
                                <table class="table table-bordered w-100">
                                    <tbody>
                                        <tr>
                                            <td><span style="text-transform: uppercase;">Class : <?= $row['class']; ?></span></td>
                                            <td><span style="text-transform: uppercase;">Section : <?= $row['section']; ?></span></td>
                                            <td><span style="text-transform: uppercase;">Roll : <?= $row['roll']; ?></span></td>
                                            <td><span style="text-transform: capitalize;">
                                                Admission : 
                                                <?php
                                                    echo ($row['status'] == 0) ? '<span class="badge rounded-pill text-bg-success">Success</span>' : '<span class="badge rounded-pill text-bg-danger">Failed</span>';
                                                ?>
                                            </span></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="details-title">
                                    <span><b>Fees Details</b></span>
                                </div>
                                <table class="table table-bordered w-100">
                                    <tbody>
                                        <tr>
                                            <td><span style="text-transform: uppercase;">Tution Fee : <?= $row['tution_fee']; ?></span></td>
                                            <td><span style="text-transform: uppercase;">Transport & Other Fees : <?= $row['transport_and_other_fee']; ?></span></td>
                                            <td><span style="text-transform: uppercase;">Total : <?= $row['total']; ?></span></td>
                                            <td><span style="text-transform: uppercase;">Start : <?= $row['month_year']; ?></span></td>
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