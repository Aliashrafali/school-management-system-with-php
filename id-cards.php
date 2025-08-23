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
                        <a href="javascript:void(0)" style="margin-left: 20px; font-family: 'Exo 2';"><i class="fas fa-clipboard-check" style="padding-right: 5px;"></i> Exam Panel</a>
                        <span style="margin-left: 7px; margin-right: 7px; font-weight: 200; font-family: 'Exo 2';"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i></span><span> ID Cards</span>
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
                        <div class="row">
                            <div class="col-12">
                                <div style="display: block; float: right;">
                                    <a href="all-idcards">
                                        <button type="button" class="btn btn-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem; letter-spacing: 0.7px;">
                                            All ID Cards
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="title-area-exam">
                            <div class="pt-2">
                                <h5><i class="fas fa-user-circle" style="padding-right: 8px;"></i> ID Cards Download</h5><hr>
                            </div>
                            <form action="">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="mb-3">
                                        <select class="form-select">
                                            <option disabled selected value>--Select Class <sup>*</sup>--</option>
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
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="mb-3">
                                        <select class="form-select">
                                            <option disabled selected value>--Select Section <sup>*</sup>--</option>
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
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="mb-3">
                                            <select class="form-select">
                                                <option disabled selected value>--Select Session <sup>*</sup>--</option>
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
                                            <button type="submit" class="w-100"><i class="fas fa-download"></i> Download ID Cards</button>
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