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
    $month = date('n');
    $year = date('Y');
    if ($month >= 4) {
        $current_session = $year . '-' . substr($year + 1, -2);
    } else {
        $current_session = ($year - 1) . '-' . substr($year, -2);
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
                        <span style="margin-left: 7px; margin-right: 7px; font-weight: 200; font-family: 'Exo 2';"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i></span><span> All Admit Cards</span>
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
                        <a href="admit-cards"><button type="button" class="btn btn-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem; background-color: #091057;">Back</button></a>
                        <div class="title-area" style="background-color:#091057!important; color: #fff!important; border-radius: 5px 5px 0px 0px;">
                            <h5>All Admit Cards</h5>
                            <span>
                                <?php
                                    $admitcards = mysqli_query($conn, "SELECT COUNT(*) AS total FROM exam_type WHERE session = '$current_session'") or die(mysqli_error($conn));
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
                                    <div class="col-lg-5 col-md-5 col-sm-12">
                                        <select class="form-select" aria-label="Default select example">
                                            <option disabled selected value="">--Select Exam Type--</option>
                                                <option value="formative assessment 01">Formative Assessment 01</option>
                                                <option value="formative assessment 02">Formative Assessment 02</option>
                                                <option value="formative assessment 03">Formative Assessment 03</option>
                                                <option value="formative assessment 04">Formative Assessment 04</option>
                                                <option value="summative assessment 01">Summative Assessment 01</option>
                                                <option value="final examination">Final Examination</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-5 col-md-5 col-sm-12">
                                        <select class="form-select" aria-label="Default select example">
                                            <?php
                                                $startYears = date('Y')-1;
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

                                    <div class="col-lg-2 col-md-2 col-sm-12">
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
                                        <th>Exam Type</th>
                                        <th>Date & Time</th>
                                        <th>Session</th>
                                        <th style="width: 100px!important;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php
                                        $sql = $conn->prepare("SELECT * FROM exam_type");
                                        $sql->execute();
                                        $result = $sql->get_result();
                                        if($result->num_rows > 0){
                                            $i = 1;
                                            while($row = $result->fetch_assoc()){
                                    ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= strtoupper($row['exam_type']); ?></td>
                                                <td>
                                                    <?php
                                                        $date = $row['date_time'];
                                                        $orgDate = date('d-m-Y H:i:s A', strtotime($date));
                                                        echo $orgDate;
                                                    ?>
                                                </td>
                                                <td><?= $row['session']; ?></td>
                                                <td>
                                                    <a href="admit-cards-details?exam_id=<?php echo $row['id']; ?>&session=<?php echo $row['session']; ?>"><span class="badge rounded-pill text-bg-success">View List</span></a>
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