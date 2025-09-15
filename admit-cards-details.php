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
    
    if(isset($_GET['exam_id']) && isset($_GET['session'])){
        $exam_id = $_GET['exam_id'];
        $session = $_GET['session'];
    }

    $sql = $conn->prepare("
        SELECT r.reg_no, r.session, r.name, r.class, r.fname, r.mname, r.section, r.roll, e.exam_type, s.exam_id
        FROM summative_assessment01 s
        INNER JOIN exam_type e ON s.exam_id = e.id
        INNER JOIN registration r ON s.reg_no = r.reg_no AND s.session = r.session
        WHERE s.exam_id = ? AND s.session = ? AND r.status = 1
    ");
    $sql->bind_param('is', $exam_id,$session);
    $sql->execute();
    $result = $sql->get_result();
    $data = [];
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $data[] = $row;
            $exam_types[] = $row['exam_type'];
        }
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
                        <a href="javascript:void(0)" style="margin-left: 20px; font-family: 'Exo 2';"><i class="fas fa-clipboard-check" style="padding-right: 5px;"></i> Exam Panel</a>
                        <span style="margin-left: 7px; margin-right: 7px; font-weight: 200; font-family: 'Exo 2';"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i></span><span> All Admit Cards <i class="fas fa-angle-right" style="padding-left: 5px;"></i><i class="fas fa-angle-right" style="padding-right: 5px;"></i>
                            <?php
                                if(!empty($exam_types)) : ?>
                                <span style="text-transform: capitalize;"><?= $exam_types[0] ?></span>
                            <?php endif; ?>
                        </span>
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
                        <a href="all-admitcards"><button type="button" class="btn btn-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem; background-color: #091057;">Back</button></a>
                        <div class="title-area" style="background-color:#091057!important; color: #fff!important; border-radius: 5px 5px 0px 0px;">
                            <h5>All Student's Records for Admit Cards</h5>
                            <span>
                                <?php
                                    $admitcards = mysqli_query($conn, "SELECT COUNT(*) AS total FROM summative_assessment01 WHERE session = '$session'") or die(mysqli_error($conn));
                                    $all = mysqli_fetch_assoc($admitcards);
                                    $total = (int)$all['total'];
                                    if($total < 0){
                                        $total = 0;
                                    }
                                ?>
                                Total Records [ <?= $total; ?> ]
                            </span>
                        </div>
                        <div class="title-area-admit">
                            <form>
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <input type="text" name="name" class="form-control" placeholder="Enter Name">
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <input type="text" name="reg_no" class="form-control" placeholder="Enter Registration No.">
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <input type="email" name="email" class="form-control" placeholder="Enter Email ID">
                                    </div>
                                    
                                    <div class="col-lg-2 col-md-6 col-sm-12">
                                        <input type="text" name="mobile" class="form-control" placeholder="Enter Mobile No.">
                                    </div>

                                    <div class="col-lg-1 col-md-2 col-sm-12">
                                        <button type="submit" class="btn btn-primary w-100" style="padding-top: 10px; padding-bottom: 10px; background-color:#091057;">Search</button>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="display table-responsive nowrap table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sno.</th>
                                        <th>Reg No.</th>
                                        <th>Name</th>
                                        <th>Father</th>
                                        <th>Session</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Roll</th>
                                        <th>Certificate</th>
                                        <th>Admit Card</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php
                                        $i = 1;
                                        foreach($data as $admit){
                                    ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $admit['reg_no']; ?></td>
                                            <td><span style="text-transform: capitalize;"><?= $admit['name']; ?></span></td>
                                            <td><span style="text-transform: capitalize;"><?= $admit['fname']; ?></span></td>
                                            <td><span style="text-transform: uppercase;"><?= $admit['session']; ?></span></td>
                                            <td><span style="text-transform: uppercase;"><?= $admit['class']; ?></span></td>
                                            <td><span style="text-transform: uppercase;"><?= $admit['section']; ?></span></td>
                                            <td>
                                                 <?php
                                                    if (empty($admit['roll']) || $admit['roll'] == 0) {
                                                        echo "<span class='badge badge-outline-warning'>Not Mentioned</span>";
                                                    } else {
                                                        echo $admit['roll']; 
                                                    }
                                                ?>
                                            </td>
                                            <td><span class="badge rounded-pill text-bg-danger">Not Generated</span></td>
                                            <td><span class="badge rounded-pill text-bg-success">Generated</span></td>
                                        </tr>
                                    <?php
                                        }    
                                   ?>
                                </tbody>
                            </table>
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