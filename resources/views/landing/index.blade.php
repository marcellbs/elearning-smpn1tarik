<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Welcome to SMPN 1 Tarik</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="img/logso.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="vendor/remixicon/remixicon.css" rel="stylesheet">


  <!-- Template Main CSS File -->
  <link href="css/style.css" rel="stylesheet">

</head>

<body>
  <main class="main-login">
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="img/logso.png" alt="">
                  <span class="d-lg-block text-center">WELCOME TO SMP NEGERI 1 TARIK</span>
                  <img src="img/kemdikbud.png" alt="">
                </a>
              </div><!-- End Logo -->

              @auth 
              <div class="row">
                <div class="col text-center">
                  <a href="/admin/dashboard" class="btn btn-primary mx-2 my-1">Dashboard</a>
                </div>
              </div>
              @else
                <!-- button pilihan login -->
              <div class="row">
                <h5 class="text-center">Login Sebagai</h5>
                <div class="col text-center">
                  <a href="/siswa/login" class="btn btn-primary mx-2 my-1">Siswa</a>
                  <a href="/guru/login" class="btn btn-primary mx-2 my-1 px-3">Guru</a>
                  <a href="/admin/login" class="btn btn-primary mx-2 my-1">Admin</a>
                </div>
              </div>
              @endauth

              

              
            </div>
          </div>
        </div>
        
        <div class="credits border-light">
          Created with <span class="text-danger">&#10084;</span>  by <a href="https://">SMP NEGERI 1 TARIK</a>
        </div>
      </section>
      
    </div>
  </main><!-- End #main -->




  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="js/main.js"></script>

</body>

</html>