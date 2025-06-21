<?php
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
                        <a href="student" style="margin-left: 20px; font-family: 'Exo 2';"><i class="fas fa-user" style="padding-right: 5px;"></i> Student Panel</a>
                        <span style="margin-left: 7px; margin-right: 7px; font-weight: 200; font-family: 'Exo 2';"><i class="fas fa-angle-right"></i><i class="fas fa-angle-right"></i></span><span>Add Student</span>
                    </div>
                </div> 
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid">
            <form action="">
                <div class="row">
                    <div class="col-12">
                        <div class="student-view">
                            <span>Student Admission Form</span><hr>
                            <div class="personal-details">
                                <span>Personal Details ( व्यक्तिगत विवरण ) ---</span><hr>
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Name ( विद्यार्थी का नाम )<sup><span style="color: red;">*</span></sup></label>
                                            <input type="text" name="name" class="form-control" id="name" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" aria-describedby="emailHelp" placeholder="Enter Student's Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Father's Name ( विद्यार्थी के पिता का नाम ) <sup><span style="color: red;">*</span></sup></label>
                                            <input type="text" name="fname" class="form-control" id="fname" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" aria-describedby="emailHelp" placeholder="Enter Father's Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Mother's Name ( विद्यार्थी के माता का नाम )<sup><span style="color: red;">*</span></sup></label>
                                            <input type="text" name="mname" class="form-control" id="mname" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" aria-describedby="emailHelp" placeholder="Enter Mother's Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Date of Birth ( जन्मतिथि )<sup><span style="color: red;">*</span></sup></label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-primary text-white"><i class="fas fa-calendar-alt"></i></span>
                                                <input type="date" name="dob" class="form-control" id="dob" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Mobile No. ( दूरभाष संख्या ) <sup><span style="color: red;">*</span></sup></label>
                                            <div class="input-group">
                                                <input type="text" name="mobile" class="form-control" id="mobile" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Enter Your Mobile No." required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Alt. Mobile No. ( वैकल्पिक मोबाइल नंबर )</label>
                                            <div class="input-group">
                                                <input type="text" name="altmobile" class="form-control" id="altmobile" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Enter Your Alt. Mobile No." required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Email Id ( ईमेल आईडी )<sup><span style="color: red;">*</span></sup></label>
                                            <div class="input-group">
                                                <input type="email" name="email" class="form-control" id="email" placeholder="Enter Your Email Id" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Blood Group ( रक्त समूह )<sup><span style="color: red;">*</span></sup></label>
                                            <div class="input-group">
                                                <input type="text" name="bgroup" class="form-control" id="bgroup" oninput="this.value = this.value.replace(/[^a-zA-Z+-]/g, '')" placeholder="Eg: A,A+,B,B+, etc." required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Aadhar Number ( आधार संख्या )<sup><span style="color: red;">*</span></sup></label>
                                            <div class="input-group">
                                                <input type="text" name="adhar" class="form-control" id="adhar" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Enter 12 Digit Adhar No." required>
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
                                            <label for="dob" class="form-label">Religion ( धर्म )<sup><span style="color: red;">*</span></sup></label>
                                            <select class="form-select" name="religion" aria-label="Default select example" required>
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
                                            <label for="dob" class="form-label">Category ( श्रेणी )<sup><span style="color: red;">*</span></sup></label>
                                            <select class="form-select" name="category" aria-label="Default select example" required>
                                                <option disabled selected value="">--Select category--</option>
                                                <option value="sc">Scheduled Caste (SC)</option>
                                                <option value="st">Scheduled Tribe (ST)</option>
                                                <option value="obc">Other Backward Class (OBC)</option>
                                                <option value="ebc">Economically Backward Class (EBC)</option>
                                                <option value="bci">Backward Class I (BC-I)</option>
                                                <option value="bcii">Backward Class II (BC-II)</option>
                                                <option value="general">General</option>
                                                <option value="ews">Economically Weaker Section (EWS)</option>
                                                <option value="other">Other</option>
                                                <option value="prefer_not_say">Prefer not to say</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="dob" class="form-label">Image ( विद्यार्थी का फोटो )<sup><span style="color: red;">*</span></sup></label>
                                            <div class="input-group">
                                                <input type="file" name="image" class="form-control" id="image" style="text-transform: capitalize!important;" required>
                                            </div>
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
                                                    <textarea name="parmanent_address" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="address">
                                            <div class="mb-3">
                                                <label for="dob" class="form-label">Present Address ( वर्तमान पता )<sup><span style="color: red;">*</span></sup>
                                                <span> if Both are Same then </span>
                                                <input type="checkbox" name="check">
                                            </label>
                                                <div class="input-group">
                                                    <textarea name="present_address" class="form-control"></textarea>
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
                                             <select class="form-select" name="class" aria-label="Default select example" required>
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
                                            <label for="exampleInputEmail1" class="form-label">Section ( अनुभाग )<sup><span style="color: red;">*</span></sup></label>
                                             <select class="form-select" name="section" aria-label="Default select example" required>
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
                                    <div class="col-lg-3 col-md-6 col-sm-12">
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
                                    <div class="col-lg-3 col-md-6 col-sm-12">
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
                                                <select class="form-select" name="month_years" aria-label="Default select example" required>
                                                    <option value="A">2000</option>
                                                    <option value="B">2001</option>
                                                    <option value="C">2002</option>
                                                    <option value="D">2003</option>
                                                    <option value="E">2004</option>
                                                    <option value="F">2005</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3 student-btn">
                                <div class="col-12">
                                    <div style="display: block; text-align: center;">
                                        <input type="reset" value="Reset">
                                        <input type="submit" name="ok" value="Submit">
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

<?php
    include 'include/footer.php';
?>