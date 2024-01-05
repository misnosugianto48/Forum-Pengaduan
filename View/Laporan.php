<?php
// Include file koneksi dan fungsi tambahan jika diperlukan
include "./Model/db.php"; // Sesuaikan dengan nama file koneksi Anda

// Query untuk mendapatkan data pengaduan yang sudah ditanggapi
$sql = "SELECT tanggapan.*, pengaduan.judul, pengaduan.isi_pengaduan, pengaduan.tanggal_pengaduan
        FROM tanggapan
        INNER JOIN pengaduan ON tanggapan.id_pengaduan = pengaduan.id_pengaduan
        WHERE tanggapan.status_tanggapan = 'Done'
        ORDER BY tanggapan.tanggal_tanggapan DESC";

$result = mysqli_query($koneksi, $sql);

// Inisialisasi data untuk tampilan cetak
$data = array();

while ($row = mysqli_fetch_assoc($result)) {
  $data[] = $row;
}

// Tutup koneksi
mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Pengaduan yang Sudah Ditanggapi</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    table {
      border-collapse: collapse;
      width: 100%;
    }

    th,
    td {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }

    th {
      background-color: #f2f2f2;
    }
  </style>
</head>

<body>
  <h2>Laporan Pengaduan yang Sudah Ditanggapi</h2>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Judul Pengaduan</th>
        <th>Isi Pengaduan</th>
        <th>Tanggal Pengaduan</th>
        <th>Isi Tanggapan</th>
        <th>Tanggal Tanggapan</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($data as $row) : ?>
        <tr>
          <td><?php echo $row['id_tanggapan']; ?></td>
          <td><?php echo $row['judul']; ?></td>
          <td><?php echo $row['isi_pengaduan']; ?></td>
          <td><?php echo $row['tanggal_pengaduan']; ?></td>
          <td><?php echo $row['isi_tanggapan']; ?></td>
          <td><?php echo $row['tanggal_tanggapan']; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <script>
    // Panggil fungsi cetak bawaan browser
    window.print();
  </script>
</body>

</html>