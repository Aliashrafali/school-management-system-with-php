<?php
    date_default_timezone_set('Asia/Kolkata');
    require __DIR__ . '/api/login/check_auth.php';
    require __DIR__ . '/api/login/auth.php';

    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Expires: 0");
    $claims = require_auth();
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
                        <a href="javascript:void(0)" style="margin-left: 20px; font-family: 'Exo 2';"><i class="fas fa-clipboard-check" style="padding-right: 5px;"></i> Exam Panel</a>
                        <span style="margin-left: 7px; margin-right: 7px; font-weight: 200; font-family: 'Exo 2';"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i></span><span> Admit Cards</span>
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
                                    <a href="all-admitcards">
                                        <button type="button" class="btn btn-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem; letter-spacing: 0.7px;">
                                            View All Admit Cards
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="title-area-exam">
                            <div class="pt-2">
                                <h5><i class="fas fa-id-card" style="padding-right: 8px;"></i> Admit Cards Download</h5><hr>
                            </div>
                            <form id="admiCards" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <div class="mb-3">
                                        <select class="form-select" name="class">
                                            <option disabled selected value>--Select Class--</option>
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
                                        <select class="form-select" name="section">
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
                                            <select class="form-select" name="session">
                                                <option disabled selected value>--Select Session--</option>
                                                <?php
                                                    $startYears = '2000';
                                                    $endYears = date('Y');
                                                    $currentYear   = date('Y');
                                                    $nextYearShort = substr($currentYear + 1, -2);
                                                    $currentSession = $currentYear . '-' . $nextYearShort;

                                                    for($year = $startYears; $year <= $endYears; $year++){
                                                        $final = substr($year + 1, -2);
                                                        $session = $year . '-' . $final;
                                                        $selected = ($session === $currentSession) ? 'selected' : '';
                                                        echo "<option value='{$session}' {$selected}>{$session}</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <div class="mb-3">
                                            <select class="form-select" name="exam_type">
                                                <option disabled selected value>--Select Exam Type--</option>
                                                <!-- <option value="formative assessment 01">Formative Assessment 01</option>
                                                <option value="formative assessment 02">Formative Assessment 02</option>
                                                <option value="formative assessment 03">Formative Assessment 03</option>
                                                <option value="formative assessment 04">Formative Assessment 04</option> -->
                                                <option value="summative assessment 01">Summative Assessment 01</option>
                                                <!-- <option value="final examination">Final Examination</option> -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div style="display: block; float: right;">
                                            <button type="submit" class="w-100"><i class="fas fa-download"></i> Generate Admit Cards</button>
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

<script>
    let admiCards = document.getElementById('admiCards');
    admiCards.addEventListener("submit", async function(e){
        e.preventDefault();
        const formData = new FormData(admiCards);
        try {
            const response = await fetch('api/exam/admit-cards.php', {
                method:"POST",
                body:formData
            });
            const res = await response.json();
            if(res.success){
                Toastify({
                    text: res.message,
                    duration: 3000,   
                    gravity: "top",  
                    position: "right", 
                    backgroundColor: "#27a243",
                    stopOnFocus: true, 
                }).showToast();
                setTimeout(() => {
                    if(res.redirect){
                        window.location.href = res.redirect;
                    }
                }, 3000);
            } else {
                Toastify({
                    text: res.message,
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#f72b2a",
                    stopOnFocus: true,
                }).showToast();
            }
        } catch (error) {
            console.error(error);
            alert("Something Went Wrong");
        }
    });
</script>

<?php
    include 'include/footer.php';
?>