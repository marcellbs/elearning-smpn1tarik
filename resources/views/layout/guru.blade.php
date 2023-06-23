<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>{{ $title; }} | E-Learning SMP Negeri 1 Tarik</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="/img/logso.png" rel="icon">
  <link href="/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
  <!-- Template Main CSS File -->
  <link rel="stylesheet" href="/css/style.css">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="/" class="logo d-flex align-items-center">
        <img src="/img/logso.png" alt="">
        <span class="d-none d-lg-block"><img src="/img/Group 30.png" alt=""></span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    

    {{-- <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">


        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">4</span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              Anda memiliki 4 pemberitahuan
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-exclamation-circle text-warning"></i>
              <div>
                <h4>Fitur masih dalam pengembangan</h4>
                <p>Mohon bersabar, fitur ini sedang dalam pengembangan</p>
                <p>30 min. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-x-circle text-danger"></i>
              <div>
                <h4>Fitur masih dalam pengembangan</h4>
                <p>Mohon bersabar, fitur ini sedang dalam pengembangan</p>
                <p>1 hr. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-check-circle text-success"></i>
              <div>
                <h4>Fitur masih dalam pengembangan</h4>
                <p>Mohon bersabar, fitur ini sedang dalam pengembangan</p>
                <p>2 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-info-circle text-primary"></i>
              <div>
                <h4>Fitur masih dalam pengembangan</h4>
                <p>Mohon bersabar, fitur ini sedang dalam pengembangan</p>
                <p>4 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-footer">
              <a href="#">Show all notifications</a>
            </li>

          </ul>

        </li>


      </ul>
    </nav> --}}

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <div class="text-center">
      {{-- <img src="/img/{{ auth()->user()->foto }}" alt="Profile" class="align-center rounded-circle image-profile"> --}}

      @if (file_exists(public_path('img/guru/' . auth()->user()->foto)))
        <img src="/img/guru/{{ auth()->user()->foto }}" alt="user-img" class="rounded-circle image-profile img-thumbnail p-0">
      @else
        <img src="/img/{{ auth()->user()->foto }}" alt="user-img" class="rounded-circle image-profile">
      @endif

      <h5 class="mb-0 mt-3">{{ auth()->user()->nama }}</h5>
      <p class="mt-0">Guru / Pengajar</p>
    </div>

    <hr>

    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link {{ (Request::is('guru')) ? 'active' : '' }}" href="/guru">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link {{ (Request::is('guru/mapel')) ? 'active' : '' }}" href="/guru/mapel">
          <i class="bi bi-bookmarks"></i><span>Mata Pelajaran</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ (Request::is('guru/jadwal-mengajar')) ? 'active' : '' }}" href="/guru/jadwal-mengajar">
          <i class="bi bi-calendar-week"></i><span>Jadwal Mengajar</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ (Request::is('guru/presensi')) ? 'active' : '' }}" href="/guru/presensi">
          <i class="bi bi-people"></i><span>Rekap Presensi</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ (Request::is('guru/materi')) ? 'active' : '' }}" href="/guru/materi">
          <i class="bi bi-book"></i>
          <span>Materi</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link {{ (Request::is('guru/tugas')) ? 'active' : '' }}" href="/guru/tugas">
          <i class="bi bi-pen"></i><span>Tugas</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ (Request::is('guru/pengumuman')) ? 'active' : '' }}"  href="/guru/pengumuman">
          <i class="bi bi-exclamation-circle"></i><span>Pengumuman</span>
        </a>
      </li><!-- End Announcements Nav -->

      <li class="nav-item">
        <a class="nav-link {{ (Request::is('guru/profile')) ? 'active' : '' }}" href="/guru/profile" >
          <i class="bi bi-person-vcard"></i><span>Profil</span>
        </a>
      </li><!-- End Icons Nav -->
      <li class="nav-item">
        <a class="nav-link" href="/guru/logout" class="{{ (Request::is('guru/logout')) ? 'active' : '' }}" >
          <i class="bi bi-box-arrow-right"></i><span>Keluar</span>
        </a>
      </li><!-- End Icons Nav -->
    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    @yield('content')

  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


  <script src="https://cdn.tiny.cloud/1/hx3up3hy2l2nr1pltnin749zdkhubjphi3e7xj4hr4ibk44b/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

  <!-- Vendor JS Files -->
  <script src="/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/vendor/chart.js/chart.umd.js"></script>
  <script src="/vendor/echarts/echarts.min.js"></script>
  <script src="/vendor/quill/quill.min.js"></script>
  {{-- <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js
"></script> --}}
  <!-- <script src="/vendor/simple-datatables/simple-datatables.js"></script> -->
  {{-- <script src="/vendor/tinymce/tinymce.min.js"></script> --}}
  <script src="/vendor/php-email-form/validate.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>



  <script>
    $(document).ready(function () {
        $('#datatable').DataTable();
    });
  </script>
  <!-- Template Main JS File -->
  <script src="/js/main.js"></script>



</body>

</html>