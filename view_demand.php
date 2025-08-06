<?php
    date_default_timezone_set('Asia/Kolkata');
    include 'sql/config.php';
    include 'include/header.php';
    session_start();
    if(isset($_GET['demand_id']) && isset($_GET['month_year'])){
        $demand_id = $_GET['demand_id'];
        $month_year = urldecode($_GET['month_year']);
    }
   $sql = $conn->prepare("
        SELECT 
            tbl_payments.*,
            tbl_demand.session AS demand_session,
            tbl_demand.month_year AS demand_month_year
        FROM tbl_payments
        INNER JOIN tbl_demand 
            ON tbl_payments.demand_id = tbl_demand.id 
            AND tbl_payments.month_year = tbl_demand.month_year
        WHERE tbl_payments.demand_id = ? 
        AND tbl_payments.month_year = ? 
    ");
    $sql->bind_param('is', $demand_id, $month_year);
    $sql->execute();
    $result = $sql->get_result();
    $data = [];
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }
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
                        <span style="margin-left: 7px; margin-right: 7px; font-weight: 200; font-family: 'Exo 2';"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i></span><span> Invoice and Reports</span>
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
                        <div class="title-area">
                            <?php
                                $fetch = $conn->prepare("
                                    SELECT 
                                    registration.*,
                                    tbl_demand.student_id,
                                    tbl_demand.reg_no,
                                    tbl_demand.month_year
                                    FROM tbl_demand INNER JOIN registration ON registration.id = tbl_demand.student_id AND registration.reg_no = tbl_demand.reg_no
                                    WHERE tbl_demand.id = ?
                                ");
                                $fetch->bind_param('i', $demand_id);
                                $fetch->execute();
                                $fetch_result = $fetch->get_result();
                                if($fetch_result->num_rows > 0){
                                    $row_fetch = $fetch_result->fetch_assoc();
                                }
                            ?>
                            <h5 style="font-size: 17px; padding-top: 3px;">
                                Month - [ <?= $row_fetch['month_year']; ?> ]
                            </h5>
                            <span>
                               Name - <?= ucwords($row_fetch['name']); ?>
                            </span>
                            <span>
                               Reg. No. - <?= $row_fetch['reg_no']; ?>
                            </span>
                            <span>
                               Session - <?= $row_fetch['session']; ?>
                            </span>
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="display table-responsive nowrap table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sno.</th>
                                        <th>INV. No</th>
                                        <th>Date and Time</th>
                                        <th>Total</th>
                                         <th>Advance Month</th>
                                        <th>Advance Amount</th>
                                        <th>Discount</th>
                                        <th>Grand Total</th>
                                        <th>Paid</th>
                                        <th>Dues</th>
                                        <th>Paid By</th>
                                        <?php
                                           if(count($data) > 0){
                                                $paidBy = $data[0]['paid_by'];
                                                if($paidBy == 'online'){
                                                    echo '<th>Transaction Id</th>';
                                                } elseif($paidBy == 'cash'){
                                                    echo '<th>Reference</th>';
                                                } elseif($paidBy == 'check'){
                                                    echo '<th>Check No.</th>';
                                                }
                                           }
                                        ?>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i=1;
                                        foreach($data as $row){
                                    ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $row['invoice_no']; ?></td>
                                            <td>
                                                <?php
                                                    $date = $row['date_and_time'];
                                                    $org_date = date('d-m-Y h:i:s A', strtotime($date));
                                                    echo $org_date;
                                                ?>
                                            </td>
                                            <td><?= number_format($row['total_amount'],2); ?></td>
                                            <td>
                                                <?php
                                                    if(!empty($row['no_of_advance_month']) || $row['no_of_advance_month'] != 0){
                                                        echo $row['no_of_advance_month'];
                                                    }else{
                                                        echo '0';
                                                    }
                                                ?>
                                            </td> 
                                            <td>
                                                <?php
                                                    if(!empty($row['advance_amount']) || $row['advance_amount'] != 0){
                                                        echo number_format($row['advance_amount'],2);
                                                    }else{
                                                        echo '0.00';
                                                    }
                                                ?>
                                            </td> 
                                             <td>
                                                <?php
                                                    if(!empty($row['discount_amount']) || $row['discount_amount'] != 0){
                                                        echo number_format($row['discount_amount'],2);
                                                    }else{
                                                        echo '0.00';
                                                    }
                                                ?>
                                            </td> 
                                            <td><?php echo number_format($row['grant_total'], 2); ?></td>
                                            <td><?php echo number_format($row['paid_amount'], 2); ?></td>
                                            <td>
                                                <?php 
                                                    echo number_format($row['rest_dues'], 2); 
                                                ?>
                                            </td>
                                            <td><?= $row['paid_by']; ?></td>
                                            <?php
                                                if($row['paid_by'] == 'online'){
                                                    echo '<td>'.$row['transaction_id'].'</td>';
                                                }else if($row['paid_by'] == 'cash'){
                                                     echo '<td>'.$row['payment_by'].'</td>';
                                                }else if($row['paid_by'] == 'check'){
                                                    echo '<td>'.$row['check_no'].'</td>';
                                                }
                                            ?>
                                            <td>
                                                <a href="#?=<?php echo $row['id']; ?>"><span class="badge rounded-pill text-bg-primary">Edit</span></a>
                                            </td>
                                        </tr>
                                    <?php
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