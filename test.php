<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>100% Circle Progress with Number Inside</title>
<style>
  body {
    display: flex;
    height: 100vh;
    justify-content: center;
    align-items: center;
    background: #f0f0f0;
    font-family: Arial, sans-serif;
  }
  .circle-container {
    position: relative;
    width: 150px;
    height: 150px;
  }
  .circle {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background: conic-gradient(green 0%, #ddd 0%);
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .percentage {
    position: absolute;
    font-size: 40px;
    font-weight: bold;
    color: green;
    user-select: none;
  }
</style>
</head>
<body>

<div class="circle-container">
  <div class="circle" id="circle"></div>
  <div class="percentage" id="percent">0%</div>
</div>

<script>
  const circle = document.getElementById('circle');
  const percent = document.getElementById('percent');
  let value = 0;

  function updateCircle() {
    if (value <= 100) {
      circle.style.background = `conic-gradient(green ${value}%, #ddd ${value}%)`;
      percent.textContent = value + '%';
      value++;
      setTimeout(updateCircle, 20);
    }
  }

  updateCircle();
</script>

</body>
</html>
