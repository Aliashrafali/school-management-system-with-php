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