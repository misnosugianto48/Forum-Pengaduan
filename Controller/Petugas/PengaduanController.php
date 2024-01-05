<?php
session_start();

include "../../Model/db.php";

try {
  if (isset($_POST['bTanggapi'])) {
    // Input validasi
    $idPetugas = $_SESSION['id_petugas'];
    $idPengaduan = $_POST['id_pengaduan'];
    $isiTanggapan = $_POST['isi_tanggapan'];
    $tanggalTanggapan = date('Y-m-d', strtotime($_POST['tanggal_tanggapan']));

    if (!$idPetugas) {
      throw new Exception("Missing id");
    }

    // Validasi inputan kosong
    if (!$isiTanggapan || !$tanggalTanggapan) {
      throw new Exception("Semua field harus diisi");
    }

    // Update tabel pengaduan
    $queryUpdatePengaduan = "UPDATE pengaduan SET id_petugas = ?, status_pengaduan = 'Done' WHERE id_pengaduan = ?";
    $paramsUpdatePengaduan = array($idPetugas, $idPengaduan);
    $updatePengaduan = sqlsrv_query($conn, $queryUpdatePengaduan, $paramsUpdatePengaduan);

    if ($updatePengaduan === false) {
      throw new Exception(print_r(sqlsrv_errors(), true));
    }

    // Insert ke tabel tanggapan
    $queryInsertTanggapan = "INSERT INTO tanggapan(id_pengaduan, id_petugas, isi_tanggapan, tanggal_tanggapan) VALUES (?, ?, ?, ?)";
    $paramsInsertTanggapan = array($idPengaduan, $idPetugas, $isiTanggapan, $tanggalTanggapan);
    $insertTanggapan = sqlsrv_query($conn, $queryInsertTanggapan, $paramsInsertTanggapan);

    if ($insertTanggapan === false) {
      throw new Exception(print_r(sqlsrv_errors(), true));
    } else {
      echo "<script>
                alert('Tanggapan berhasil disimpan');
                window.location = '../../View/Petugas/Pengaduan-Petugas.php';
                </script>";
    }
  }
} catch (Exception $e) {
  echo "<script>
        alert('Terjadi kesalahan: " . $e->getMessage() . "');
        window.location = '../../View/Petugas/Pengaduan-Petugas.php';
        </script>";
}
