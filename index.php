<?php include 'dbcon.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>FaceID Attendance System</title>
  <meta name="description" content="" />
  <meta name="keywords" content="" />

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon" />
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect" />
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet" />

  <!-- Vendor CSS Files -->
  <link
    href="assets/vendor/bootstrap/css/bootstrap.min.css"
    rel="stylesheet" />
  <link
    href="assets/vendor/bootstrap-icons/bootstrap-icons.css"
    rel="stylesheet" />
  <link href="assets/vendor/aos/aos.css" rel="stylesheet" />
  <link
    href="assets/vendor/glightbox/css/glightbox.min.css"
    rel="stylesheet" />
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet" />
  <style>
    canvas {
      position: absolute;
    }

    .video-container {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    #video {
      border-radius: 10px;
      box-shadow: #000;
    }
  </style>
  <script defer src="face-api.min.js"></script>
  <script defer src="script.js"></script>
</head>

<body class="index-page">
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">
      <a href="index.html" class="logo d-flex align-items-center me-auto">
        <img src="assets/img/logo.png" alt="" />
      </a>

      <nav id="navmenu" class="navmenu" style="visibility: hidden;">
        <ul>
          <li><a href="index.html#hero" class="active">Home</a></li>
          <li><a href="index.html#about">About</a></li>
          <li><a href="index.html#features">Features</a></li>
          <li><a href="index.html#services">Services</a></li>
          <li><a href="index.html#pricing">Pricing</a></li>
          <li><a href="index.html#contact">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>

  <main class="main">
    <!-- Hero Section -->
    <section id="hero" class="hero section">
      <div class="hero-bg">
        <img src="assets/img/hero-bg-light.webp" alt="" />
      </div>
      <div class="container text-center">
        <div class="d-flex flex-column justify-content-center align-items-center">
          <h1 data-aos="fade-up">FaceID Attendance System</h1>
          <p data-aos="fade-up" data-aos-delay="100" class="mt-2">
            Klik tombol start, kemudian biarkan aplikasi mendeteksi wajah anda. <br />Informasi mengenai anda akan muncul di bagian sebelah kanan<br />
          </p>

          <div id="studentTableContainer"></div>

        </div>

        <div class="px-4" data-aos="fade-up">
          <div class="row gx-3">
            <div class="col-lg-8">
              <div class="p-3 border bg-light rounded video-container" style="max-height:500px !important;">
                <!-- Video Element with Placeholder Image -->
                <video width="640px" height="480px" id="video" autoplay style="background: url('assets/img/noCamera.png') center center / cover no-repeat;"></video>
                <canvas width="640px" height="480px" id="overlay" class="overlay"></canvas>
              </div>
            </div>
            <div class="col">
              <div class="p-3 border bg-light rounded" style="min-height:500px;">
                <div class="d-flex flex-column justify-content-center align-items-center">
                  <h3 class="text-dark">Informasi</h3>
                  <!-- Canvas Element with Placeholder Image -->
                  <!-- <canvas id="canvAttend" class="w-100 bg-dark rounded mt-3" style="background: url('assets/img/noImage.png') center center / contain no-repeat;"></canvas> -->
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="px-4 mt-3" data-aos="fade-up">
          <button id="startButton" class="btn btn-lg btn-outline-primary p-2 w-100">Start Camera</button>
        </div>

        <div id="messageDiv" style="display: none;"></div>

        <div class="px-4 mt-4" data-aos="fade-up">
          <button id="endAttendance" class="btn btn-lg btn-outline-primary p-2 w-100">End Attendance</button>
        </div>
      </div>
    </section>
    <!-- /Hero Section -->
  </main>

  <footer id="footer" class="footer position-relative white-background">
    <div class="container copyright text-center mt-3">
      <p>
        <?= date('Y') ?> © <span>Copyright</span>
        <strong class="px-1 sitename">Indodacin FaceID</strong><span>All Rights Reserved</span>
      </p>
      <div class="credits" style="visibility:hidden; display:none;">
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
</body>

</html>