<?php
    date_default_timezone_set('Asia/Kolkata');
    include 'sql/config.php';
    include 'include/header.php';
    session_start();
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
                        <span style="margin-left: 7px; margin-right: 7px; font-weight: 200; font-family: 'Exo 2';"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i></span><span> Edit Marks</span>
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
                                    <a href="all-marks">
                                        <button type="button" class="btn btn-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem; letter-spacing: 0.7px;">
                                            All Records
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <form action="">
                        <div class="title-area-exam">
                            <div class="pt-2">
                                <h5><i class="fas fa-edit" style="padding-right: 8px;"></i> Edit Marks</h5><hr>
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
                                            <option disabled selected value>--Select Section <sub>*</sub>--</option>
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
                                <div class="row question-btn">
                                    <div class="col-12">
                                        <div style="display: block; float: right;">
                                            <button type="submit"> Proceed <i class="fas fa-arrow-right" style="font-size: 13px; padding-left: 7px;"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form>
                            <div class="title-area-exam">
                               <div class="table table-responsive">
                                    <table class="table table-bordered w-100">
                                        <tbody>
                                            <tr>
                                                <td>Class : </td>
                                                <td>Section : </td>
                                                <td>Session : </td>
                                                <td>Exam Type : </td>
                                                <td>Total Students : </td>
                                            </tr>
                                        </tbody>
                                    </table>
                               </div>
                               <div class="row" style="margin-top: -20px!important;">
                                    <div class=" col-lg-11 col-md-10 col-sm-12">
                                        <div class="class-form">
                                            <div class="mb-3">
                                                <select class="form-select">
                                                    <option disabled selected value>--Select Subject <sup>*</sup>--</option>
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
                                    </div>
                                    <div class="col-lg-1 col-md-2 col-sm-12">
                                        <div class="edit-marks-btn">
                                            <button type="submit" class="w-100">Search</button>
                                        </div>
                                    </div>
                               </div>
                            </div>
                        </form>    
                        <form>
                            <div class="title-area-exam">
                                <div class="table-responsive">
                                    <table id="example" class="display table-responsive nowrap table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Sno.</th>
                                                <th>Reg. No.</th>
                                                <th>Name</th>
                                                <th>Father's Name</th>
                                                <th>Class</th>
                                                <th>Section</th>
                                                <th>Roll No.</th>
                                                <th>Session</th>
                                                <th>Subject</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        </tbody>
                                    </table>
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