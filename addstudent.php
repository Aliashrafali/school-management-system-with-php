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
                                <span>Personal Details</span><hr>
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
                                            <div class="input-group shadow-sm">
                                                <span class="input-group-text bg-primary text-white"><i class="fas fa-calendar-alt"></i></span>
                                                <input type="date" name="dob" class="form-control" id="dob" required>
                                            </div>
                                        </div>
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