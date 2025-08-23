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
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
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
                        <a href="student" style="margin-left: 20px; font-family: 'Exo 2';"><i class="fas fa-user" style="padding-right: 5px;"></i> Student Panel</a>
                        <span style="margin-left: 7px; margin-right: 7px; font-weight: 200; font-family: 'Exo 2';"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i></span><span> Admission</span>
                    </div>
                </div> 
            </div>
        </div>
    </section>
    <section>
        <div id="toast1" class="toast1 hidden"></div>
        <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="student-view">
                            <span>Student Admission</span><hr>
                            <div class="row">
                                <div class="col-12">
                                    <div style="display: block; float: right;">
                                        <form action="" method="POST">
                                            <div class="row g-3 align-items-center">
                                                <div class="col-auto">
                                                    <label for="inputPassword6" class="col-form-label">Regsitartion No. : </label>
                                                </div>
                                                <div class="col-auto">
                                                    <input type="text" name="reg_no" id="reg_no" class="form-control" aria-describedby="passwordHelpInline" placeholder="Reg. No..." required>
                                                </div>
                                                <div class="col-auto">
                                                    <label for="inputPassword6" class="col-form-label">Session : </label>
                                                </div>
                                                <div class="col-auto">
                                                    <select name="session" class="form-control" required>
                                                        <option disabled selected value="">--Select Session--</option>
                                                        <?php
                                                            $startDate = 2000;
                                                            $endDate = date('Y');
                                                            $currentSession = $endDate.'-'.substr($endDate + 1, -2);
                                                            for($years = $startDate; $years <= $endDate; $years++){
                                                                $secondDate = substr($years + 1, -2);
                                                                $session = "$years-$secondDate";
                                                                $selected = ($session == $currentSession) ? 'selected' : '';
                                                                echo "<option value='$session' $selected>$session</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-auto">
                                                    <span id="passwordHelpInline" class="form-text">
                                                        <button type="submit" class="btn btn-primary" name="search">Search</button>
                                                    </span>
                                                </div>
                                            </div>
                                            
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <form id="admissionform">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <div class="personal-details">
                                <?php
                                    if(isset($_POST['search'])){
                                        $reg_no = $_POST['reg_no'] ?? '';
                                        $session = $_POST['session'] ?? '';

                                        $search = $conn->prepare("SELECT * FROM registration WHERE reg_no = ? AND session = ?");
                                        $search->bind_param('ss', $reg_no, $session);
                                        $search->execute();
                                        $result = $search->get_result();
                                        if($result->num_rows > 0){
                                            $row = $result->fetch_assoc();
                                        ?>
                                           <span>Personal Details ( व्यक्तिगत विवरण ) ---</span><hr>
                                           <input type="hidden" name="reg_no" value="<?php echo $row['reg_no']; ?>">
                                           <input type="hidden" name="session" value="<?php echo $row['session']; ?>">
                                           <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="exampleInputEmail1" class="form-label">Name ( विद्यार्थी का नाम )<sup><span style="color: red;">*</span></sup></label>
                                                        <input type="text" name="name" class="form-control" id="name" value="<?= $row['name']; ?>" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" aria-describedby="emailHelp" readonly required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="exampleInputEmail1" class="form-label">Father's Name ( विद्यार्थी के पिता का नाम ) <sup><span style="color: red;">*</span></sup></label>
                                                        <input type="text" name="fname" value="<?= $row['fname']; ?>" class="form-control" id="fname" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" aria-describedby="emailHelp" readonly required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="exampleInputEmail1" class="form-label">Mother's Name ( विद्यार्थी के माता का नाम )<sup><span style="color: red;">*</span></sup></label>
                                                        <input type="text" name="mname" value="<?= $row['mname']; ?>" class="form-control" id="mname" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" aria-describedby="emailHelp" readonly required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="dob" class="form-label">Date of Birth ( जन्मतिथि )<sup><span style="color: red;">*</span></sup></label>
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-primary text-white"><i class="fas fa-calendar-alt"></i></span>
                                                            <input type="date" name="dob" value="<?= $row['dob']; ?>" class="form-control" id="dob" readonly required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="dob" class="form-label">Mobile No. ( दूरभाष संख्या ) <sup><span style="color: red;">*</span></sup></label>
                                                        <div class="input-group">
                                                            <input type="text" name="mobile" value="<?= $row['mobile']; ?>" class="form-control" id="mobile" oninput="this.value = this.value.replace(/[^0-9]/g, '')" readonly required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="dob" class="form-label">Alt. Mobile No. ( वैकल्पिक मोबाइल नंबर )</label>
                                                        <div class="input-group">
                                                            <input type="text" name="altmobile" value="<?= $row['altmobile']; ?>" class="form-control" id="altmobile" oninput="this.value = this.value.replace(/[^0-9]/g, '')" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="dob" class="form-label">Email Id ( ईमेल आईडी )<sup><span style="color: red;">*</span></sup></label>
                                                        <div class="input-group">
                                                            <input type="email" name="email" value="<?= $row['email']; ?>" class="form-control" id="email" placeholder="Enter Your Email Id" readonly required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="dob" class="form-label">Blood Group ( रक्त समूह )<sup><span style="color: red;">*</span></sup></label>
                                                        <div class="input-group">
                                                            <input type="text" name="bgroup" value="<?= $row['bgroup']; ?>" class="form-control" id="bgroup" oninput="this.value = this.value.replace(/[^a-zA-Z+-]/g, '')" readonly required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="dob" class="form-label">Aadhar Number ( आधार संख्या )<sup><span style="color: red;">*</span></sup></label>
                                                        <div class="input-group">
                                                            <input type="text" name="adhar" value="<?= wordwrap($row['adhar'], 4, ' ', true); ?>" class="form-control" id="aadhar" oninput="this.value = this.value.replace(/[^0-9]/g, '')" readonly required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                                            <div class="mb-3">
                                                                <label for="gender" class="form-label">Gender ( लिंग )<sup><span style="color: red;">*</span></sup></label>
                                                                <label class="custom-radio">
                                                                    <input type="radio" name="gender" value="<?= $row['gender']; ?>" checked readonly/>
                                                                    <span class="radio-btn"></span>
                                                                    <span style="text-transform: uppercase;"><?= $row['gender']; ?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <?php
                                                        $religion = $row['religion'];
                                                    ?>
                                                    <div class="mb-3">
                                                        <label for="dob" class="form-label">Religion ( धर्म )<sup><span style="color: red;">*</span></sup></label>
                                                        <input type="text" name="religion" class="form-control" value="<?= $row['religion']; ?>" readonly required>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <?php
                                                            $category = $row['category'];
                                                        ?>
                                                        <label for="dob" class="form-label">Category ( श्रेणी )<sup><span style="color: red;">*</span></sup></label>
                                                        <input type="text" name="category" class="form-control" value="<?= $row['category']; ?>" readonly required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="dob" class="form-label">Image ( विद्यार्थी का फोटो )<sup><span style="color: red;">*</span></sup></label><br>
                                                        <img id="previewImage" src="sql/students/<?php echo $row['image']; ?>" alt="sql/students/<?php echo $row['image']; ?>" class="img-thumbnail mt-2" height="100px" width="100px">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <span>Full Address ( सम्पूर्ण पता ) ---</span><hr>
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-sm-12">
                                                    <div class="address">
                                                        <div class="mb-3">
                                                            <label for="dob" class="form-label">Parmanent Address ( स्थायी पता )<sup><span style="color: red;">*</span></sup></label>
                                                            <div class="input-group">
                                                                <textarea name="parmanent_address" id="address" class="form-control" required readonly><?= $row['parmanent_address']; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-sm-12">
                                                    <div class="address">
                                                        <div class="mb-3">
                                                            <label for="dob" class="form-label">Present Address ( वर्तमान पता )</sup>
                                                        </label>
                                                            <div class="input-group">
                                                                <textarea name="present_address" class="form-control" readonly required><?= $row['present_address']; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <span>Admission Details ( नामांकन विवरण ) ---</span><hr>
                                                </div>
                                                <div class="col-lg-3 col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="exampleInputEmail1" class="form-label">Class ( कक्षा )<sup><span style="color: red;">*</span></sup></label>
                                                        <input type="text" name="class" class="form-control" value="<?= $row['class']; ?>" readonly required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="exampleInputEmail1" class="form-label">Section ( अनुभाग )<sup><span style="color: red;">*</span></sup></label>
                                                        <select class="form-select" name="section" id="section" aria-label="Default select example" required>
                                                            <option disabled selected value="">--Select Section--</option>
                                                            <option value="A">Section A</option>
                                                            <option value="B">Section B</option>
                                                            <option value="C">Section C</option>
                                                            <option value="D">Section D</option>
                                                            <option value="E">Section E</option>
                                                            <option value="F">Section F</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="dob" class="form-label">Admission Date ( नामांकन तिथि )<sup><span style="color: red;">*</span></sup></label>
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-primary text-white"><i class="fas fa-calendar-alt"></i></span>
                                                            <input type="date" name="admission_date" class="form-control" id="a_date" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="dob" class="form-label">Roll ( अनुक्रमांक )<sup><span style="color: red;">*</span></sup></label>
                                                        <div class="input-group">
                                                            <input type="text" name="roll" class="form-control" id="roll" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Enter Roll Number" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <span>Fees Details ( शुल्क विवरण ) ---</span><hr>
                                                </div>
                                                <div class="col-lg-2 col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="dob" class="form-label">Tution Fee ( शिक्षण शुल्क )<sup><span style="color: red;">*</span></sup></label>
                                                        <div class="input-group">
                                                            <input type="text" name="tution_fee" class="form-control" id="tution_fee" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Enter Tution Fee" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="dob" class="form-label">Transport & Other Fee ( परिवहन एवं अन्य शुल्क )<sup><span style="color: red;">*</span></sup></label>
                                                        <div class="input-group">
                                                            <input type="text" name="transport_and_other_fee" class="form-control" id="tranport_fee" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Enter Transport & Other Fee" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="dob" class="form-label">Back Dues ( बकाया राशि )<sup><span style="color: red;">*</span></sup></label>
                                                        <div class="input-group">
                                                            <input type="text" name="back_dues" class="form-control" id="back_dues" onchange="Bill()" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Back Dues" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="dob" class="form-label">Total ( कुल )<sup><span style="color: red;">*</span></sup></label>
                                                        <div class="input-group">
                                                            <input type="text" name="total" class="form-control" id="total" required readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6 col-sm-12">
                                                    <div class="mb-3">
                                                        <label for="dob" class="form-label">Month & Years ( माह एवं वर्ष )<sup><span style="color: red;">*</span></sup></label>
                                                        <div class="input-group">
                                                            <?php
                                                                $start = new DateTime('2000-01');
                                                                $end = new DateTime();
                                                                echo '<select class="form-select" id="month_years" name="month_years" required>';
                                                                while($start < $end){
                                                                    $value = $start->format('F Y');
                                                                    $selected = ($value == date('F Y')) ? 'selected' : '';
                                                                    echo "<option value=\"$value\" $selected>$value</option>";
                                                                    $start->modify('+1 month');
                                                                }
                                                                echo '</select>';
                                                            ?>  
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                             <div class="row mt-3 student-btn">
                                                <div class="col-12">
                                                    <div style="display: block; text-align: center;">
                                                        <input type="reset" value="Reset">
                                                        <input type="submit" name="ok" onclick="return valiDateForm()" value="Submit">
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }else{
                                        ?>  
                                            <a href="addstudent.php"><button type="button" class="btn btn-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Back</button></a>
                                            <div style="text-align: center; display: block; padding-bottom: 10px!important;">
                                                <span style="color: red;">Data Not Found First registration Then Admission</span>
                                            </div>
                                        <?php
                                        }
                                    }else{
                                    ?>
                                        <div style="text-align: center; display: block; padding-bottom: 10px!important;">
                                            <span style="color: red;">Search student's record from the registration number and session here. If you are not registered then please register first.
                                                <br>पंजीकरण संख्या और सत्र द्वारा छात्र का रिकॉर्ड खोजें। यदि आपने पंजीकरण नहीं कराया है, तो कृपया पहले पंजीकरण करें।
                                            </span>
                                        </div>  
                                    <?php
                                    }
                                    ?>
                            </form>
                        </div>
                    </div>   
                </div>  
        </div>
    </section>
</main>

<script>
    document.getElementById('admissionform').addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const reg_no = formData.get('reg_no');
        const session = formData.get('session');
        const id = formData.get('id');

        const data = {};
        formData.forEach((value, key) => data[key] = value);

        try{
            const response = await fetch('api/student_admission/create.php', {
                method: 'POST',
                headers : {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const res = await response.json();
            if(res.message){
                showToast1(res.message, !res.success);
                setTimeout((function(){
                    window.location.reload();
                }), 3000);
            }
        }catch(err){
            alert("Something Went Wrong");
            console.error(err);
        }
    });
</script>

<?php
    include 'include/footer.php';
?>