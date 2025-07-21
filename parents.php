<?php
    session_start();
    if(!isset($_SESSION['csrf_token'])) {
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
                        <a href="registration" style="margin-left: 20px; font-family: 'Exo 2';"><i class="fas fa-user" style="padding-right: 5px;"></i> Parents Panel</a>
                        <span style="margin-left: 7px; margin-right: 7px; font-weight: 200; font-family: 'Exo 2';"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i></span><span>Parents</span>
                    </div>
                </div> 
            </div>
        </div>
    </section>
    <section>
        <div id="toast" class="toast hidden"></div>
        <div class="container-fluid">
            <form id="parentDetails" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div class="row">
                    <div class="col-12">
                        <div class="student-view">
                            <span>Fill Parents Details --</span><hr>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="parents-form">
                                        <p>Personal Details</p>
                                        <div class="p-3">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="mb-3 row">
                                                        <label for="inputPassword" class="col-sm-3 col-form-label">Name <sup><span style="color: red;">*</span></sup> : </label>
                                                        <div class="col-sm-9">
                                                        <input type="text" name="name" class="form-control" id="pname" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" aria-describedby="emailHelp" placeholder="Enter Name" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="mb-3 row">
                                                        <label for="inputPassword" class="col-sm-3 col-form-label">Mobile No. <sup><span style="color: red;">*</span></sup> : </label>
                                                        <div class="col-sm-9">
                                                        <input type="text" name="mobile" class="form-control" id="pmobile" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Enter Your Mobile No." required>
                                                        </div>
                                                    </div>
                                                </div>

                                                 <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="mb-3 row">
                                                        <label for="inputPassword" class="col-sm-3 col-form-label">Alt. Mobile No. : </label>
                                                        <div class="col-sm-9">
                                                        <input type="text" name="altmobile" class="form-control" id="paltmobile" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Enter Your Alt. Mobile No.">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="mb-3 row">
                                                        <label for="inputPassword" class="col-sm-3 col-form-label">Email Id : </label>
                                                        <div class="col-sm-9">
                                                        <input type="email" name="email" class="form-control" id="pemail" placeholder="Enter Your Email Id" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="personal-details">
                                <span>Personal Details ---</span><hr>
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label"> Name ( नाम )<sup><span style="color: red;">*</span></sup></label>
                                            <input type="text" name="name" class="form-control" id="pname" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" aria-describedby="emailHelp" placeholder="Enter Name" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Mobile No. ( मोबाइल नंबर ) <sup><span style="color: red;">*</span></sup></label>
                                            <div class="input-group">
                                                <input type="text" name="mobile" class="form-control" id="pmobile" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Enter Your Mobile No." required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Alt. Mobile No. ( वैकल्पिक मोबाइल नंबर ) </label>
                                            <div class="input-group">
                                                <input type="text" name="altmobile" class="form-control" id="paltmobile" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Enter Your Alt. Mobile No.">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Email Id ( इमेल आईडी )<sup><span style="color: red;">*</span></sup></label>
                                            <div class="input-group">
                                                <input type="email" name="email" class="form-control" id="pemail" placeholder="Enter Your Email Id" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Blood Group ( रक्त समूह )<sup><span style="color: red;">*</span></sup></label>
                                            <div class="input-group">
                                                <input type="text" name="bgroup" class="form-control" id="pbgroup" oninput="this.value = this.value.replace(/[^a-zA-Z+-]/g, '')" placeholder="Eg: A,A+,B,B+, etc." required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Aadhar Number ( आधार संख्या )<sup><span style="color: red;">*</span></sup></label>
                                            <div class="input-group">
                                                <input type="text" name="adhar" class="form-control" id="padhar" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Enter 12 Digit Adhar No." required>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Occupation (व्यवसाय )<sup><span style="color: red;">*</span></sup></label>
                                            <select class="form-select" name="occupation" id="occupation" onchange="updateDesignations()" aria-label="Default select example" required>
                                                <option disabled selected value="">--Select Occupation--</option>
                                                <option value="Business">Business</option>
                                                <option value="Government Job">Government Job</option>
                                                <option value="Private Job">Private Job</option>
                                                <option value="Teacher">Teacher</option>
                                                <option value="Engineer">Engineer</option>
                                                <option value="Doctor">Doctor</option>
                                                <option value="Farmer">Farmer</option>
                                                <option value="Lawyer">Lawyer</option>
                                                <option value="Police">Police</option>
                                                <option value="Defense">Defense</option>
                                                <option value="Driver">Driver</option>
                                                <option value="Electrician">Electrician</option>
                                                <option value="Plumber">Plumber</option>
                                                <option value="Mechanic">Mechanic</option>
                                                <option value="Technician">Technician</option>
                                                <option value="Tailor">Tailor</option>
                                                <option value="Beautician">Beautician</option>
                                                <option value="Artist">Artist</option>
                                                <option value="Actor">Actor</option>
                                                <option value="Student">Student</option>
                                                <option value="Housewife">Housewife</option>
                                                <option value="Retired">Retired</option>
                                                <option value="Unemployed">Unemployed</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Designation( पद का नाम )<sup><span style="color: red;">*</span></sup></label>
                                            <select class="form-select" name="designation" id="designation" required>
                                                <option disabled selected value="">--Select Designation--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Department( विभाग )<sup></sup></label>
                                            <div class="input-group">
                                                <input type="text" name="department" class="form-control" id="department" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" placeholder="Enter Department">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-12">
                                                <div class="mb-3">
                                                    <label for="gender" class="form-label">Gender ( लिंग )<sup><span style="color: red;">*</span></sup></label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                               <div class="radio-group">
                                                <label class="custom-radio">
                                                    <input type="radio" name="gender" value="male" />
                                                    <span class="radio-btn"></span>
                                                    Male ( पुरुष )
                                                </label>
                                                <label class="custom-radio">
                                                    <input type="radio" name="gender" value="female" />
                                                    <span class="radio-btn"></span>
                                                    Female ( स्त्री )
                                                </label>
                                                <label class="custom-radio">
                                                    <input type="radio" name="gender" value="female" />
                                                    <span class="radio-btn"></span>
                                                    Other ( अन्य ) 
                                                </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Religion ( धर्म ) <sup><span style="color: red;">*</span></sup></label>
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
                                            <label for="dob" class="form-label">Category ( वर्ग )<sup><span style="color: red;">*</span></sup></label>
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
                                            <label for="dob" class="form-label">Number of children  ( बच्चों की संख्या )<sup><span style="color: red;">*</span></sup></label>
                                            <div class="input-group">
                                                <input type="text" name="childnum" class="form-control" id="childnum" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Enter Number of children" required>
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
                                                <label for="dob" class="form-label">Present Address (  वर्तमान पता ) <sup><span style="color: red;">*</span></sup></label>
                                                <div class="input-group">
                                                    <textarea name="present_address" id="address" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="address">
                                            <div class="mb-3">
                                                <label for="dob" class="form-label">Parmanent Address ( स्थायी पता ) <sup><span style="color: red;">*</span></sup>
                                                <span> if Both are Same then </span>
                                                <input type="checkbox" id="same-address" name="check" onclick="copyAddress()">
                                            </label>
                                                <div class="input-group">
                                                    <textarea name="parmanent_address" id="present-address" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row mt-3 student-btn">
                                <div class="col-12">
                                    <div style="display: block; text-align: center;">
                                        <input type="reset" value="Reset">
                                        <input type="submit" name="ok" onclick="return validParents()" value="Submit">
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
<!-- occupation -->
 <script>
    const designationMap = {
        "Business": ["Owner", "Manager", "Sales Executive", "Other"],
        "Government Job": ["Clerk", "Officer", "Manager", "Section Officer", "Other"],
        "Private Job": ["Executive", "Manager", "Team Leader", "Analyst", "Other"],
        "Teacher": ["Primary Teacher", "High School Teacher", "Lecturer", "Professor", "Other"],
        "Engineer": ["Civil Engineer", "Software Engineer", "Mechanical Engineer", "Other"],
        "Doctor": ["General Physician", "Surgeon", "Dentist", "Pediatrician", "Other"],
        "Farmer": ["Land Owner", "Worker", "Tenant Farmer", "Other"],
        "Lawyer": ["Advocate", "Legal Advisor", "Consultant", "Other"],
        "Police": ["Constable", "Head Constable", "SI", "Inspector", "Other"],
        "Defense": ["Soldier", "Commander", "Captain", "Major", "Other"],
        "Driver": ["Car Driver", "Truck Driver", "Bus Driver", "Other"],
        "Electrician": ["Residential", "Commercial", "Industrial", "Other"],
        "Plumber": ["Pipe Fitter", "Maintenance", "Sanitary Worker", "Other"],
        "Mechanic": ["Auto Mechanic", "Bike Mechanic", "Machine Technician", "Other"],
        "Technician": ["Lab Technician", "Computer Technician", "Field Technician", "Other"],
        "Tailor": ["Gents Tailor", "Ladies Tailor", "Designer", "Other"],
        "Beautician": ["Hair Stylist", "Makeup Artist", "Spa Therapist", "Other"],
        "Artist": ["Painter", "Sculptor", "Illustrator", "Other"],
        "Actor": ["Film Actor", "TV Actor", "Theater Artist", "Other"],
        "Student": ["School Student", "College Student", "Research Scholar", "Other"],
        "Housewife": ["Homemaker", "Other"],
        "Retired": ["Retired Govt Employee", "Retired Private Employee", "Other"],
        "Unemployed": ["Looking for Job", "Not Working", "Other"],
        "Other": ["Freelancer", "Self-employed", "Miscellaneous", "Other"]
    };

    function updateDesignations() {
        const occupation = document.getElementById("occupation").value;
        const designationSelect = document.getElementById("designation");
        // Clear previous options
        designationSelect.innerHTML = '<option disabled selected value="">--Select Designation--</option>';

        if (designationMap[occupation]) {
            designationMap[occupation].forEach(function(designation) {
                const option = document.createElement("option");
                option.value = designation;
                option.textContent = designation;
                designationSelect.appendChild(option);
            });
        }
    }
</script>
<!-- occupation end here -->

<script>
    // insert
    let parentDetails = document.getElementById('parentDetails');
    parentDetails.addEventListener('submit', async function(e) {
        e.preventDefault();
        if (document.getElementById('same-address').checked) {
            document.getElementById('present-address').value = document.getElementById('address').value;
        }
        const formData = new FormData(parentDetails);
        try{
            const response = await fetch('api/parents/create.php', {
                method : 'POST',
                body:formData
            });
            const result = await response.json();
            showToast(result.message, !result.success);
            setTimeout(() => {
                window.location.reload();
            }, 3000);
        }catch(error){
            alert("Something Went Wrong");
            console.error(error);
        }
    })
</script>

<?php
    include 'include/footer.php';
?>