<?php
    include 'sql/config.php';
    include 'include/header.php';
    session_start();
    $id = $_GET['id'];
    $sql = $conn->prepare("
        SELECT 
        tbl_demand.id AS demand_id,
        tbl_demand.*,
        registration.id,
        registration.reg_no,
        registration.name,
        registration.fname,
        registration.mobile,
        registration.class,
        registration.section
        FROM tbl_demand
        INNER JOIN registration
        ON tbl_demand.reg_no = registration.reg_no
        AND tbl_demand.student_id = registration.id
        WHERE tbl_demand.id = ?
    ");
    $sql->bind_param('s', $id);
    $sql->execute();
    $result = $sql->get_result();
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
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
                        <a href="javascript:void(0)" style="margin-left: 20px; font-family: 'Exo 2';"><i class="fas fa-rupee-sign" style="padding-right: 5px;"></i> Account Panel</a>
                        <span style="margin-left: 7px; margin-right: 7px; font-weight: 200; font-family: 'Exo 2';"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i></span><span> Payments</span>
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
                        <a href="invoice-reports"><button type="button" class="btn btn-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem; background-color: #091057;">Back</button></a>
                        <div class="title-area-payments">
                            <div class="table-responsive">
                                <table class="table table-bordered w-100">
                                    <thead>
                                        <tr>
                                            <th>Reg. No.</th>
                                            <th>Name</th>
                                            <th>Tution Fee</th>
                                            <th>Transport and Other Fees</th>
                                            <?php
                                                $other_fees = [];
                                                if (!empty($row['other_fee'])) {
                                                    $fee_items = explode(',', $row['other_fee']); 

                                                    foreach ($fee_items as $item) {
                                                        $item = trim($item); 
                                                        if (!empty($item)) {
                                                            $last_space_pos = strrpos($item, ' ');
                                                            $label = substr($item, 0, $last_space_pos);
                                                            $amount = substr($item, $last_space_pos + 1);
                                                            $other_fees[$label] = $amount;
                                                        }
                                                    }
                                                }
                                            ?>
                                            <?php foreach($other_fees as $label => $amount): ?>
                                                <th><?= htmlspecialchars($label); ?></th>
                                            <?php endforeach; ?>
                                            <th>Total</th>
                                            <?php
                                                if ($row['paid'] != 0) {
                                                    echo '<th>Paid</th>';
                                                    echo '<th>Rest Dues</th>';
                                                }
                                            ?>
                                            <th>Demand</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?= $row['reg_no']; ?></td>
                                            <td><span style="text-transform: capitalize;"><?= $row['name']; ?></span></td>
                                            <td><span style="text-transform: capitalize;"><?= number_format($row['tution_fee'], 2); ?></span></td>
                                            <td><span style="text-transform: capitalize;"><?= number_format($row['transport_and_other_fee'], 2); ?></span></td>
                                             <?php foreach($other_fees as $label => $amount): ?>
                                                <td><?= number_format((float)$amount, 2); ?></td>
                                            <?php endforeach; ?>
                                            <td><span style="text-transform: capitalize;"><?= number_format($row['total'], 2); ?></span></td>
                                            <?php
                                                if($row['paid'] != 0){
                                                     echo '<td>' . number_format($row['paid'], 2) . '</td>';
                                                      echo '<td>' . number_format($row['rest_dues'], 2) . '</td>';
                                                }
                                            ?>
                                            <td><?= $row['month_year']; ?></td>
                                            <td>
                                                <?php
                                                    if($row['status'] == 0){
                                                        $status = '<span class="badge rounded-pill text-bg-danger">Pending</span>';
                                                    }else if($row['status'] == 1){
                                                        $status = '<span class="badge rounded-pill text-bg-warning">Partially Paid</span>';
                                                    }else if($row['rest_dues'] == 0 AND $row['paid'] != 0){
                                                        $status = '<span class="badge rounded-pill text-bg-success">Full Paid</span>';
                                                    }else if($row['rest_dues'] < 0){
                                                        $status = '<span class="badge rounded-pill text-bg-primary"><i class="fas fa-check-circle"></i> Advanced Paid</span>';
                                                    }
                                                    echo $status;
                                                ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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