<?php
    include 'sql/config.php';
    include 'include/header.php';
    session_start();
    $sql = mysqli_query($conn, "SELECT * FROM registration") or die(mysqli_error($conn));
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
                        <nsen href="javascript:void(0)" style="margin-left: 20px; font-family: 'Exo 2';"><i class="fas fa-user" style="padding-right: 5px;"></i> Parent's Panel</a>
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
                            <h5>All Parent's Records</h5>
                            <span>
                                <?php
                                    $students = mysqli_query($conn, "SELECT COUNT(*) AS total FROM registration") or die(mysqli_error($conn));
                                    $allstudents = mysqli_fetch_assoc($students);
                                    $total = (int)$allstudents['total'];
                                    if($total < 0){
                                        $total = 0;
                                    }
                                ?>
                                Total Records [ <?= $total; ?> ]
                            </span>
                            <a href="add-parents"><button>Add New</button></a>
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
                                        <th>Registration Date</th>
                                        <th>Date Of Birth</th>
                                        <th>Image</th>
                                        <th>Status</th>
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