<?php
    include 'cardarray.php';
?>
<?php include 'include/header.php'; ?>
<header>
    <?php include 'include/navbar.php'; ?>
</header>

<!--Body area here -->
<main>
    <section>
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-5">
                    <div class="home-title">
                        <a href="" style="font-size: 25px; border-right: 0.1px solid #313131; padding-right: 20px;">Dashboard</a>
                        <a href="javascript:void(0)" style="margin-left: 20px; font-family: 'Exo 2';"><i class="fas fa-home" style="padding-right: 5px;"></i> Anlysis</a>
                    </div>
                </div> 
                <div class="col-12 col-md-7">
                    <div class="total-print d-flex justify-content-between">
                        <a href="javascript:void(0)" style="margin-left: 20px; font-family: 'Exo 2';"> Total Amount <?= date('F Y') ?> <i class="fas fa-arrow-right" style="font-size: 13px; padding-left: 5px; padding-right: 5px;"></i> <span style="color: #4CAF50;"><b>[ 00 ]</b></span></a>
                        <a href="javascript:void(0)" style="margin-left: 20px; font-family: 'Exo 2';"> Total Amount Till Now <i class="fas fa-arrow-right" style="font-size: 13px; padding-left: 5px; padding-right: 5px;"></i> <span style="color: #FF4545;"><b>[ 00 ]</b></span></a>
                    </div>
                </div>   
            </div>
            <div class="row">
                <?php
                    foreach($cards as $card){
                ?>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <a href="<?= $card['url']; ?>">
                            <div class="home-card" style="background-color:<?= $card['card-color']; ?>; border-left: 3px solid <?= $card['border-left']; ?>;">
                                <div class="home-card-left">
                                    <i class="<?= $card['icon']; ?>" style="color:<?= $card['color']; ?>; background-color: <?= $card['bg-color']; ?>;"></i>
                                </div>
                                <div class="home-card-right">
                                    <div style="display: block; float: right;">
                                        <div class="num" data-target="<?= $card['num']; ?>" style="color:<?= $card['num-color']; ?>">0</div>
                                        <div class="title" style="color: <?= $card['num-color']; ?>;">
                                            <?= $card['title']; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div> 
                <?php
                    }
                ?>   
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="chart-card">
                        <div class="chart-title"><b><?= date('F Y') ?></b>, Monthly Revenue</div>
                        <div class="percentage-circle" aria-label="Average monthly collection 61.7 percent">
                            <svg>
                            <circle class="bg" cx="60" cy="60" r="54"></circle>
                            <circle class="progress" cx="60" cy="60" r="54"></circle>
                            </svg>
                            <div class="percentage-text">61.7%</div>
                        </div>

                        <div class="chart">
                            <div class="bar-container">
                            <div class="bar" style="height: 40%;"><span>₹0</span></div>
                            <div class="month">Jan</div>
                            </div>
                            <div class="bar-container">
                            <div class="bar" style="height: 80%;"><span>₹2400</span></div>
                            <div class="month">Feb</div>
                            </div>
                            <div class="bar-container">
                            <div class="bar" style="height: 90%;"><span>₹4200</span></div>
                            <div class="month">Mar</div>
                            </div>
                            <div class="bar-container">
                            <div class="bar" style="height: 100%;"><span>₹5000</span></div>
                            <div class="month">Apr</div>
                            </div>
                            <div class="bar-container">
                            <div class="bar" style="height: 70%;"><span>₹3900</span></div>
                            <div class="month">May</div>
                            </div>
                            <div class="bar-container">
                            <div class="bar" style="height: 90%;"><span>₹4900</span></div>
                            <div class="month">Jun</div>
                            </div>
                            <div class="bar-container">
                            <div class="bar" style="height: 60%;"><span>₹3000</span></div>
                            <div class="month">Jul</div>
                            </div>
                            <div class="bar-container">
                            <div class="bar" style="height: 30%;"><span>₹0</span></div>
                            <div class="month">Aug</div>
                            </div>
                            <div class="bar-container">
                            <div class="bar" style="height: 50%;"><span>₹0</span></div>
                            <div class="month">Sep</div>
                            </div>
                            <div class="bar-container">
                            <div class="bar" style="height: 95%;"><span>₹5200</span></div>
                            <div class="month">Oct</div>
                            </div>
                            <div class="bar-container">
                            <div class="bar" style="height: 20%;"><span>₹0</span></div>
                            <div class="month">Nov</div>
                            </div>
                            <div class="bar-container">
                            <div class="bar" style="height: 40%;"><span>₹0</span></div>
                            <div class="month">Dec</div>
                            </div>
                        </div>
                        <div class="bottom-text">Average monthly Collection for every Student</div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12">
                    <div class="software-porform">
                        <span>Software Performance</span>
                        <div class="progress-circle">
                            <svg width="120" height="120" viewBox="0 0 120 120">
                            <circle class="bg" cx="60" cy="60" r="54" stroke="#eee" stroke-width="12" fill="none" />
                            <circle class="progress" cx="60" cy="60" r="54" stroke="#00c853" stroke-width="12" fill="none"
                                    stroke-linecap="round" stroke-dasharray="339.292" stroke-dashoffset="339.292" />
                            </svg>
                            <div class="percentage-text">100%</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-2 col-sm-12">
                    <div class="software-porform">
                        <span>Software Speed</span>
                        <div class="progress-circle">
                            <svg width="120" height="120" viewBox="0 0 120 120">
                            <circle class="bg" cx="60" cy="60" r="54" stroke="#eee" stroke-width="12" fill="none" />
                            <circle class="progress" cx="60" cy="60" r="54" stroke="#00c853" stroke-width="12" fill="none"
                                    stroke-linecap="round" stroke-dasharray="339.292" stroke-dashoffset="339.292" />
                            </svg>
                            <div class="percentage-text">100%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!--Body Section -->

<script>
  // Stroke dashoffset calculation for 61.7%
  const progressCircle = document.querySelector('.percentage-circle .progress');
  const radius = 54;
  const circumference = 2 * Math.PI * radius;
  const percentage = 61.7;
  const offset = circumference * (1 - percentage / 100);
  progressCircle.style.strokeDasharray = circumference;
  progressCircle.style.strokeDashoffset = offset;
</script>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const circles = document.querySelectorAll(".progress-circle");

    circles.forEach((circleWrapper) => {
      const circle = circleWrapper.querySelector(".progress");
      const percentageText = circleWrapper.querySelector(".percentage-text");

      const radius = circle.r.baseVal.value;
      const circumference = 2 * Math.PI * radius;

      let currentFrame = 0;
      const animationDuration = 2000; // animation time in ms
      const frameDuration = 1000 / 60; // 60 fps
      const totalFrames = Math.round(animationDuration / frameDuration);

      circle.style.strokeDasharray = circumference;
      circle.style.strokeDashoffset = circumference;

      function animate() {
        currentFrame++;
        const progressRatio = currentFrame / totalFrames;
        const dashoffset = circumference * (1 - progressRatio);
        circle.style.strokeDashoffset = dashoffset;
        percentageText.textContent = Math.round(progressRatio * 100) + "%";

        if (currentFrame < totalFrames) {
          requestAnimationFrame(animate);
        } else {
          percentageText.textContent = "100%";
        }
      }

      animate();
    });
  });
</script>
<?php include 'include/footer.php'; ?>
