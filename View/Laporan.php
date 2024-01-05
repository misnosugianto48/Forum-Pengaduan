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
  <title>Pengaduan</title>
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
</head>

<body>
  <!--  Row 1 -->
  <div class="container">
    <div class="card-body">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body">
              <table class="table table-bordered table-striped table-hover">
                <h4 class="text-center mb-3">Laporan Pengaduan Yang Ditanggapi</h4>
                <thead>
                  <tr>
                    <th>NO</th>
                    <th>ID</th>
                    <th>Judul Pengaduan</th>
                    <th>Isi Pengaduan</th>
                    <th>Tanggal Pengaduan</th>
                    <th>Isi Tanggapan</th>
                    <th>Tanggal Tanggapan</th>
                    <th>Petugas</th>
                  </tr>
                </thead>
                <?php
                $sql = "SELECT tanggapan.*, pengaduan.judul, pengaduan.isi_pengaduan, pengaduan.tanggal_pengaduan, petugas.username,
                  pengaduan.status_pengaduan FROM tanggapan
                  INNER JOIN pengaduan ON tanggapan.id_pengaduan = pengaduan.id_pengaduan
                  INNER JOIN petugas ON tanggapan.id_petugas = petugas.id_petugas
                  WHERE pengaduan.status_pengaduan = 'Done'
                  ORDER BY tanggapan.tanggal_tanggapan DESC";
                $query = sqlsrv_query($conn, $sql);
                $num = 1;
                while ($data = sqlsrv_fetch_array($query)) {
                ?>
                  <tr>
                    <td><?php echo $num++; ?></td>
                    <td><?php echo $data['id_pengaduan']; ?></td>
                    <td><?php echo $data['judul']; ?></td>
                    <td><?php echo $data['isi_pengaduan']; ?></td>
                    <td><?php echo $data['tanggal_pengaduan']; ?></td>
                    <td><?php echo $data['isi_tanggapan']; ?></td>
                    <td><?php echo $data['tanggal_tanggapan']; ?></td>
                    <td><?php echo $data['username']; ?></td>
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
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../assets/js/dashboard.js"></script>
  <script>
    window.print();
  </script>
</body>

</html>