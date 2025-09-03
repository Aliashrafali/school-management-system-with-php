<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Video with Testimonials Overlay</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f0f0;
      margin: 0;
      padding: 40px;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .video-testimonials-wrapper {
      position: relative;
      width: 100%;
      max-width: 800px;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }

    .video-testimonials-wrapper iframe {
      width: 100%;
      height: 450px;
      display: block;
      border: none;
    }

    .testimonial-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none; /* allows clicks to pass through to video */
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
      padding: 20px;
      box-sizing: border-box;
      background: linear-gradient(to top, rgba(0,0,0,0.7), transparent 50%);
      color: #fff;
    }

    .testimonial {
      margin: 0 0 12px;
      padding: 12px 16px;
      font-size: 1.1em;
      background: rgba(0, 0, 0, 0.6);
      border-left: 4px solid #ffcc00;
      border-radius: 6px;
    }

    .testimonial cite {
      display: block;
      margin-top: 6px;
      font-size: 0.9em;
      font-style: normal;
      color: #ddd;
    }
  </style>
</head>
<body>
  <div class="video-testimonials-wrapper">
    <iframe
      src="https://www.youtube.com/embed/CqvSvss7Cqc"
      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
      allowfullscreen
    ></iframe>
  </div>
</body>
</html>
