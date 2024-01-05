<?php
include "../Model/db.php";
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
                      <p class="mb-0 fs-3"></p>
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
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-outline-primary m-1 mb-2" data-bs-toggle="modal" data-bs-target="#modalAdd">
                      <i class="ti ti-plus fs-6"></i>
                    </button>
                    <table class="table table-bordered table-striped table-hover">
                      <thead>
                        <tr>
                          <th>NO</th>
                          <th>NIP</th>
                          <th>USERNAME</th>
                          <th>LEVEL</th>
                          <th>AKSI</th>
                        </tr>
                      </thead>
                      <?php
                      $sql = "SELECT * FROM petugas order by id_petugas DESC";
                      $query = sqlsrv_query($conn, $sql);
                      $num = 1;
                      while ($data = sqlsrv_fetch_array($query)) {
                      ?>

                        <tr>
                          <td><?php echo $num++; ?></td>
                          <td><?php echo $data['nip']; ?></td>
                          <td><?php echo $data['username']; ?></td>
                          <td><?php echo $data['level_user']; ?></td>
                          <td>
                            <a href="#" class="btn btn-outline-warning m-1" data-bs-toggle="modal" data-bs-target="#modalUpdate<?php echo $num ?>"><i class="ti ti-pencil fs-6"></i></a>
                            <a href="#" class="btn btn-outline-danger m-1" data-bs-toggle="modal" data-bs-target="#modalDelete<?php echo $num ?>"><i class="ti ti-trash fs-6"></i></a>
                          </td>
                        </tr>

                        <!-- Modal hapus -->
                        <div class="modal fade" id="modalDelete<?php echo $num ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h1 class="modal-title fs-6 text-centered" id="staticBackdropLabel">Konfirmasi Hapus User</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <div class="card-body">
                                  <form action="../Controller/UserController.php" method="post">
                                    <input type="text" value="<?php echo $data['id_petugas']; ?>" name="id_petugas" hidden>
                                    <div class="mb-3">
                                      <h5 class="text-center text-danger">Yakin menghapus user <?php echo $data['nip'] ?> - <?php echo $data['username'] ?></h5>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="nutton" class="btn btn-danger m1">Batal</button>
                                      <button type="submit" class="btn btn-secondary m1" name="bdelete">Hapus User</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- end modal hapus -->

                        <!-- modal ubah -->
                        <div class="modal fade modal-lg" id="modalUpdate<?php echo $num ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h1 class="modal-title fs-6 text-centered" id="staticBackdropLabel">Ubah User</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <div class="card-body">
                                  <form action="../Controller/UserController.php" method="post">
                                    <input type="hidden" name="id_petugas" id="id_petugas" value="<?php echo $data['id_petugas']; ?>">
                                    <div class="mb-3">
                                      <label for="nip" class="form-label">NIP</label>
                                      <input type="text" class="form-control" id="nip" aria-describedby="nip" name="nip" value="<?php echo $data['nip']; ?>">
                                    </div>
                                    <div class="mb-3">
                                      <label for="username" class="form-label">Username</label>
                                      <input type="username" class="form-control" id="username" name="username" value="<?php echo $data['username']; ?>">
                                    </div>
                                    <div class="mb-3">
                                      <label for="password" class="form-label">Password</label>
                                      <input type="text" class="form-control" id="password" name="password" value="<?php echo $data['pwd']; ?>">
                                    </div>
                                    <div class="mb-3">
                                      <label for="level" class="form-label">Level</label>
                                      <Select id="level" class="form-select" name="level">
                                        <option value="<?php echo $data['level_user']; ?>" selected><?php echo $data['level_user']; ?></option>
                                        <option value="Admin">Admin</option>
                                        <option value="Petugas">Petugas</option>
                                      </Select>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-danger m1" data-bs-dismiss="modal">Keluar</button>
                                      <button type="submit" class="btn btn-success m1" name="bupdate">Simpan</button>
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

  <!-- Modal Add-->
  <div class="modal fade modal-lg" id="modalAdd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-6 text-centered" id="staticBackdropLabel">Tambah User</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="card-body">
            <form action="../Controller/UserController.php" method="post">
              <div class="mb-3">
                <label for="nip" class="form-label">NIP</label>
                <input type="text" class="form-control" id="nip" aria-describedby="nip" name="nip">
              </div>
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="username" class="form-control" id="username" name="username">
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
              </div>
              <div class="mb-3">
                <label for="level" class="form-label">Level</label>
                <Select id="level" class="form-select" name="level">
                  <option value="" selected>Pilih</option>
                  <option value="Admin">Admin</option>
                  <option value="Petugas">Petugas</option>
                </Select>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger m1" data-bs-dismiss="modal">Keluar</button>
                <button type="submit" class="btn btn-success m1" name="bsimpan">Simpan</button>
              </div>
            </form>
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