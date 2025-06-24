function Profile(){
    if(document.getElementById('profile').style.display == 'block'){
        document.getElementById('profile').style.display = 'none';
    }else{
        document.getElementById('profile').style.display = 'block';
    }
}

// counter
const counters = document.querySelectorAll('.num');
  counters.forEach(counter => {
    const target = +counter.getAttribute('data-target');
    let count = 0;
    const speed = 50; // smaller is faster
    const updateCount = () => {
      const increment = Math.ceil(target / speed);
      if (count < target) {
        count += increment;
        counter.innerHTML = count + ' ';
        setTimeout(updateCount, 20);
      } else {
        counter.innerHTML = target + ' ';
      }
    };
    updateCount();
  });


// registration form validation
function validateRegistration(){
    let name = document.getElementById('name');
    let fname = document.getElementById('fname');
    let mname = document.getElementById('mname');
    let dob = document.getElementById('dob');
    let mobile = document.getElementById('mobile');
    let email = document.getElementById('email');
    let bgroup = document.getElementById('bgroup');
    let radhar = document.getElementById('radhar'); 
    let religion = document.getElementById('religion');
    let category = document.getElementById('category');
    let image = document.getElementById('image');
    let address = document.getElementById('address');
    let present = document.getElementById('present-address');
    let registration = document.getElementById('registration');
    let registration_date = document.getElementById('registration_date');
    let registration_fee = document.getElementById('registration_fee');
    let session = document.getElementById('session');

    if(!name.value){
      alert("Enter Name !");
      name.focus();
      return false;
    }else if(!fname.value){
      alert("Enter Father's Name !");
      fname.focus();
      return false;
    }else if(!mname.value){
      alert("Enter Mother's Name !");
      mname.focus();
      return false;
    }else if(!dob.value){
      alert("Enter Date of Birth !");
      dob.focus();
      return false;
    }else if(!mobile.value){
      alert("Enter Mobile Number !");
      mobile.focus();
      return false;
    }else if(mobile.value.length !== 10){
      alert("Enter Valid Mobile Number");
      mobile.focus();
      return false;
    }else if(!email.value){
      alert("Enter Email Id");
      email.focus();
      return false;
    }else if(!bgroup.value){
      alert("Enter Blood Group !");
      bgroup.focus();
      return false;
    }else if(!radhar.value){
      alert("Enter Aadhar Number !");
      radhar.focus();
      return false;
    }else if(radhar.value.length !== 14){
      alert("Enter Valid Aadhar Number !");
      radhar.focus();
      return false;
    }else if(!religion.value){
      alert("Select Religion !");
      religion.focus();
      return false;
    }else if(!category.value){
      alert("Select Category !");
      category.focus();
      return false;
    }else if(!image.value){
      alert("Upload image !");
      image.focus();
      return false;
    }else if(!address.value){
      alert("Enter Address !");
      address.focus();
      return false;
    }else if(!present.value){
      alert("Enter Present Address !");
      present.focus();
      return false;
    }else if(!registration.value){
      alert("Select Class !");
      registration.focus();
      return false;
    }else if(!registration_date.value){
      alert("Enter Registration Date !");
      registration_date.focus();
      return false;
    }else if(!registration_fee.value){
      alert("Enter Registration Fee !");
      registration_fee.focus();
      return false;
    }else if(!session.value){
      alert("Enter Session !");
      session.focus();
      return false;
    }
    return true;
}

// address same code
function copyAddress() {
    const isChecked = document.getElementById('same-address').checked;
    const permanent = document.getElementById('address').value;
    const present = document.getElementById('present-address');

    if (isChecked) {
        present.value = permanent;
    } else {
        present.value = '';
    }
}

// registration aadhar validation
document.getElementById('radhar').addEventListener('input', function(e){
    let value = e.target.value;
    value = value.replace(/\D/g, '');
    value = value.substring(0, 12);
    value = value.replace(/(.{4})/g, '$1 ').trim();
    e.target.value = value;
})

// registration image validation
function validateRegistrationImage(){
    let imageInput = document.getElementById('image');
    const file = imageInput.files[0];
    const preview = document.getElementById('image-preview');
    if(file){
      const filename = file.name;
      const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
      if(!allowedExtensions.test(filename)){
        alert("Only .jpg, .jpeg, and .png files are allowed!");
        imageInput.value = "";
        preview.style.display = "none";
        return false;
      }
      const reader = new FileReader();
        reader.onload = function(e) {
        preview.src = e.target.result;
        preview.style.display = "block";
      }
      reader.readAsDataURL(file);
    }else {
      preview.src = "#";
      preview.style.display = "none";
    } 
}

// fees calculation start
function Bill(){
    let tution_fee = Number(document.getElementById('tution_fee').value);
    let tranport_fee = Number(document.getElementById('tranport_fee').value);
    let total = tution_fee + tranport_fee;

    document.getElementById('total').value = total;
}

//admission form validation start
function valiDateForm(){
    let name = document.getElementById('name');
    let fname = document.getElementById('fname');
    let mname = document.getElementById('mname');
    let dob = document.getElementById('dob');
    let mobile = document.getElementById('mobile');
    let email = document.getElementById('email');
    let bgroup = document.getElementById('bgroup');
    let adhar = document.getElementById('adhar');
    let religion = document.getElementById('religion');
    let category = document.getElementById('category');
    let image = document.getElementById('image');
    let address = document.getElementById('address');
    let sclass = document.getElementById('class');
    let section = document.getElementById('section');
    let a_date = document.getElementById('a_date');
    let roll = document.getElementById('roll');
    let tution_fee = document.getElementById('tution_fee');
    let tranport_fee = document.getElementById('tranport_fee');
    let total = document.getElementById('total');
    let month_years = document.getElementById('month_years');

    if(!name.value){
      alert("Enter Name !");
      name.focus();
      return false;
    }else if(!fname.value){
      alert("Enter Father's Name !");
      fname.focus();
      return false;
    }else if(!mname.value){
      alert("Enter Monther's Name !");
      mname.focus();
      return false;
    }else if(!dob.value){
      alert("Enter Date of Birth !");
      dob.focus();
      return false;
    }else if(!mobile.value){
      alert("Enter Mobile Number !");
      mobile.focus();
      return false;
    }else if(mobile.value.trim().length !== 10){
      alert("Enter Valid Mobile No !");
      mobile.focus();
      return false;
    }else if(!email.value){
      alert("Enter Email Id !");
      email.focus();
      return false;
    }else if(!bgroup.value){
      alert("Enter Blood Group !");
      bgroup.focus();
      return false;
    }else if(!adhar.value){
      alert("Enter Adhar Number !");
      adhar.focus();
      return false;
    }else if(adhar.value.trim().length !== 14){
      alert("Enter Valid Adhar No. !");
      adhar.focus();
      return false;
    }else if(!religion.value){
      alert("Select Religion !");
      religion.focus();
      return false;
    }else if(!category.value){
      alert("Select Category !");
      category.focus();
      return false;
    }else if(!image.value){
      alert("Upload Image");
      image.focus();
      return false;
    }
    return true;
}

// adhar varified
document.getElementById('adhar').addEventListener('input', function(e){
    let value = e.target.value;
    value = value.replace(/\D/g, '');
    value = value.substring(0, 12);
    value = value.replace(/(.{4})/g, '$1 ').trim();
    e.target.value = value;
});

// image validation
function validateImage(){
  let imageInput = document.getElementById('image');
  const file = imageInput.files[0];
  if(file){
    const filename = file.name;
    const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
    if(!allowedExtensions.test(filename)){
      alert("Only .jpg, .jpeg, and .png files are allowed!");
      imageInput.value = "";
      return false;
    }
  }
}

// toast//
function showToast(message, isError = false) {
    const toast = document.getElementById('toast');
    toast.className = 'toast ' + (isError ? 'error' : 'success') + ' show';
    toast.textContent = message;

    // Hide after 3 seconds
    setTimeout(() => {
        toast.className = 'toast';
    }, 3000);
}
