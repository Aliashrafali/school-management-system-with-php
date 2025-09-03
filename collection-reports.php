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
    if(!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    $query = $conn->prepare("
        SELECT r.reg_no, r.name, r.fname,r.mobile, r.class, r.section, r.roll, r.session,
                     p.invoice_no,p.date_and_time, p.month_year, p.total_amount, p.paid_amount, p.paid_by
              FROM registration r
              INNER JOIN tbl_payments p ON r.reg_no = p.reg_no AND r.session = p.session"
    );
    $query->execute();
    $result = $query->get_result();
    $data = [];
    $total_paid = 0;
    if($result->num_rows > 0){
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;  
            $total_paid += $row['paid_amount'];
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
                        <a href="javascript:void(0)" style="margin-left: 20px; font-family: 'Exo 2';"><i class="fas fa-chart-bar" style="padding-right: 5px;"></i> Payment Reports Panel</a>
                        <span style="margin-left: 7px; margin-right: 7px; font-weight: 200; font-family: 'Exo 2';"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i></span><span> Collections Reports</span>
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
                        <p>Total Paid Amount : <b><span style="color: #4300ff;">[ <?= number_format($total_paid, 2); ?> ]</span></b></p>
                        <div class="title-area-collection">
                            <div class="pt-2">
                                <h5>All Collections Reports in Excel</h5><hr>
                            </div>
                            <form id="collectionReports" method="POST" action="api/account/collection-reports.php">
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <div class="mb-3">
                                        <select class="form-select" name="class" required>
                                            <option disabled selected value>--Select Class--</option>
                                            <option value="all">All</option>
                                            <?php
                                                $classArray = [
                                                    "class" => ["nursery","KG 1","KG 2","Play","lkg","ukg","1", "2", "3", "4", "5","6", "7", "8", "9", "10", "11", "12"]
                                                ];
                                                foreach($classArray['class'] as $class){
                                                    echo "<option value=\"$class\" style='text-transform:uppercase'>$class</option>";
                                                }
                                            ?>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <div class="mb-3">
                                        <select class="form-select" name="section" required>
                                            <option disabled selected value>--Select Section--</option>
                                            <option value="all">All</option>
                                            <?php
                                               $sectionArray = [
                                                    "section" => ['A', 'B', 'C', 'D', 'E']
                                               ];
                                               foreach($sectionArray['section'] as $section){
                                                echo "<option value=\"$section\">$section</option>";
                                               }
                                            ?>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <div class="mb-3">
                                        <select class="form-select" name="month" required>
                                            <option disabled selected value>--Select Month--</option>
                                            <option value="all">All</option>
                                            <?php
                                                $currentYear = date('Y');
                                                for($m = 1; $m <= 12; $m++){
                                                    $monthName = date('F', mktime(0, 0, 0, $m, 1, $currentYear));
                                                    $value = $monthName . ' ' . $currentYear;
                                                    echo "<option value='$value'>$value</option>";
                                                }
                                            ?>
                                        </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <div class="mb-3">
                                            <select class="form-select" name="session" required>
                                                <option disabled selected value>--Select Session--</option>
                                                <option value="all">All</option>
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
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div style="display: block; float: right;">
                                            <button type="submit" class="w-100"><i class="fas fa-file-excel" style="padding-right: 7px;"></i> Download Excel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="title-area-collection">
                            <div class="table-responsive">
                                <table id="example" class="display table-responsive nowrap table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Invoice</th>
                                            <th>Reg. No.</th>
                                            <th>Name</th>
                                            <th>Father</th>
                                            <th>Mobile</th>
                                            <th>Class</th>
                                            <th>Session</th>
                                            <th>Date & Time</th>
                                            <th>Paid</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach($data as $row){
                                        ?>
                                            <tr>
                                                <td><?php echo $row['invoice_no']; ?></td>
                                                <td><?php echo $row['reg_no']; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['fname']; ?></td>
                                                <td>
                                                    <?php 
                                                        if(empty($row['mobile']) || $row['mobile'] == '0'){
                                                            echo "<span class='badge badge-outline-warning'>Not Mentioned</span>";
                                                        }else{
                                                            echo $row['mobile'];
                                                        }
                                                    ?>
                                                </td>       
                                                <td><?php echo $row['class'];?></td>
                                                <td><?php echo $row['session']; ?></td>
                                                <td><?php
                                                     $date = $row['date_and_time'];
                                                     $org_date = date('d-m-Y H:i:s A', strtotime($date));
                                                     echo $org_date; 
                                                    ?>
                                                </td>
                                                <td><?php echo number_format($row['paid_amount'], 2); ?></td>
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
        </div>
    </section>
</main>

<?php
    include 'include/footer.php';
?>