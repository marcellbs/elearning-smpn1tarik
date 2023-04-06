<?php
?>

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

    

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">


        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">4</span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            {{-- <li class="dropdown-header">
              You have 4 new notifications
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li> --}}
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

            {{-- <li>
              <hr class="dropdown-divider">
            </li> --}}
            {{-- <li class="dropdown-footer">
              <a href="#">Show all notifications</a>
            </li> --}}

          </ul>

        </li>


      </ul>
    </nav>

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <div class="text-center">
      <img src="/img/{{ auth()->user()->foto }}" alt="Profile" class="align-center rounded-circle image-profile">
      {{-- {!! ucwords('khoirul badi S.Kom., M.T.') !!} --}}
      <h5 class="mb-0 mt-3">{{ auth()->user()->nama }}</h5>
      <p class="mt-0">Administrator</p>
    </div>

    <hr>

    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link {{ (Request::is('admin')) ? 'active' : '' }}" href="/admin">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link {{ (Request::is('admin/materi')) ? 'active' : '' }}" href="/admin/materi">
          <i class="bi bi-book"></i>
          <span>Materi</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link {{ (Request::is('admin/pengumuman')) ? 'active' : '' }}"  href="/admin/pengumuman">
          <i class="bi bi-exclamation-circle"></i><span>Pengumuman</span>
        </a>
      </li><!-- End Announcements Nav -->

      <li class="nav-item">
        <a class="nav-link {{ (Request::is('admin/kelas')) ? 'active' : '' }}" href="/admin/kelas">
          <i class="bi bi-clipboard2-data"></i><span>Data Kelas</span>
        </a>
        
      </li><!-- End Forms Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse">
          <i class="bi bi-people"></i><span>Data Pengguna</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        
        <ul id="tables-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="/admin/siswa" class="{{ (Request::is('admin/siswa')) ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Siswa</span>
            </a>
          </li>
          <li>
            <a href="/admin/guru" class="{{ (Request::is('admin/guru')) ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Guru</span>
            </a>
          </li>
          <li>
            <a href="/admin/admin" class="{{ (Request::is('admin/admin')) ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Admin</span>
            </a>
          </li>
        </ul>
      </li><!-- End Tables Nav -->

      <li class="nav-item">
        <a class="nav-link {{ (Request::is('admin/pengampu')) ? 'active' : '' }}" href="/admin/pengampu">
          <i class="bi bi-person-workspace"></i><span>Data Pengampu</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ (Request::is('admin/mapel')) ? 'active' : '' }}" href="/admin/mapel">
          <i class="bi bi-bookmarks"></i><span>Data Mapel</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ (Request::is('admin/profile')) ? 'active' : '' }}" href="/admin/profile" >
          <i class="bi bi-person-vcard"></i><span>Profil</span>
        </a>
      </li><!-- End Icons Nav -->
      <li class="nav-item">
        <a class="nav-link" href="/admin/logout" class="{{ (Request::is('admin/logout')) ? 'active' : '' }}" >
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