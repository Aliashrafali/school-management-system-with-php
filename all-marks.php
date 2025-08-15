<?php
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
                        <span style="margin-left: 7px; margin-right: 7px; font-weight: 200; font-family: 'Exo 2';"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i></span><span> All Marks</span>
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
                        <div class="title-area">
                            <h5>All Marks</h5>
                            <span>
                                <?php
                                    $parents = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_parents") or die(mysqli_error($conn));
                                    $allparents = mysqli_fetch_assoc($parents);
                                    $total = (int)$allparents['total'];
                                    if($total < 0){
                                        $total = 0;
                                    }
                                ?>
                                Total Records [ <?= $total; ?> ]
                            </span>
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="display table-responsive nowrap table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sno.</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Subject</th>
                                        <th>Exam Type</th>
                                        <th>Session</th>
                                        <th>English</th>
                                        <th>Hindi</th>
                                        <th>Mathematics</th>
                                        <th>Environmental Studies</th>
                                        <th>General Knowledge</th>
                                        <th>Rhymes & Stories</th>
                                        <th>Drawing</th>
                                        <th>Music</th>
                                        <th>Computer Science</th>
                                        <th>Moral Science</th>
                                        <th>Science</th>
                                        <th>Social Science</th>
                                        <th>Art & Craft</th>
                                        <th>Physical Education</th>
                                        <th>Physics</th>
                                        <th>Chemistry</th>
                                        <th>Biology</th>
                                        <th>History</th>
                                        <th>Geography</th>
                                        <th>Civics</th>
                                        <th>Economics</th>
                                        <th>Computer Applications</th>
                                        <th>Art Education</th>
                                        <th>English Core</th>
                                        <th>Informatics Practices</th>
                                        <th>Psychology</th>
                                        <th>Environmental Studies</th>
                                        <th>Accountancy</th>
                                        <th>Business Studies</th>
                                        <th>Sociology</th>
                                        <th>Political Science</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
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