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

    $sql = $conn->prepare("
        SELECT 
        tbl_demand.id AS demand_id,
        tbl_demand.*,
        registration.id,
        registration.reg_no,
        registration.name,
        registration.fname,
        registration.mobile,
        registration.class,
        registration.section
        FROM tbl_demand
        INNER JOIN registration
        ON tbl_demand.reg_no = registration.reg_no
        AND tbl_demand.student_id = registration.id AND tbl_demand.session = registration.session
    ");
    $sql->execute();
    $result = $sql->get_result();
?>

<header>
    <?php include 'include/navbar.php'; ?>
</header>

<main>
    <section>
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-5">
                    <div class="home-title">
                        <a href="" style="font-size: 25px; border-right: 0.1px solid #313131; padding-right: 20px;">Dashboard</a>
                        <a href="javascript:void(0)" style="margin-left: 20px; font-family: 'Exo 2';"><i class="fas fa-rupee-sign" style="padding-right: 5px;"></i> Account Panel</a>
                        <span style="margin-left: 7px; margin-right: 7px; font-weight: 200; font-family: 'Exo 2';"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i></span><span> Previous Payments Reports</span>
                    </div>
                </div> 
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 whole-section">
                    <div class="student-view">
                        <div class="title-area pb-2">
                            <span>
                                <?php
                                    $students = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_demand") or die(mysqli_error($conn));
                                    $allstudents = mysqli_fetch_assoc($students);
                                    $total = (int)$allstudents['total'];
                                    if($total < 0){
                                        $total = 0;
                                    }
                                ?>
                                Total Demand Bill [ <?= $total; ?> ]
                            </span>
                        </div>

                        <div class="title-area-search">
                            <form action="">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <?php
                                            $classArray = [
                                                "class" => ["nursery","KG 1","KG 2","Play","lkg","ukg","1", "2", "3", "4", "5","6", "7", "8", "9", "10", "11", "12"]
                                            ];
                                        ?>
                                        <select class="form-select" aria-label="Default select example">
                                            <option disabled selected value="">--Select Class--</option>
                                            <?php
                                                foreach($classArray['class'] as $class){
                                                    echo "<option value=\"$class\" style='text-transform:uppercase;'>$class</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>

                                     <div class="col-lg-3 col-md-3 col-sm-12">
                                        <?php
                                            $sectionArray = [
                                                "section" => ["A", "B", "C", "D", "E", "F"]
                                            ];
                                        ?>
                                        <select class="form-select" aria-label="Default select example">
                                            <option disabled selected value="">--Select Section--</option>
                                            <?php
                                                foreach($sectionArray['section'] as $section){
                                                    echo "<option value=\"$section\">$section</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <select class="form-select" aria-label="Default select example">
                                            <option disabled selected value="">--Select Session--</option>
                                            <?php
                                                $startYears = '2000';
                                                $endYears = date('Y');
                                                $fullYears = $startYears.'-'.$endYears;
                                                for($year = $startYears; $year <= $endYears; $year++){
                                                    $final = substr($year + 1, -2);
                                                     echo "<option value='{$year}-{$final}'>{$year}-{$final}</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-12">
                                        <button type="submit" class="btn btn-primary w-100" style="background-color: #091057;">
                                            <i class="fas fa-search me-1"></i> Search
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="display table-responsive nowrap table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sno.</th>
                                        <th>Reg. No.</th>
                                        <th>Name</th>
                                        <th>Father's Name</th>
                                        <th>Mobile No.</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Demand</th>
                                        <th>Date and Time</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php
                                        $i = 1;
                                        if($result->num_rows > 0){
                                            while($row = $result->fetch_assoc()){
                                    ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $row['reg_no']; ?></td>
                                            <td><span style="text-transform: capitalize;"><?= $row['name']; ?></span></td>
                                            <td><span style="text-transform: capitalize;"><?= $row['fname']; ?></span></td>
                                            <td><span><?= $row['mobile']; ?></span></td>
                                            <td><span style="text-transform: capitalize;"><?= $row['class']; ?></span></td>
                                            <td><span style="text-transform: capitalize;"><?= $row['section']; ?></span></td>
                                            <td><span><?= $row['month_year']; ?></span></td>
                                            <td><span>
                                                    <?php
                                                        $dateandtime = $row['date_and_time'];
                                                        $org_date = date('d-m-Y h:i A', strtotime($dateandtime));
                                                        echo $org_date;
                                                    ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php
                                                    if($row['paid'] == 0){
                                                        $status = '<span class="badge rounded-pill text-bg-danger"><i class="fa fa-times-circle"></i> Pending</span>';
                                                    }else if($row['paid'] > 0 AND $row['rest_dues'] > 0){
                                                        $status = '<span class="badge rounded-pill text-bg-warning"><i class="fas fa-adjust"></i> Partially Paid</span>';
                                                    }else if($row['rest_dues'] == 0 AND $row['paid'] != 0){
                                                        $status = '<span class="badge rounded-pill text-bg-success"><i class="fas fa-check-circle"></i> Full Paid</span>';
                                                    }else if($row['rest_dues'] < 0){
                                                        $status = '<span class="badge rounded-pill text-bg-primary"><i class="fas fa-check-circle"></i> Advanced Paid</span>';
                                                    }
                                                    echo $status;
                                                ?>
                                            </td>
                                            <td>                                                
                                                <a href="view_demand?demand_id=<?= $row['demand_id']; ?>&month_year=<?= urlencode($row['month_year']); ?>" style="background-color: #cce5ff; color: #004085; padding: 6px 8px; border-radius: 5px; margin-right: 5px;" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="ladger?session=<?= urlencode($row['session']); ?>&reg=<?= urlencode($row['reg_no']); ?>" style="background-color: #fff3cd; color: #856404; padding: 6px 8px; border-radius: 5px;" title="Ledger">
                                                    <i class="fas fa-folder-open"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                            }
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