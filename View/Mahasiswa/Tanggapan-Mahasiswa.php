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
  <title>Pengaduan</title>
  <link rel="stylesheet" href="../../assets/css/styles.min.css" />
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
                      <p class="mb-0 fs-3"><?php print_r($_SESSION['username']); ?> - ID <?php print_r($_SESSION['id_mahasiswa']); ?></p>
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
                          <th>JUDUL</th>
                          <th>PETUGAS</th>
                          <th>DITANGGAPI</th>
                          <th>ISI</th>
                        </tr>
                      </thead>
                      <?php
                      $sql = "SELECT tanggapan.*, pengaduan.judul, petugas.username
                      FROM tanggapan
                      LEFT JOIN pengaduan ON tanggapan.id_pengaduan = pengaduan.id_pengaduan
                      LEFT JOIN petugas ON tanggapan.id_petugas = petugas.id_petugas
                      WHERE pengaduan.id_mahasiswa = ?";

                      $params = array($id_mahasiswa_login);
                      $stmt = sqlsrv_query($conn, $sql, $params);
                      $num = 1;
                      while ($data = sqlsrv_fetch_array($stmt)) {
                      ?>
                        <tr>
                          <td><?php echo $num++; ?></td>
                          <td><?php echo $data['judul']; ?></td>
                          <td><?php echo $data['username']; ?></td>
                          <td><?php echo $data['tanggal_tanggapan']; ?></td>
                          <td>
                            <a href="#" class="btn btn-outline-success m-1" data-bs-toggle="modal" data-bs-target="#modalView<?php echo $num; ?>"><i class="ti ti-eye fs-6"></i></a>
                          </td>
                        </tr>

                        <!-- modal view -->
                        <div class="modal fade modal-lg" id="modalView<?php echo $num ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h1 class="modal-title fs-6 text-centered" id="staticBackdropLabel">Lihat tanggapan</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <div class="card-body">
                                  <form>
                                    <input type="hidden" name="id_tanggapan" id="id_tanggapan" value="<?php echo $data['id_tanggapan']; ?>">
                                    <div class="mb-3">
                                      <textarea name="isi_pengaduan" id="isi_pengaduan" cols="30" rows="10" class="form-control"><?php echo $data['isi_tanggapan'] ?></textarea>
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
  <script src="../../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/js/sidebarmenu.js"></script>
  <script src="../../assets/js/app.min.js"></script>
  <script src="../../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../../assets/js/dashboard.js"></script>
</body>

</html>