<?php
session_start();
include "../Model/db.php";
if (!isset($_SESSION['username'])) {
  header("location: ../../Login.php");
  exit();
}
$id_admin_login = $_SESSION['id_admin']; // Sesuaikan dengan variabel sesi yang Anda gunakan

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pengaduan Mahasiswa</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
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
              <a class="sidebar-link" href="./Index.php" aria-expanded="false">
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
              <a class="sidebar-link" href="./User.php" aria-expanded="false">
                <span>
                  <i class="ti ti-user"></i>
                </span>
                <span class="hide-menu">User</span>
              </a>
              <a class="sidebar-link" href="./Pengaduan.php" aria-expanded="false">
                <span>
                  <i class="ti ti-alert-circle"></i>
                </span>
                <span class="hide-menu">Pengaduan</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./Tanggapan.php" aria-expanded="false">
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
                  <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3"><?php print_r($_SESSION['username']); ?> - ID <?php print_r($_SESSION['id_admin']); ?></p>
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
                    <h5 class="card-title fw-semibold">Pengaduan Terbaru</h5>
                    <table class="table text-nowrap mb-0 align-middle>
                      <thead class=" text-dark fs-4">
                      <tr>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Mahasiswa</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Judul</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Dibuat</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Status</h6>
                        </th>
                      </tr>
                      </thead>
                      <?php
                      $sql = "SELECT pengaduan.*, mahasiswa.nama
                      FROM pengaduan 
                      LEFT JOIN mahasiswa ON pengaduan.id_mahasiswa = mahasiswa.id_mahasiswa
                      WHERE status_pengaduan = 'On Progress'
                      ORDER BY tanggal_pengaduan DESC";

                      $stmt = sqlsrv_query($conn, $sql);
                      $num = 1;
                      while ($data = sqlsrv_fetch_array($stmt)) {
                      ?>
                        <tr>
                          <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0"><?php echo $data['nama']; ?></h6>
                          </td>
                          <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0"><?php echo $data['judul']; ?></h6>
                          </td>
                          <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0"><?php echo $data['tanggal_pengaduan']; ?></h6>
                          </td>
                          <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0 text-warning"><?php echo $data['status_pengaduan']; ?></h6>
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
                        $sql = "SELECT COUNT(*) AS total_pengaduan from pengaduan";

                        // Eksekusi pernyataan SQL dengan parameter ID mahasiswa login
                        $params = array($id_petugas_login);
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
                        <h5 class="card-title mb-9 fw-semibold"> Total Petugas </h5>
                        <?php
                        $sql = "SELECT COUNT(*) AS total_petugas  FROM petugas";

                        $stmt = sqlsrv_query($conn, $sql);
                        $num = 1;
                        while ($data = sqlsrv_fetch_array($stmt)) {
                        ?>
                          <h4 class="fw-semibold mb-3"><?php echo  $data['total_petugas']; ?></h4>
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
                  <h5 class="card-title fw-semibold">Tanggapan Terakhir</h5>
                </div>
                <?php
                $sql = "SELECT TOP 5 tanggapan.*, pengaduan.judul, pengaduan.tanggal_pengaduan,
                petugas.username
                FROM tanggapan
                INNER JOIN pengaduan ON tanggapan.id_pengaduan = pengaduan.id_pengaduan
                INNER JOIN petugas ON tanggapan.id_petugas = petugas.id_petugas
                ORDER BY tanggal_tanggapan DESC 
                ";

                $stmt = sqlsrv_query($conn, $sql);
                while ($data = sqlsrv_fetch_array($stmt)) {
                  # code...
                ?>
                  <ul class="timeline-widget mb-0 position-relative mb-n5">
                    <li class="timeline-item d-flex position-relative overflow-hidden">
                      <div class="timeline-time text-dark flex-shrink-0 text-end"><?php echo $data['tanggal_tanggapan']; ?></div>
                      <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                        <span class="timeline-badge border-2 border border-primary flex-shrink-0 my-8"></span>
                        <span class="timeline-badge-border d-block flex-shrink-0"></span>
                      </div>
                      <div class="timeline-desc fs-3 text-dark mt-n1"><?php echo $data['judul']; ?><a href="javascript:void(0)" class="text-primary d-block fw-normal"><?php echo $data['username']; ?></a></div>
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
                <h5 class="card-title fw-semibold mb-4">Tanggapan Terakhir</h5>
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
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Tanggapan</h6>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sql = "SELECT TOP 5 tanggapan.*, pengaduan.judul, pengaduan.isi_pengaduan, pengaduan.tanggal_pengaduan FROM tanggapan
                      INNER JOIN pengaduan ON tanggapan.id_pengaduan = pengaduan.id_pengaduan
                      ORDER BY tanggapan.tanggal_tanggapan DESC";

                      $params = array($id_petugas_login);
                      $stmt = sqlsrv_query($conn, $sql, $params);
                      $num = 1;
                      while ($data = sqlsrv_fetch_array($stmt)) {
                      ?>
                        <tr>
                          <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0"><?php echo $data['id_tanggapan']; ?></h6>
                          </td>
                          <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0"><?php echo $data['judul']; ?></h6>
                          </td>
                          <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0"><?php echo $data['tanggal_tanggapan']; ?></h6>
                          <td class="border-bottom-0">
                            <a href="#" class="btn btn-outline-success fw-semibold mb-0 fs-2" data-bs-toggle="modal" data-bs-target="#modalView<?php echo $data['id_tanggapan']; ?>"><i class="ti ti-eye fs-4"></i></a>
                          </td>

                          <!-- modal view -->
                          <div class="modal fade modal-lg" id="modalView<?php echo $data['id_tanggapan'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h1 class="modal-title fs-6 text-centered" id="staticBackdropLabel">Lihat tanggapan</h1>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <div class="card-body">
                                    <form>
                                      <div class="mb-3">
                                        <textarea name="isi_pengaduan" id="isi_pengaduan" cols="30" rows="10" class="form-control" readonly><?php echo $data['isi_tanggapan'] ?></textarea>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-danger m1" data-bs-dismiss="modal">Keluar</button>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
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
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../assets/js/dashboard.js"></script>
</body>

</html>