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
    let registration_date = document.getElementById('r_date');
    let registration_fee = document.getElementById('r_fee');
    let session = document.getElementById('session');
    let rclass = document.getElementById('rclass');
    let gender = document.querySelector('input[name="gender"]:checked');

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
    }else if(!gender){
      alert("Gender Not Selected !");
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
    }else if(!rclass.value){
      alert("Select Class !");
      rclass.focus();
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
['radhar', 'padhar'].forEach(id => {
    const input = document.getElementById(id);
    if (input) {
        input.addEventListener('input', function(e) {
            let value = e.target.value;
            value = value.replace(/\D/g, '');
            value = value.substring(0, 12);
            value = value.replace(/(.{4})/g, '$1 ').trim();
            e.target.value = value;
        });
    }
});

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
     const fields = [
      { id: 'section', message: "Select Section !" },
      { id: 'a_date', message: "Enter Admission Date !" },
      { id: 'roll', message: "Enter Roll Number !" },
      { id: 'tution_fee', message: "Enter Tution Fee !" },
      { id: 'tranport_fee', message: "Enter Transport and Other Fee" },
      { id: 'total', message: "Enter Total !" },
      { id: 'month_years', message: "Select Month and Years !" }
    ];

  for (let field of fields){
    let element = document.getElementById(field.id);
    if(!element.value.trim()){
      alert(field.message);
      element.focus();
      return false;
    }
  }
  return true
}

// registration adhar varified
// document.getElementById('radhar').addEventListener('input', function(e){
//     let value = e.target.value;
//     value = value.replace(/\D/g, '');
//     value = value.substring(0, 12);
//     value = value.replace(/(.{4})/g, '$1 ').trim();
//     e.target.value = value;
// });

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

function showToast1(message, isError = false) {
    const toast1 = document.getElementById('toast1');
    toast1.className = 'toast1 ' + (isError ? 'error' : 'success') + ' show';
    toast1.textContent = message;

    // Hide after 3 seconds
    setTimeout(() => {
        toast1.className = 'toast';
    }, 3000);
}

function paidBy() {
  const payment = document.getElementById('payment_by').value;
  if (payment === 'bank') {
    document.getElementById('bank').style.display = 'block';
    document.getElementById('upi').style.display = 'none';
    document.getElementById('check').style.display = 'none';
    document.getElementById('other').style.display = 'none';
  }else if(payment === 'upi'){
    document.getElementById('upi').style.display = 'block';
    document.getElementById('bank').style.display = 'none';
    document.getElementById('check').style.display = 'none';
    document.getElementById('other').style.display = 'none';
  }else if(payment === 'cash'){
    document.getElementById('bank').style.display = 'none';
    document.getElementById('upi').style.display = 'none';
    document.getElementById('check').style.display = 'none';
    document.getElementById('other').style.display = 'none';
  }else if(payment === 'check'){
    document.getElementById('check').style.display = 'block';
    document.getElementById('bank').style.display = 'none';
    document.getElementById('upi').style.display = 'none';
    document.getElementById('other').style.display = 'none';
  }else if(payment === 'other'){
    document.getElementById('other').style.display = 'block';
    document.getElementById('bank').style.display = 'none';
    document.getElementById('upi').style.display = 'none';
    document.getElementById('check').style.display = 'none';
  }else {
    document.getElementById('bank').style.display = 'none';
  }
}

// payments validation
function validatePayments(){
  const paymentFields = [
    {id:'paid', message:'Enter Paid Amount'},
    {id:'payment_by', message:'Select Payment Method'}
  ];  

  for(let payment of paymentFields){
    let payelement = document.getElementById(payment.id);
    if(!payelement.value.trim()){
      alert(payment.message);
      payelement.focus();
      return false;
    }
  }
  return true
}

// parents validation 
function validParents(){
  const parentsFields = [
    {id:'pname', message:"Enter Name !"},
    {id:'pmobile', message:'Enter Your Mobile', length:10}
  ];

  for(let parents of parentsFields){
    let parentelements = document.getElementById(parents.id);
    if(!parentelements.value.trim()){
      alert(parents.message);
      parentelements.focus();
      return false;
    }
    if (parents.id === 'pmobile' && parentelements.length !== parents.length) {
      alert("Mobile number must be exactly 10 digits!");
      parentelements.focus();
      return false;
    }
  }
  return true;
}