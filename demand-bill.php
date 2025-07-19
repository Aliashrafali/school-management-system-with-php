<?php
    session_start();
    include 'sql/config.php';
    include 'include/header.php';
    // $fetch = $conn->prepare("
    //     SELECT 
    //     registration.*,
    //     tbl_admission.section,
    //     tbl_admission.admission_date,
    //     tbl_admission.roll,
    //     tbl_admission.tution_fee,
    //     tbl_admission.transport_and_other_fee,
    //     tbl_admission.total,
    //     tbl_admission.month_year,
    //     tbl_admission.status
    //     FROM registration INNER JOIN tbl_admission ON registration.reg_no = tbl_admission.reg_no AND registration.session = tbl_admission.session
    // ");
    // $fetch->execute();
    // $result = $fetch->get_result();

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
                        <span style="margin-left: 7px; margin-right: 7px; font-weight: 200; font-family: 'Exo 2';"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i></span><span> Demand Bill</span>
                    </div>
                </div> 
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="fees-view">
                        <div class="bill-form pt-3">
                            <div class="d-flex justify-content-between">
                                <span><b>Fill The Details --</b></span>
                                <button type="button" onclick="addMore()" class="btn btn-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem; background-color:#091057!important;">Add More</button>
                            </div><hr>
                            <form id="demand-bill">
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Class <sup><span style="color: red;">*</span></sup></label>
                                            <?php
                                                $classArray = [
                                                    "class" => ["nur","lkg","ukg","1", "2", "3", "4", "5","6", "7", "8", "9", "10", "11", "12"]
                                                ];
                                            ?>
                                            <select class="form-select" name="class" id="demand-class" aria-label="Default select example">
                                                <option disabled selected value="">--Select Class--</option>
                                                <?php
                                                    foreach($classArray['class'] as $class){
                                                        echo "<option value=\"$class\">$class</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Section</label>
                                            <?php
                                                $sectionArray = [
                                                    "section" => ["A","B","C","D","E"]
                                                ];
                                            ?>
                                            <select class="form-select" name="section" id="demand-section" aria-label="Default select example">
                                                <option disabled selected value="">--Select Section--</option>
                                                <?php
                                                    foreach($sectionArray['section'] as $section){
                                                        echo "<option value=\"$section\">$section</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="input-container">
                                       
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div style="display: block; float: right;">
                                            <button type="submit" style="background-color:#091057;">Generate</button>
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
    function addMore(){
        const container = document.getElementById("input-container");

        const row = document.createElement("div");
        row.className = "row mb-2";

        // First input - 6 columns
        const col1 = document.createElement("div");
        col1.className = "col-md-6";
        
        const lebel1 = document.createElement('label');
        lebel1.innerText = "Title";
        lebel1.classList.add("form-label", "custom-label");

        const input1 = document.createElement("input");
        input1.classList.add("form-control", "custom-input");
        input1.type = "text";
        input1.name = "title[]";
        input1.placeholder = "Enter Title";
        col1.appendChild(lebel1);
        col1.appendChild(input1);

        input1.addEventListener("input", function () {
            this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
        });


        // Second input - 6 columns
        const label2 = document.createElement('label');
        const col2 = document.createElement("div");
        col2.className = "col-md-6";
        label2.innerText = "Fees";
        label2.classList.add("form-label", "custom-label");

        const input2 = document.createElement("input");
        input2.type = "text";
        input2.name = "fees[]";
        input2.placeholder = "Enter Fees";
        input2.classList.add("form-control", "custom-input");
        col2.appendChild(label2);
        col2.appendChild(input2);
        
        input2.addEventListener("input", function () {
            this.value = this.value.replace(/[^0-9.]/g, '');
            const parts = this.value.split('.');
            if (parts.length > 2) {
                this.value = parts[0] + '.' + parts.slice(1).join('').replace(/\./g, '');
            }
        });

        // Append columns to row
        row.appendChild(col1);
        row.appendChild(col2);

        // Append row to container
        container.appendChild(row);
    }
</script>
<script>
    // send the value
    let bill = document.getElementById('demand-bill');
    bill.addEventListener('submit', async function(e){
        e.preventDefault();

        const formData = new FormData(bill);

        try{
            const response = await fetch('api/account/demand-bill.php', {
                method:'POST',
                body:formData
            });
            const res = await response.json();
            if(res){
                alert(res.message);
                if(res.redirect){
                   const classParams = encodeURIComponent(res.class);
                   const monthParams = encodeURIComponent(res.month_year);
                   let url = `view-bill.php?class=${classParams}&month_year=${monthParams}`;
                   if(res.section && res.section !== ""){
                        const sectionParams = encodeURIComponent(res.section);
                        url += `&section=${sectionParams}`;
                   }
                   if (res.student_ids && res.student_ids.length > 0) {
                        const idsParam = encodeURIComponent(res.student_ids.join(','));
                        url += `&student_ids=${idsParam}`;
                    }
                   window.open(url, '_blank');
                }
                setTimeout(() => {
                    location.reload();
                }, 3000);
            }
        }catch(error){
            alert("Something Went Wrong");
            console.error(error);
        }
    });
</script>
<?php
    include 'include/footer.php';
?>