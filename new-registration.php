<?php
    session_start();
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    include 'include/header.php';
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
                        <a href="registration" style="margin-left: 20px; font-family: 'Exo 2';"><i class="fas fa-user" style="padding-right: 5px;"></i> Student Registration Panel</a>
                        <span style="margin-left: 7px; margin-right: 7px; font-weight: 200; font-family: 'Exo 2';"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i></span><span>New Registration</span>
                    </div>
                </div> 
            </div>
        </div>
    </section>
    <section>
        <div id="toast" class="toast hidden"></div>
        <div class="container-fluid">
            <form id="studentRegistration" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div class="row">
                    <div class="col-12">
                        <div class="student-view">
                            <span>Student Registration Form</span><hr>
                            <div class="personal-details">
                                <span>Personal Details ---</span><hr>
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Name <sup><span style="color: red;">*</span></sup></label>
                                            <input type="text" name="name" class="form-control" id="name" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" aria-describedby="emailHelp" placeholder="Enter Student's Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Father's Name <sup><span style="color: red;">*</span></sup></label>
                                            <input type="text" name="fname" class="form-control" id="fname" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" aria-describedby="emailHelp" placeholder="Enter Father's Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Mother's Name <sup><span style="color: red;">*</span></sup></label>
                                            <input type="text" name="mname" class="form-control" id="mname" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" aria-describedby="emailHelp" placeholder="Enter Mother's Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Date of Birth <sup><span style="color: red;">*</span></sup></label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-primary text-white"><i class="fas fa-calendar-alt"></i></span>
                                                <input type="date" name="dob" class="form-control" id="dob" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Mobile No. <sup><span style="color: red;">*</span></sup></label>
                                            <div class="input-group">
                                                <input type="text" name="mobile" class="form-control" id="mobile" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Enter Your Mobile No." required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Alt. Mobile No. </label>
                                            <div class="input-group">
                                                <input type="text" name="altmobile" class="form-control" id="altmobile" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Enter Your Alt. Mobile No.">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Email Id <sup><span style="color: red;">*</span></sup></label>
                                            <div class="input-group">
                                                <input type="email" name="email" class="form-control" id="email" placeholder="Enter Your Email Id" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Blood Group <sup><span style="color: red;">*</span></sup></label>
                                            <div class="input-group">
                                                <input type="text" name="bgroup" class="form-control" id="bgroup" oninput="this.value = this.value.replace(/[^a-zA-Z+-]/g, '')" placeholder="Eg: A,A+,B,B+, etc." required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Aadhar Number <sup><span style="color: red;">*</span></sup></label>
                                            <div class="input-group">
                                                <input type="text" name="adhar" class="form-control" id="radhar" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Enter 12 Digit Adhar No." required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-12">
                                                <div class="mb-3">
                                                    <label for="gender" class="form-label">Gender <sup><span style="color: red;">*</span></sup></label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                               <div class="radio-group">
                                                <label class="custom-radio">
                                                    <input type="radio" name="gender" value="male" />
                                                    <span class="radio-btn"></span>
                                                    Male 
                                                </label>
                                                <label class="custom-radio">
                                                    <input type="radio" name="gender" value="female" />
                                                    <span class="radio-btn"></span>
                                                    Female 
                                                </label>
                                                <label class="custom-radio">
                                                    <input type="radio" name="gender" value="female" />
                                                    <span class="radio-btn"></span>
                                                    Other 
                                                </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Religion <sup><span style="color: red;">*</span></sup></label>
                                            <select class="form-select" name="religion" id="religion" aria-label="Default select example" required>
                                                <option disabled selected value="">--Select Religion--</option>
                                                <option value="hindu">Hindu</option>
                                                <option value="islam">Islam</option>
                                                <option value="christianity">Christianity</option>
                                                <option value="sikh">Sikh</option>
                                                <option value="buddhism">Buddhism</option>
                                                <option value="jainism">Jainism</option>
                                                <option value="judaism">Judaism</option>
                                                <option value="zoroastrianism">Zoroastrianism</option>
                                                <option value="bahai">Bahai</option>
                                                <option value="taoism">Taoism</option>
                                                <option value="confucianism">Confucianism</option>
                                                <option value="shinto">Shinto</option>
                                                <option value="atheism">Atheism</option>
                                                <option value="agnosticism">Agnosticism</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Category <sup><span style="color: red;">*</span></sup></label>
                                            <select class="form-select" name="category" id="category" aria-label="Default select example" required>
                                                <option disabled selected value="">--Select category--</option>
                                                <option value="sc">Scheduled Caste (SC)</option>
                                                <option value="st">Scheduled Tribe (ST)</option>
                                                <option value="obc">Other Backward Class (OBC)</option>
                                                <option value="ebc">Economically Backward Class (EBC)</option>
                                                <option value="bc-i">Backward Class I (BC-I)</option>
                                                <option value="bc-ii">Backward Class II (BC-II)</option>
                                                <option value="general">General</option>
                                                <option value="ews">Economically Weaker Section (EWS)</option>
                                                <option value="other">Other</option>
                                                <option value="prefer_not_say">Prefer not to say</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Image <sup><span style="color: red;">*</span></sup></label>
                                            <div class="input-group">
                                                <input type="file" name="image" class="form-control" id="image" onchange="validateRegistrationImage()" style="text-transform: capitalize!important;" accept="image/jpg, image/png, image/jpeg" required>
                                            </div>
                                            <div id="preview-container" style="margin-top: 10px;">
                                                <img id="image-preview" src="#" alt="Image Preview" style="max-width: 100px; display: none; border: 1px solid #ccc; padding: 5px; border-radius: 5px;" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <span>Full Address ---</span><hr>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="address">
                                            <div class="mb-3">
                                                <label for="dob" class="form-label">Parmanent Address <sup><span style="color: red;">*</span></sup></label>
                                                <div class="input-group">
                                                    <textarea name="parmanent_address" id="address" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="address">
                                            <div class="mb-3">
                                                <label for="dob" class="form-label">Present Address <sup><span style="color: red;">*</span></sup>
                                                <span> if Both are Same then </span>
                                                <input type="checkbox" id="same-address" name="check" onclick="copyAddress()">
                                            </label>
                                                <div class="input-group">
                                                    <textarea name="present_address" id="present-address" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <span>Registration Details  ---</span><hr>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Class <sup><span style="color: red;">*</span></sup></label>
                                             <select class="form-select" name="class" id="registration" aria-label="Default select example" required>
                                                <option disabled selected value="">--Select Class--</option>
                                                <option value="nur">Nursery</option>
                                                <option value="lkg">LKG (Lower Kindergarten)</option>
                                                <option value="ukg">UKG (Upper Kindergarten)</option>
                                                <option value="1">Class 1</option>
                                                <option value="2">Class 2</option>
                                                <option value="3">Class 3</option>
                                                <option value="4">Class 4</option>
                                                <option value="5">Class 5</option>
                                                <option value="6">Class 6</option>
                                                <option value="7">Class 7</option>
                                                <option value="8">Class 8</option>
                                                <option value="9">Class 9</option>
                                                <option value="10">Class 10</option>
                                                <option value="11">Class 11</option>
                                                <option value="12">Class 12</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Registration Date <sup><span style="color: red;">*</span></sup></label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-primary text-white"><i class="fas fa-calendar-alt"></i></span>
                                                <input type="date" name="registration_date" class="form-control" id="r_date" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Registration Fee<sup><span style="color: red;">*</span></sup></label>
                                            <div class="input-group">
                                                <input type="text" name="registration_fee" class="form-control" id="r_fee" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Enter Registration Fee" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Session<sup><span style="color: red;">*</span></sup></label>
                                            <div class="input-group">
                                                <input type="text" name="session" class="form-control" id="session" placeholder="Eg. 2024-25" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3 student-btn">
                                <div class="col-12">
                                    <div style="display: block; text-align: center;">
                                        <input type="reset" value="Reset">
                                        <input type="submit" name="ok" onclick="return validateRegistration()" value="Submit">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>   
                </div>
            </form>
        </div>
    </section>
</main>

<script>
    // insert
    let studentRegistration = document.getElementById('studentRegistration');
    studentRegistration.addEventListener('submit', async function(e) {
        e.preventDefault();
        if (document.getElementById('same-address').checked) {
            document.getElementById('present-address').value = document.getElementById('address').value;
        }
        const formData = new FormData(studentRegistration);
        try{
            const response = await fetch('api/student_registration/create.php', {
                method : 'POST',
                body:formData
            });
            const result = await response.json();
            showToast(result.message, !result.success);
            setTimeout((function(){
                window.location.reload();
            }), 3000)
        }catch(error){
            alert("Something Went Wrong");
            console.error(error);
        }
    })
</script>

<?php
    include 'include/footer.php';
?>