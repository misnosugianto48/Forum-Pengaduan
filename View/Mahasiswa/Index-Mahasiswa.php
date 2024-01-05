<?php
session_start();
include "../../Model/db.php";
if (!isset($_SESSION['username'])) {
  header("location: ../../Login.php");
  exit();
}
$id_mahasiswa_login = $_SESSION['id_mahasiswa']; // Sesuaikan dengan variabel sesi yang Anda gunakan

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pengaduan Mahasiswa</title>
  <link rel="shortcut icon" type="image/png" href="../../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../../assets/css/styles.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="./index.php" class="text-nowrap logo-img">
            <h3 class="text-info">Pengaduan <i class="ti ti-file-description"></i></h3>
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Home</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./Index-Mahasiswa.php" aria-expanded="false">
                <span>
                  <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">CONTENT</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./Pengaduan-Mahasiswa.php" aria-expanded="false">
                <span>
                  <i class="ti ti-alert-circle"></i>
                </span>
                <span class="hide-menu">Pengaduan</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./Tanggapan-Mahasiswa.php" aria-expanded="false">
                <span>
                  <i class="ti ti-bell"></i>
                </span>
                <span class="hide-menu">Tanggapan</span>
              </a>
            </li>
          </ul>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                  <img src="../../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3"><?php print_r($_SESSION['username']); ?> - ID <?php echo $id_mahasiswa_login; ?></p>
                    </a>
                    <a href="../../Controller/LogoutController.php" class="btn btn-outline-danger mx-3 mt-2 d-block">Logout</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">
        <!--  Row 1 -->
        <div class="row">
          <div class="col-lg-8 d-flex align-items-strech">
            <div class="card w-100">
              <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                  <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">Tanggapan Terbaru</h5>
                    <table class="table text-nowrap mb-0 align-middle>
                      <thead class=" text-dark fs-4">
                      <tr>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Judul</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Petugas</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Ditanggapi</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Status</h6>
                        </th>
                      </tr>
                      </thead>
                      <?php
                      $sql = "SELECT tanggapan.*, pengaduan.judul,pengaduan.status_pengaduan, petugas.username FROM tanggapan
                      LEFT JOIN pengaduan ON tanggapan.id_pengaduan = pengaduan.id_pengaduan
                      LEFT JOIN petugas ON tanggapan.id_petugas = petugas.id_petugas
                      WHERE pengaduan.id_mahasiswa = ?";
                      // Eksekusi pernyataan SQL dengan parameter ID mahasiswa login
                      $params = array($id_mahasiswa_login);
                      $stmt = sqlsrv_query($conn, $sql, $params);
                      $num = 1;
                      while ($data = sqlsrv_fetch_array($stmt)) {
                      ?>
                        <tr>
                          <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0"><?php echo $data['judul']; ?></h6>
                          </td>
                          <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0"><?php echo $data['username']; ?></h6>
                          </td>
                          <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0"><?php echo $data['tanggal_tanggapan']; ?></h6>
                          </td>
                          <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0 text-success"><?php echo $data['status_pengaduan']; ?></h6>
                          </td>
                        </tr>
                      <?php } ?>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="row">
              <div class="col-lg-12">
                <!-- Monthly Earnings -->
                <div class="card">
                  <div class="card-body">
                    <div class="row alig n-items-start">
                      <div class="col-8">
                        <h5 class="card-title mb-9 fw-semibold"> Total Pengaduan </h5>
                        <?php
                        $sql = "SELECT COUNT(*) AS total_pengaduan FROM pengaduan WHERE id_mahasiswa = ?";

                        // Eksekusi pernyataan SQL dengan parameter ID mahasiswa login
                        $params = array($id_mahasiswa_login);
                        $stmt = sqlsrv_query($conn, $sql, $params);
                        $num = 1;
                        while ($data = sqlsrv_fetch_array($stmt)) {
                        ?>
                          <h4 class="fw-semibold mb-3"><?php echo  $data['total_pengaduan']; ?></h4>
                        <?php } ?>
                      </div>
                      <div class="col-4">
                        <div class="d-flex justify-content-end">
                          <div class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                            <i class="ti ti-alert-circle fs-6"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-12">
                <!-- Monthly Earnings -->
                <div class="card">
                  <div class="card-body">
                    <div class="row alig n-items-start">
                      <div class="col-8">
                        <h5 class="card-title mb-9 fw-semibold"> Total Ditanggapi </h5>
                        <?php
                        $sql = "SELECT COUNT(*) AS total_ditanggapi
                        FROM tanggapan
                        INNER JOIN pengaduan ON tanggapan.id_pengaduan = pengaduan.id_pengaduan
                        WHERE pengaduan.id_mahasiswa = ?
                        ";
                        // Eksekusi pernyataan SQL dengan parameter ID mahasiswa login
                        $params = array($id_mahasiswa_login);
                        $stmt = sqlsrv_query($conn, $sql, $params);
                        $num = 1;
                        while ($data = sqlsrv_fetch_array($stmt)) {
                        ?>
                          <h4 class="fw-semibold mb-3"><?php echo  $data['total_ditanggapi']; ?></h4>
                        <?php } ?>
                      </div>
                      <div class="col-4">
                        <div class="d-flex justify-content-end">
                          <div class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                            <i class="ti ti-bell fs-6"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card w-100">
              <div class="card-body p-4">
                <div class="mb-4">
                  <h5 class="card-title fw-semibold">Pengaduan Terakhir</h5>
                </div>
                <?php
                $sql = "SELECT TOP 5 pengaduan.* FROM pengaduan WHERE id_mahasiswa = ? AND 
                status_pengaduan = 'On Progress' 
                ORDER BY tanggal_pengaduan DESC ";
                $params = array($id_mahasiswa_login);
                $stmt = sqlsrv_query($conn, $sql, $params);
                while ($data = sqlsrv_fetch_array($stmt)) {
                  # code...
                ?>
                  <ul class="timeline-widget mb-0 position-relative mb-n5">
                    <li class="timeline-item d-flex position-relative overflow-hidden">
                      <div class="timeline-time text-dark flex-shrink-0 text-end"><?php echo $data['tanggal_pengaduan']; ?></div>
                      <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                        <span class="timeline-badge border-2 border border-primary flex-shrink-0 my-8"></span>
                        <span class="timeline-badge-border d-block flex-shrink-0"></span>
                      </div>
                      <div class="timeline-desc fs-3 text-dark mt-n1"><?php echo $data['judul']; ?><p class="text-warning d-block fw-normal"><?php echo $data['status_pengaduan']; ?></p>
                      </div>
                    </li>
                  <?php } ?>
                  <!--  -->
                  </ul>
              </div>
            </div>
          </div>
          <div class="col-lg-8 d-flex align-items-stretch">
            <div class="card w-100">
              <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-4">Pengaduan Selesai</h5>
                <div class="table-responsive">
                  <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                      <tr>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Id</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Judul</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Ditanggapi</h6>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sql = "SELECT TOP 5 pengaduan.* FROM pengaduan WHERE id_mahasiswa = ? AND 
                      status_pengaduan = 'Done' 
                      ORDER BY tanggal_pengaduan DESC ";
                      $params = array($id_mahasiswa_login);
                      $stmt = sqlsrv_query($conn, $sql, $params);
                      $num = 1;
                      while ($data = sqlsrv_fetch_array($stmt)) {
                      ?>
                        <tr>
                          <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0"><?php echo $data['id_pengaduan']; ?></h6>
                          </td>
                          <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0"><?php echo $data['judul']; ?></h6>
                          </td>
                          <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0"><?php echo $data['tanggal_pengaduan']; ?></h6>
                          <?php } ?>
                        </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/js/sidebarmenu.js"></script>
  <script src="../../assets/js/app.min.js"></script>
  <script src="../../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../../assets/js/dashboard.js"></script>
</body>

</html>