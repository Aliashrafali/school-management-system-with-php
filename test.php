<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>5 Card Slider with Captions</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    #testimonialCarouselvideo .carousel-inner {
      padding: 0; /* remove side padding */
    }
    #testimonialCarouselvideo .carousel-item .card-wrapper {
      display: flex;
      justify-content: space-between;
      gap: 15px; /* cards ke beech gap */
    }
    #testimonialCarouselvideo .card-wrapper .card {
      flex: 1 1 calc(20% - 15px); /* 5 equal width cards */
      border-radius: 10px;
      overflow: hidden;
    }
    #testimonialCarouselvideo .video-card img {
      width: 100%;
      height: 150px;
      object-fit: cover!important;
    }
    #testimonialCarouselvideo .play-icon {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 3rem;
      color: white;
      opacity: 0.85;
    }
    #testimonialCarouselvideo .card-body {
      padding: 8px;
    }
    #testimonialCarouselvideo .card-title {
      font-size: 14px;
      font-weight: 600;
      margin: 0;
    }
    #testimonialCarouselvideo .video-card {
      position: relative;
    }
    #testimonialCarouselvideo .card-wrapper .card-body p{
        background-color: #2c8b56;
        display: inline-block;
        color: #fff;
        padding: 1px 7px 3px 7px;
        border-radius: 3px;
        font-size: 14px;
        margin: 7px;
        font-weight: 600;
        letter-spacing: 1px;
    }
  </style>
</head>
<body class="bg-light">

<div class="container-fluid py-5">
  <div id="testimonialCarouselvideo" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <!-- Slide 1 -->
      <div class="carousel-item active">
        <div class="card-wrapper">
          <div class="card video-card">
            <a href="https://www.youtube.com/watch?v=CqvSvss7Cqc" target="_blank">
              <img src="https://img.youtube.com/vi/CqvSvss7Cqc/maxresdefault.jpg">
              <i class="bi bi-play-circle-fill play-icon"></i>
            </a>
            <div class="card-body text-center">
              <h6 class="card-title">Rajmohan De Sarkar</h6>
              <p>Technical Director</p>
            </div>
          </div>
          <div class="card video-card">
            <a href="https://www.youtube.com/watch?v=CqvSvss7Cqc" target="_blank">
              <img src="https://img.youtube.com/vi/CqvSvss7Cqc/maxresdefault.jpg">
              <i class="bi bi-play-circle-fill play-icon"></i>
            </a>
            <div class="card-body text-center">
              <h6 class="card-title">Rajmohan De Sarkar</h6>
              <p>Technical Director</p>
            </div>
          </div>
          <div class="card video-card">
            <a href="https://www.youtube.com/watch?v=CqvSvss7Cqc" target="_blank">
              <img src="https://img.youtube.com/vi/CqvSvss7Cqc/maxresdefault.jpg">
              <i class="bi bi-play-circle-fill play-icon"></i>
            </a>
            <div class="card-body text-center">
              <h6 class="card-title">Rajmohan De Sarkar</h6>
              <p>Technical Director</p>
            </div>
          </div>
            <div class="card video-card">
            <a href="https://www.youtube.com/watch?v=CqvSvss7Cqc" target="_blank">
              <img src="https://img.youtube.com/vi/CqvSvss7Cqc/maxresdefault.jpg">
              <i class="bi bi-play-circle-fill play-icon"></i>
            </a>
            <div class="card-body text-center">
              <h6 class="card-title">Rajmohan De Sarkar</h6>
              <p>Technical Director</p>
            </div>
          </div>
          <div class="card video-card">
            <a href="https://www.youtube.com/watch?v=CqvSvss7Cqc" target="_blank">
              <img src="https://img.youtube.com/vi/CqvSvss7Cqc/maxresdefault.jpg">
              <i class="bi bi-play-circle-fill play-icon"></i>
            </a>
            <div class="card-body text-center">
              <h6 class="card-title">Rajmohan De Sarkar</h6>
              <p>Technical Director</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Slide 2 -->
      <div class="carousel-item">
        <div class="card-wrapper">
          <div class="card video-card">
            <a href="https://www.youtube.com/watch?v=CqvSvss7Cqc" target="_blank">
              <img src="https://img.youtube.com/vi/CqvSvss7Cqc/maxresdefault.jpg">
              <i class="bi bi-play-circle-fill play-icon"></i>
            </a>
            <div class="card-body text-center">
              <h6 class="card-title">Rajmohan De Sarkar</h6>
              <p>Technical Director</p>
            </div>
          </div>
          <div class="card video-card">
            <a href="https://www.youtube.com/watch?v=CqvSvss7Cqc" target="_blank">
              <img src="https://img.youtube.com/vi/CqvSvss7Cqc/maxresdefault.jpg">
              <i class="bi bi-play-circle-fill play-icon"></i>
            </a>
            <div class="card-body text-center">
              <h6 class="card-title">Rajmohan De Sarkar</h6>
              <p>Technical Director</p>
            </div>
          </div>
         <div class="card video-card">
            <a href="https://www.youtube.com/watch?v=CqvSvss7Cqc" target="_blank">
              <img src="https://img.youtube.com/vi/CqvSvss7Cqc/maxresdefault.jpg">
              <i class="bi bi-play-circle-fill play-icon"></i>
            </a>
            <div class="card-body text-center">
              <h6 class="card-title">Rajmohan De Sarkar</h6>
              <p>Technical Director</p>
            </div>
          </div>
          <div class="card video-card">
            <a href="https://www.youtube.com/watch?v=CqvSvss7Cqc" target="_blank">
              <img src="https://img.youtube.com/vi/CqvSvss7Cqc/maxresdefault.jpg">
              <i class="bi bi-play-circle-fill play-icon"></i>
            </a>
            <div class="card-body text-center">
              <h6 class="card-title">Rajmohan De Sarkar</h6>
              <p>Technical Director</p>
            </div>
          </div>
          <div class="card video-card">
            <a href="https://www.youtube.com/watch?v=CqvSvss7Cqc" target="_blank">
              <img src="https://img.youtube.com/vi/CqvSvss7Cqc/maxresdefault.jpg">
              <i class="bi bi-play-circle-fill play-icon"></i>
            </a>
            <div class="card-body text-center">
              <h6 class="card-title">Rajmohan De Sarkar</h6>
              <p>Technical Director</p>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
