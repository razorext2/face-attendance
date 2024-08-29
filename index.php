<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Index - QuickStart Bootstrap Template</title>
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

  <!-- =======================================================
  * Template Name: QuickStart
  * Template URL: https://bootstrapmade.com/quickstart-bootstrap-startup-website-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div
      class="container-fluid container-xl position-relative d-flex align-items-center">
      <a href="index.html" class="logo d-flex align-items-center me-auto">
        <img src="assets/img/logo.png" alt="" />
        <h1 class="sitename">QuickStart</h1>
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
          <h1 data-aos="fade-up">Welcome to <span>QuickStart</span></h1>
          <p data-aos="fade-up" data-aos-delay="100">
            Quickly start your project now and set the stage for success<br />
          </p>

          <!-- <img
            src="assets/img/hero-services-img.webp"
            class="img-fluid hero-img"
            alt=""
            data-aos="zoom-out"
            data-aos-delay="50" /> -->
        </div>


        <div class="px-4 mt-5" data-aos="fade-up">
          <div class="row gx-3">
            <div class="col-lg-8">
              <div class="p-3 border bg-light rounded" style="height:500px;">
                <video id="videoAttend" autoplay class="w-100 h-100" style="display:block;"></video>
              </div>
            </div>
            <div class=" col">
              <div class="p-3 border bg-light rounded" style="min-height:500px;">
                <div class="d-flex flex-column justify-content-center align-items-center">
                  <h3 class="text-dark">Informasi</h3>
                  <canvas id="canvAttend" class="w-100 h-50 bg-dark rounded mt-3"> </canvas>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="px-4 mt-3" data-aos="fade-up">
          <button id="captureAttend" class="btn btn-lg btn-outline-primary p-2 w-100"> Start Camera </button>
        </div>

      </div>
    </section>
    <!-- /Hero Section -->
  </main>

  <footer id="footer" class="footer position-relative white-background">
    <div class="container copyright text-center mt-4">
      <p>
        © <span>Copyright</span>
        <strong class="px-1 sitename">QuickStart</strong><span>All Rights Reserved</span>
      </p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a
    href="#"
    id="scroll-top"
    class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      let stream = null;

      const video = document.getElementById('videoAttend');
      const canvas = document.getElementById('canvAttend');
      const btn = document.getElementById('captureAttend');

      btn.addEventListener('click', () => {
        if (!stream) {
          // Start the camera
          navigator.mediaDevices.getUserMedia({
              video: true
            })
            .then(mediaStream => {
              stream = mediaStream;
              video.srcObject = stream;
              video.style.display = 'block';
              btn.textContent = 'Capture Photo';
            })
            .catch(error => {
              console.error("Error accessing the camera: ", error);
              alert("Unable to access the camera. Please check your permissions and device settings.");
            });
        } else {
          // Capture the photo
          capturePhoto();
        }
      });

      function capturePhoto() {
        const context = canvas.getContext('2d');

        // Ensure canvas size matches the video element
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        // Draw the video frame to the canvas
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Stop the camera
        if (stream) {
          stream.getTracks().forEach(track => track.stop());
        }
        video.style.display = 'none';
        stream = null;
        btn.textContent = 'Start Camera';
      }
    });
  </script>

</body>

</html>