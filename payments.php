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
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // generate token
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
                                                    if($row['paid'] == 0){
                                                        $status = '<span class="badge rounded-pill text-bg-danger"><i class="fa fa-times-circle"></i> Pending</span>';
                                                    }else if($row['paid'] > 0 AND $row['rest_dues'] > 0 ){
                                                        $status = '<span class="badge rounded-pill text-bg-warning"><i class="fa-solid fa-circle-half-stroke"></i> Partially Paid</span>';
                                                    }else if($row['rest_dues'] == 0 AND $row['paid'] !== 0){
                                                        $status = '<span class="badge rounded-pill text-bg-success"><i class="fas fa-check-circle"></i> Full Paid</span>';
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
                            <form id="payments" method="POST">
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                <input type="hidden" name="reg_no" value="<?= $row['reg_no']; ?>">
                                <input type="hidden" name="month_year" value="<?= $row['month_year']; ?>">
                                <input type="hidden" name="sid" value="<?= $row['id']; ?>">
                                <input type="hidden" name="id" value="<?= $row['demand_id']; ?>">
                                <input type="hidden" id="tuition_fee" value="<?= $row['tution_fee']; ?>">
                                <input type="hidden" id="transport_fee" value="<?= $row['transport_and_other_fee']; ?>">
                                <?php
                                    if($row['paid'] == 0){
                                ?>
                                    <input type="hidden" name="totalamount" id="totalamount" value="<?= $row['total']; ?>">
                                <?php
                                    }else{
                                ?>
                                    <input type="hidden" name="totalamount" id="total" value="<?= $row['rest_dues']; ?>">
                                <?php
                                    }
                                ?>
                                <?php
                                    $totalForCalc = ($row['paid'] == 0) ? $row['total'] : $row['rest_dues'];
                                ?>
                                <input type="hidden" id="totalcal" value="<?= $totalForCalc ?>">

                                <div class="row payment-form">
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="name">Total Amount</label>
                                            <?php
                                                if ($row['paid'] == 0) {
                                            ?>
                                                <input type="text" id="name" name="amount" value="<?= number_format($row['total'],2); ?>" required readonly>
                                            <?php
                                                } else {
                                            ?>
                                                <input type="text" id="name" name="amount" value="<?= number_format($row['rest_dues'], 2); ?>" required readonly>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="name">Advanced Month</label>
                                            <select name="adv_month" id="adv_month">
                                                <?php
                                                    for($i = 0; $i <= 12; $i++) {
                                                        echo "<option value=\"$i\">$i</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="name">Advanced Amount</label>
                                            <input type="text" id="adv_amount" name="adv_amount" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="name">Discount</label>
                                            <input type="text" id="discount" name="discount" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="name">Grant Total</label>
                                            <?php
                                                if ($row['paid'] == 0) {
                                            ?>
                                                <input type="text" id="grant_total" name="grant_total" value="<?= number_format($row['total'],2); ?>" required readonly>
                                            <?php
                                                } else {
                                            ?>
                                                <input type="text" id="grant_total" name="grant_total" value="<?= number_format($row['rest_dues'], 2); ?>" required readonly>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="name">Paid Amount</label>
                                            <input type="text" id="paid" name="paid" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="name">Rest Dues</label>
                                            <input type="text" id="rest_dues" name="rest_dues" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="name">Payment By</label>
                                            <select name="payment_by" id="payment_by" onchange="paidBy()" required>
                                                <option disabled selected value="">--Select--</option>
                                                <?php
                                                    $paymentby = [
                                                        "payment" => ['bank', 'upi', 'cash', 'check', 'other']
                                                    ];
                                                    foreach($paymentby['payment'] as $payment){
                                                        echo "<option value=\"$payment\">$payment</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="bank">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="name">Bank Name</label>
                                                    <select name="bankname" id="bankname">
                                                        <option disabled selected value="">--Select--</option>
                                                        <?php
                                                            $bank = [
                                                                "bankname" => [
                                                                    'State Bank of India',
                                                                    'Punjab National Bank',
                                                                    'Bank of Baroda',
                                                                    'Canara Bank',
                                                                    'Union Bank of India',
                                                                    'Indian Bank',
                                                                    'Bank of India',
                                                                    'UCO Bank',
                                                                    'Indian Overseas Bank',
                                                                    'Central Bank of India',
                                                                    'Bank of Maharashtra',
                                                                    'Punjab & Sind Bank',
                                                                    'HDFC Bank',
                                                                    'ICICI Bank',
                                                                    'Axis Bank',
                                                                    'Kotak Mahindra Bank',
                                                                    'IndusInd Bank',
                                                                    'Yes Bank',
                                                                    'IDFC FIRST Bank',
                                                                    'Federal Bank',
                                                                    'South Indian Bank',
                                                                    'Bandhan Bank',
                                                                    'RBL Bank',
                                                                    'CSB Bank',
                                                                    'DCB Bank',
                                                                    'City Union Bank',
                                                                    'Karur Vysya Bank',
                                                                    'Karnataka Bank',
                                                                    'Tamilnad Mercantile Bank',
                                                                    'Jammu & Kashmir Bank',
                                                                    'Nainital Bank',
                                                                    'AU Small Finance Bank',
                                                                    'Equitas Small Finance Bank',
                                                                    'Ujjivan Small Finance Bank',
                                                                    'Suryoday Small Finance Bank',
                                                                    'ESAF Small Finance Bank',
                                                                    'Jana Small Finance Bank',
                                                                    'North East Small Finance Bank',
                                                                    'Capital Small Finance Bank',
                                                                    'Fincare Small Finance Bank',
                                                                    'Utkarsh Small Finance Bank',
                                                                    'Shivalik Small Finance Bank',
                                                                    'DBS Bank',
                                                                    'Standard Chartered Bank',
                                                                    'HSBC Bank',
                                                                    'Barclays Bank',
                                                                    'Deutsche Bank',
                                                                    'JP Morgan Chase',
                                                                    'Bank of America',
                                                                    'BNP Paribas',
                                                                    'United Overseas Bank',
                                                                ]
                                                            ];
                                                            foreach($bank['bankname'] as $bankname){
                                                                echo "<option value=\"$bankname\">$bankname</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="name">Account No.</label>
                                                    <input type="text" id="account" name="acc_no" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="name">Branch</label>
                                                    <input type="text" id="branch" name="branch" oninput="this.value = this.value.replace(/[^a-zA-Z ]/g, '')">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="name">IFSC Code.</label>
                                                    <input type="text" id="ifsc" name="ifsc" style="text-transform: uppercase;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--upi-->
                                    <div id="upi">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="name">UPI Number</label>
                                                    <input type="text" id="upiid" name="upi">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Check-->
                                    <div id="check">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="name">Check Number</label>
                                                    <input type="text" id="checkno" name="check">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--other-->
                                    <div id="other">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="name">Enter Name of the Payment Method</label>
                                                    <input type="text" id="othermethod" name="other">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row pb-2">
                                    <div class="col-12">
                                        <div style="display: block; float: right;">
                                            <button type="submit" onclick="return validatePayments()" class="btn btn-primary btn-sm" style="background-color:#091057; border-radius: 5px;">
                                                <i class="fas fa-file-invoice" style="padding-right: 5px;"></i> Submit and Generate Receipt
                                            </button>
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
<!--Fees Calculation start-->
<script>
    const tuition = parseFloat(document.getElementById('tuition_fee').value) || 0;
    const transport = parseFloat(document.getElementById('transport_fee').value) || 0;
    const total = parseFloat(document.getElementById('totalcal').value) || 0;

    const advMonth = document.getElementById('adv_month');
    const advAmount = document.getElementById('adv_amount');
    const discount = document.getElementById('discount');
    const grantTotal = document.getElementById('grant_total');
    const paid = document.getElementById('paid');
    const restDues = document.getElementById('rest_dues');

    let isManualAdv = false;

    function calculateAdvAmount() {
        if (!isManualAdv) {
            const adv = parseInt(advMonth.value) || 0;
            const advAmt = adv * (tuition + transport);
            advAmount.value = advAmt;
        }
    }

    function calculateAll() {
        calculateAdvAmount();

        const advAmt = parseFloat(advAmount.value) || 0;
        const dis = parseFloat(discount.value) || 0;
        const paidAmount = parseFloat(paid.value) || 0;

        const grand = (total + advAmt) - dis;
        grantTotal.value = grand.toFixed(2);

        const dues = grand - paidAmount;
        restDues.value = dues.toFixed(2);
    }

    advMonth.addEventListener('change', () => {
        isManualAdv = false;
        calculateAll();
    });

    advAmount.addEventListener('input', () => {
        isManualAdv = true;
        calculateAll();
    });

    discount.addEventListener('input', calculateAll);
    paid.addEventListener('input', calculateAll);
</script>

<!--Form Submit Code here -->
<script>
    let payments = document.getElementById('payments');
    payments.addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(payments);
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }
        try{
            const response = await fetch('api/account/payments.php',{
                method:'POST',
                body:formData
            });
            console.log("Raw Response", response);
            const result = await response.json();
            console.log("Parsed JSON", result);
            
            if(result.success){
                alert(result.message);
                window.open("print-reciept.php?invoice_no="+result.invoice_no, "_blank");
                setTimeout((function(){
                    window.location.reload();
                }), 3000);
            }else{
                alert(result.message);
                setTimeout((function(){
                    window.location.reload();
                }), 3000);
            }
        }catch(error){
            alert("Something Went Wrong");
            console.error(error);
        }
    });
</script>
<!--end here -->

<?php
    include 'include/footer.php';
?>