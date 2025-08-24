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
                <div class="col-12">
                    <div class="student-view">
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
                                                    "class" => ["nur","lkg","ukg","1", "2", "3", "4", "5","6", "7", "8", "9", "10", "11", "12"]
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
                    </div>
                </div>   
            </div>
        </div>
    </section>
</main>
<?php
    include 'include/footer.php';
?>