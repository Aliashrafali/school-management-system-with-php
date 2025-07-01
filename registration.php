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
                        <nsen href="javascript:void(0)" style="margin-left: 20px; font-family: 'Exo 2';"><i class="fas fa-user" style="padding-right: 5px;"></i> Student Registration Panel</a>
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
                            <h5>All Student's Records</h5>
                            <span>
                                <?php
                                    $students = mysqli_query($conn, "SELECT COUNT(*) AS total FROM registration") or die(mysqli_error($conn));
                                    $allstudents = mysqli_fetch_assoc($students);
                                    $total = (int)$allstudents['total'];
                                    if($total < 0){
                                        $total = 0;
                                    }
                                ?>
                                Total Registered Students [ <?= $total; ?> ]
                            </span>
                            <a href="new-registration"><button>New Registration</button></a>
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
                                   <?php
                                        $rows = [];
                                        if(mysqli_num_rows($sql) > 0){
                                            $i = 1;
                                            $rows = mysqli_fetch_all($sql, MYSQLI_ASSOC);
                                            foreach($rows as $row){
                                        ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $row['reg_no']; ?></td>
                                                <td><span style="text-transform: capitalize;"><?= $row['name']; ?></span></td>
                                                <td><span style="text-transform: capitalize;"><?= $row['fname']; ?></span></td>
                                                <td><span style="text-transform: uppercase;"><?= $row['mobile']; ?></span></td>
                                                <td><span style="text-transform: uppercase;"><?= $row['class']; ?></span></td>
                                                <td>
                                                    <?php
                                                        $date = $row['registration_date'];
                                                        $newdate = date('d-m-Y', strtotime($date));
                                                    ?>
                                                    <span><?= $newdate; ?></span>
                                                </td>
                                                <td>
                                                    <?php
                                                        $dob = $row['dob'];
                                                        $newdob = date('d-m-Y', strtotime($dob));
                                                    ?>
                                                    <span><?= $newdob; ?></span>
                                                </td>
                                                <td>
                                                    <?php
                                                        if(empty($row['image'])){
                                                    ?>
                                                        <img src="img/office-man.png" alt="office" height="40px" width="40px" class="img-thumbnail">
                                                    <?php
                                                        }else{
                                                    ?>
                                                        <a href="sql/students/<?php echo $row['image']; ?>">
                                                            <img src="sql/students/<?php echo $row['image']; ?>" alt="<?php echo $row['image']; ?>" height="40px" width="40px" class="img-thumbnail">
                                                        </a>
                                                    <?php
                                                        }
                                                    ?>
                                                </td>
                                                <td style="font-size: 15px!important;">
                                                    <?php
                                                        if($row['status'] == 0){
                                                    ?>
                                                        <a href="edit_status.php?id=<?php echo $row['id']; ?>"><span class="badge rounded-pill text-bg-success">Active</span><span></span></a>
                                                    <?php
                                                        }else{
                                                    ?>
                                                        <a href="edit_status.php?id=<?php echo $row['id']; ?>"><span class="badge rounded-pill text-bg-warning">Suspended</span><span></span></a>
                                                    <?php
                                                        }
                                                    ?>
                                                </td>
                                                <td style="text-align: center; font-size: 15px!important;">
                                                    <a href="view_records?reg_no=<?php echo urlencode($row['reg_no']); ?>"><span class="badge rounded-pill text-bg-primary">View</span><span></span></a>
                                                    <a href="#?id=<?php echo $row['id']; ?>"><span class="badge rounded-pill text-bg-success">Edit</span><span></span></a><br>
                                                    <a href="print_reg?reg_no=<?php echo urlencode($row['reg_no']); ?>"><span class="badge rounded-pill text-bg-danger">Print</span><span></span></a>
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