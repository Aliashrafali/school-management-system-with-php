<?php
    date_default_timezone_set('Asia/Kolkata');
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
                        <span style="margin-left: 7px; margin-right: 7px; font-weight: 200; font-family: 'Exo 2';"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i></span><span> Question Paper</span>
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
                                    <a href="all-questionpapers">
                                        <button type="button" class="btn btn-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem; letter-spacing: 0.7px;">
                                            All Question Paper
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <form action="">
                        <div class="title-area-exam">
                            <div class="pt-2">
                                <h5><i class="fas fa-tasks" style="padding-right: 8px;"></i> Create Question Paper</h5><hr>
                            </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <div class="mb-3">
                                            <select class="form-select">
                                                <option disabled selected value>--Select Class <sup>*</sup>--</option>
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
                                        <select class="form-select">
                                            <option disabled selected value>--Select Subject <sub>*</sub>--</option>
                                            <?php
                                               $subject = [
                                                    'subject' => ['English', 'Hindi', 'Mathematics', 'Environmental Studies', 'General Knowledge', 'Rhymes & Stories', 'Drawing', 'Music', 'Computer Science', 'Moral Science', 'Science', 'Social Science', 'Art & Craft', 'Physical Education', 'Physics', 'Chemistry', 'Biology', 'History', 'Geography', 'Civics', 'Economics', 'Computer Applications', 'Art Education', 'English Core', 'Informatics Practices', 'Psychology', 'Environmental Studies', 'Accountancy', 'Business Studies', 'Sociology', 'Political Science']
                                               ];
                                               foreach($subject['subject'] as $subject){
                                                echo "<option value=\"$subject\">$subject</option>";
                                               }
                                            ?>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12">
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
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <div class="mb-3">
                                            <select class="form-select">
                                                <option disabled selected value>--Select Exam Type--</option>
                                                <option value="quarterly">Quarterly Exam</option>
                                                <option value="half-yearly">Half-Yearly Exam</option>
                                                <option value="pre-annual">Pre-Annual Exam</option>
                                                <option value="annual">Annual Exam</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="title-area-exam">
                                <span>Write your question here</span><hr>
                                <textarea name="data" id="editor"></textarea>
                            </div>
                            <div class="row question-btn">
                                <div class="col-12 mt-2">
                                    <div style="display: block; float: right;">
                                        <button type="submit"><i class="fas fa-plus" style="padding-right: 2px; font-size: 13px!important;"></i> Create</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>   
            </div>
        </div>
    </section>
</main>

<?php
    include 'include/footer.php';
?>