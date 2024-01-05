<?php
session_start();
include "../Model/db.php";
if (!isset($_SESSION['username'])) {
  header("location: ../../Login.php");
  exit();
}
$id_admin = $_SESSION['id_admin']; // Sesuaikan dengan variabel sesi yang Anda gunakan

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pengaduan</title>
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="./Index.php" class="text-nowrap logo-img">
            <h3 class="text-secondary">Pengaduan <i class="ti ti-file-description"></i></h3>
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
            </li>
            <li class="sidebar-item">
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
                      <p class="mb-0 fs-3"><?php print_r($_SESSION['username']); ?></p>
                    </a>
                    <a href="../Controller/LogoutController.php" class="btn btn-outline-danger mx-3 mt-2 d-block">Logout</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
      <!-- Card Start -->
      <!--  Row 1 -->
      <div class="container">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                  </div>
                  <div class="card-body">
                    <table class="table table-bordered table-striped table-hover">
                      <thead>
                        <tr>
                          <th>NO</th>
                          <th>MAHASISWA</th>
                          <th>JUDUL</th>
                          <th>ISI</th>
                          <th>DIBUAT</th>
                          <th>STATUS</th>
                          <th>PETUGAS</th>
                          <th>AKSI</th>
                        </tr>
                      </thead>
                      <?php
                      $sql = "SELECT pengaduan.*, mahasiswa.nama, petugas.username 
                      FROM pengaduan 
                      LEFT JOIN mahasiswa ON pengaduan.id_mahasiswa = mahasiswa.id_mahasiswa
                      LEFt JOIN petugas ON pengaduan.id_petugas = petugas.id_petugas 
                      ORDER BY id_pengaduan DESC";
                      $query = sqlsrv_query($conn, $sql);
                      $num = 1;
                      while ($data = sqlsrv_fetch_array($query)) {
                      ?>
                        <tr>
                          <td><?php echo $num++; ?></td>
                          <td><?php echo $data['nama']; ?></td>
                          <td><?php echo $data['judul']; ?></td>
                          <td><?php echo $data['isi_pengaduan']; ?></td>
                          <td><?php echo $data['tanggal_pengaduan']; ?></td>
                          <td><?php echo $data['status_pengaduan']; ?></td>
                          <td><?php echo $data['username']; ?></td>
                          <td>
                            <a href="#" class="btn btn-outline-warning m-1" data-bs-toggle="modal" data-bs-target="#modalUpdate"><i class="ti ti-pencil fs-6"></i></a>
                            <a href="#" class="btn btn-outline-danger m-1" data-bs-toggle="modal" data-bs-target="#modalDelete"><i class="ti ti-trash fs-6"></i></a>
                          </td>
                        </tr>
                      <?php } ?>
                    </table>
                  </div>
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