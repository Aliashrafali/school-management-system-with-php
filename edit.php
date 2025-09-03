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
    }else{
        header("Location:invoice-reports.php");
        exit;
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
                <div class="col-12 col-lg-5 col-md-5">
                    <div class="home-title">
                        <a href="" style="font-size: 25px; border-right: 0.1px solid #313131; padding-right: 20px;">Dashboard</a>
                        <a href="javascript:void(0)" style="margin-left: 20px; font-family: 'Exo 2';"><i class="fas fa-rupee-sign" style="padding-right: 5px;"></i> Account Panel</a>
                        <span style="margin-left: 7px; margin-right: 7px; font-weight: 200; font-family: 'Exo 2';"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i></span><span> Edit Demand Bill</span>
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
                                                if ($row['back_dues'] != 0) {
                                                    echo '<th>Back Dues</th>';
                                                }
                                            ?>
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
                                            <?php
                                                if ($row['back_dues'] != 0) {
                                                    echo '<td>' . number_format($row['back_dues'], 2) . '</td>';
                                                }
                                            ?> 
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
                            <form id="editdemand" method="POST">
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                <input type="hidden" name="id" value="<?= $row['demand_id']; ?>">
                                <div class="row payment-form">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="name">Tution Fee</label>
                                            <input type="text" id="tfees" name="tfees" value="<?= $row['tution_fee']; ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="name">Transport & Other Fee</label>
                                            <input type="text" id="name" name="trfee" value="<?= $row['transport_and_other_fee']; ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        </div>
                                    </div>
                                    <?php
                                        if($row['back_dues'] !== 0 && !empty($row['back_dues'])){
                                    ?>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="name">Back Dues</label>
                                                <input type="text" id="backdues" name="backdues" value="<?= $row['back_dues']; ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                            </div>
                                        </div>
                                    <?php
                                        }
                                    ?>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="name">Other Fee</label>
                                            <?php
                                                $other_fee = $row['other_fee'];
                                                $other_fee = str_replace(["\r\n", "\n", "\r"], ",", $other_fee);
                                                $fee_items = explode(",", $other_fee);
                                                $fees = [];
                                                foreach ($fee_items as $item) {
                                                    $item = trim($item); // "Exam Fee 100"
                                                    if ($item == "") continue;

                                                    // last word ko amount maan lo, baaki title
                                                    $parts = explode(" ", $item);
                                                    $amount = array_pop($parts); // last element = amount
                                                    $title  = implode(" ", $parts);

                                                    $fees[] = ["title" => $title, "amount" => $amount];
                                                }
                                            ?>
                                                <div id="fee-container">
                                                    <?php foreach ($fees as $fee): ?>
                                                        <div style="display:flex; gap:10px; margin-bottom:5px;" class="fee-row">
                                                            <input type="text" name="title[]" value="<?= htmlspecialchars($fee['title']) ?>" class="form-control" placeholder="Title">
                                                            <input type="number" name="amount[]" value="<?= htmlspecialchars($fee['amount']) ?>" class="form-control" placeholder="Amount">
                                                            <button type="button" class="btn btn-danger remove-fee">X</button>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                                <button type="button" class="btn btn-primary" id="add-fee" style="background-color: #4300ff!important; margin-top: 10px;">+ Add Fee</button>
                                            <?php
                                               
                                            ?>
                                        </div>
                                    </div>                  
                                </div>
                                <div class="row pb-2">
                                    <div class="col-12">
                                        <div style="display: block; float: right;">
                                            <button type="submit" class="btn btn-primary btn-sm" style="background-color:#091057; border-radius: 5px;">
                                                <i class="fas fa-file-invoice" style="padding-right: 5px;"></i> Edit Demand Bill
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
<!--Form Submit Code here -->
<script>
    document.getElementById('editdemand').addEventListener("submit", async function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        try {
            const response = await fetch("api/account/editdemand.php", {
                method:"POST",
                body:formData
            });
            const result = await response.json();
            console.log("Server Response:", result);
            if(result.success){
                alert(result.message);
            }else{
                alert("Something Went Wrong Try Agian.");
            }
        } catch (error) {
            console.error("Catch Error:", error);
            alert("Something Went Wrong");
        }
    });
</script>
<!--end here -->

<script>
document.getElementById('add-fee').addEventListener('click', function() {
    let container = document.getElementById('fee-container');
    // for create new div
    let div = document.createElement('div');
    div.className = "fee-row";
    div.style = "display:flex; gap:10px; margin-bottom:5px;";

    div.innerHTML = `
        <input type="text" name="title[]" class="form-control" placeholder="Title">
        <input type="number" name="amount[]" class="form-control" placeholder="Amount">
        <button type="button" class="btn btn-danger remove-fee">X</button>
    `;

    container.appendChild(div);
});

// for remove div
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-fee')) {
        e.target.parentElement.remove();
    }
});
</script>

<?php
    include 'include/footer.php';
?>