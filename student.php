<?php
    session_start();
    include 'sql/config.php';
    include 'include/header.php';
    $fetch = $conn->prepare("SELECT * FROM registration WHERE status = 1");
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
                        <a href="javascript:void(0)" style="margin-left: 20px; font-family: 'Exo 2';"><i class="fas fa-user" style="padding-right: 5px;"></i> Student Panel</a>
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
                            <h5>All Student's Admission Records</h5>
                            <?php
                                $sql = $conn->prepare("SELECT COUNT(*) AS total FROM registration WHERE status = 1");
                                $sql->execute();
                                $sql->bind_result($students_total);
                                $sql->fetch();
                                $sql->close();
                            ?>
                            <span>Total Students [ <?= $students_total; ?> ]</span>
                            <a href="addstudent"><button>Add New Student</button></a>
                        </div>
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
                                        <th>Roll</th>
                                        <th>Date Of Birth</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if($result->num_rows > 0){
                                            $i = 1;
                                            while($row = $result->fetch_assoc()){
                                    ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $row['reg_no']; ?></td>
                                                <td><span style="text-transform: capitalize;"><?= $row['name']; ?></span></td>
                                                <td><span style="text-transform: capitalize;"><?= $row['fname']; ?></span></td>
                                                <td><span style="text-transform: uppercase;"><?= $row['class']; ?></span></td>
                                                <td><span style="text-transform: uppercase;"><?= $row['section']; ?></span></td>
                                                <td><span style="text-transform: uppercase;"><?= $row['roll']; ?></span></td>
                                                <td><span>
                                                    <?php
                                                        $admission_date = $row['admission_date'];
                                                        $org_date = date('d-m-Y', strtotime($admission_date));
                                                        echo $org_date;
                                                    ?>
                                                </span></td>
                                                <td>
                                                    <?= ($row['status'] == 1) ? '<span class="badge rounded-pill text-bg-success">Success</span>' : '<span class="badge rounded-pill text-bg-danger">Admission Failed</span>' ?>
                                                </td>
                                                <td>
                                                    <a href="#?reg_id=<?= $row['reg_no']; ?>" class="badge rounded-pill text-bg-primary" style="text-decoration: none;">Edit</a>
                                                    <a href="view_admission?reg_no=<?= urlencode($row['reg_no']); ?>" class="badge rounded-pill text-bg-warning" style="text-decoration: none;">View</a>
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