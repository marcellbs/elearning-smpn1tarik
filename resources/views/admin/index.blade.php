@extends('layout.main')

@section('content')

<?php 
  header("Set-Cookie: cross-site-cookie=whatever; SameSite=None; Secure");
?>

<!-- <main id="main" class="main"> -->
<div class="pagetitle">
  <h1>Dashboard</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </nav>
</div>
<!-- End Page Title -->

<section class="section dashboard">
  <div class="row">
    <!-- card total -->
    {{-- menghitung total siswa --}}
    <div class="col-lg-12">
      <div class="row">
        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card sales-card">

            <div class="card-body">
              <h5 class="card-title">Total Siswa</h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-mortarboard"></i>
                </div>
                <div class="ps-3 mx-3 ms-auto">
                  <h1><?= $total_siswa;?></h1>
                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- End Sales Card -->

        <!-- Revenue Card -->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card revenue-card">
            <div class="card-body">
              <h5 class="card-title">Total Guru</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-people"></i>
                </div>
                <div class="ps-3 ms-auto mx-3">
                  <h1><?= $total_guru;?></h1>
                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- End Revenue Card -->

        <!-- Customers Card -->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card customers-card">
            <div class="card-body">
              <h5 class="card-title">Total Admin</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-person"></i>
                </div>
                <div class="ps-3 ms-auto mx-3">
                  <h1><?= $total_admin;?></h6>
                </div>
              </div>

            </div>
          </div>

        </div>
        <!-- End Customers Card -->
      </div>
    </div>
    <!-- end total card -->


    <!-- pengumuman -->
    <div class="col-lg-8">
      <div class="row">
        <div class="container">
          <div class="card">
            <div class="card-body">
              <div class="card-title pb-0">
                <h5>Pengumuman Terbaru</h5>
                <hr>
              </div>
            </div>

            <!-- carousel -->
            <div id="carouselExampleAutoplaying" class="carousel carousel-dark slide" data-bs-ride="carousel">
              <div class="carousel-inner">

                <div class="carousel-item active">
                  <div class="card-body px-5 mx-5">
                    <p class="mx-1 text-center">
                      Pengumuman Terbaru
                    </p>
                  </div>
                </div>
                
                @foreach ($pengumuman as $p)
                <div class="carousel-item" data-interval="20000">
                  <div class="card-body px-5 mx-5">
                    <p class="mx-1 text-center">
                      {{ $p->judul_pengumuman }}
                    </p>
                    <p class="mx-1 text-center">
                      {!! $p->deskripsi !!}
                    </p>
                  </div>
                </div>
                @endforeach
              </div>
            </div>           
            <!-- end carousel -->
          </div>
        </div>
      </div>
    </div>
      <!-- end pengumuman -->

      {{-- <!-- Left side columns -->
      <div class="col-lg-8">
        <div class="row">
          <!-- Reports -->
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Reports <span>/Today</span></h5>

                <!-- Line Chart -->
                <div id="reportsChart"></div>

                <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    new ApexCharts(document.querySelector("#reportsChart"), {
                      series: [{
                        name: 'Sales',
                        data: [31, 40, 28, 51, 42, 82, 56],
                      }, {
                        name: 'Revenue',
                        data: [11, 32, 45, 32, 34, 52, 41]
                      }, {
                        name: 'Customers',
                        data: [15, 11, 32, 18, 9, 24, 11]
                      }],
                      chart: {
                        height: 350,
                        type: 'area',
                        toolbar: {
                          show: false
                        },
                      },
                      markers: {
                        size: 4
                      },
                      colors: ['#4154f1', '#2eca6a', '#ff771d'],
                      fill: {
                        type: "gradient",
                        gradient: {
                          shadeIntensity: 1,
                          opacityFrom: 0.3,
                          opacityTo: 0.4,
                          stops: [0, 90, 100]
                        }
                      },
                      dataLabels: {
                        enabled: false
                      },
                      stroke: {
                        curve: 'smooth',
                        width: 2
                      },
                      xaxis: {
                        type: 'datetime',
                        categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
                      },
                      tooltip: {
                        x: {
                          format: 'dd/MM/yy HH:mm'
                        },
                      }
                    }).render();
                  });
                </script>
                <!-- End Line Chart -->

              </div>

            </div>
          </div><!-- End Reports -->
        </div>
      </div><!-- End Left side columns --> --}}

      <!-- Right side columns -->
      <div class="col-lg-4">
        <div class="row">
          <!-- Website Traffic -->
          <div class="col-12">
            <div class="card">
              <div class="card-body pb-0">
                <h5 class="card-title">Data Pengguna</h5>

                <div id="trafficChart" style="min-height: 400px;" class="echart"></div>

                <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    echarts.init(document.querySelector("#trafficChart")).setOption({
                      tooltip: {
                        trigger: 'item'
                      },
                      legend: {
                        top: '5%',
                        left: 'center'
                      },
                      series: [{
                        name: 'Access From',
                        type: 'pie',
                        radius: ['40%', '70%'],
                        avoidLabelOverlap: false,
                        label: {
                          show: false,
                          position: 'center'
                        },
                        emphasis: {
                          label: {
                            show: true,
                            fontSize: '18',
                            fontWeight: 'bold'
                          }
                        },
                        labelLine: {
                          show: false
                        },
                        data: [{
                          // mengambil data dari database
                            value: {{ $total_siswa }},
                            name: 'Data Siswa'
                          },
                          {
                            value: {{ $total_guru }},
                            name: 'Data Guru'
                          },
                          {
                            value: {{ $total_admin }},
                            name: 'Data Admin'
                          },
                          
                        ]
                      }]
                    });
                  });
                </script>

              </div>
            </div><!-- End Website Traffic -->
          </div>
        </div>
      </div><!-- End Right side columns -->

    </div>
</section>

@endsection

