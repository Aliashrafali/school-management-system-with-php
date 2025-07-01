<?php
    session_start();
    include 'sql/config.php';
    include 'include/header.php';
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
        FROM registration INNER JOIN tbl_admission ON registration.reg_no = tbl_admission.reg_no AND registration.session = tbl_admission.session
    ");
    $fetch->execute();
    $result = $fetch->get_result();
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
                        <a href="javascript:void(0)" style="margin-left: 20px; font-family: 'Exo 2';"><i class="fas fa-rupee-sign" style="padding-right: 5px;"></i> Account Panel</a>
                         <span style="margin-left: 7px; margin-right: 7px; font-weight: 200; font-family: 'Exo 2';"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i></span><span> Demand Bill</span>
                    </div>
                </div> 
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="fees-view">
                        <div class="bill-form pt-3">
                            <div class="d-flex justify-content-between">
                                <span><b>Fill The Details --</b></span>
                                <button type="button" class="btn btn-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Add More</button>
                            </div><hr>
                            <form>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Class <sup><span style="color: red;">*</span></sup></label>
                                            <?php
                                                $classArray = [
                                                    "class" => ["nur","lkg","ukg","1", "2", "3", "4", "5","6", "7", "8", "9", "10", "11", "12"]
                                                ];
                                            ?>
                                            <select class="form-select" name="class" id="demand-class" aria-label="Default select example" required>
                                                <option disabled selected value="">--Select Class--</option>
                                                <?php
                                                    foreach($classArray['class'] as $class){
                                                        echo "<option value='<?= $class'>$class</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Section <sup><span style="color: red;">*</span></sup></label>
                                            <?php
                                                $sectionArray = [
                                                    "section" => ["A","B","C","D","E"]
                                                ];
                                            ?>
                                            <select class="form-select" name="class" id="demand-class" aria-label="Default select example" required>
                                                <option disabled selected value="">--Select Section--</option>
                                                <?php
                                                    foreach($sectionArray['section'] as $section){
                                                        echo "<option value='<?= $section'>$section</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div style="display: block; float: right;">
                                            <button type="submit">Generate</button>
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