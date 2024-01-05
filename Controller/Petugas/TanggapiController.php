<?php
session_start();

include "../../Model/db.php";

try {
  if (isset($_POST['bTanggapi'])) {

    $idTanggapan = $_POST['id_tanggapan'];
    $isiTanggapan = $_POST['isi_tanggapan'];
    $tanggalTanggapan = $_POST['tanggal_tanggapan'];

    if (!$idTanggapan || !$isiTanggapan || !$tanggalTanggapan) {
      throw new Exception("Semua field harus diisi");
    }

    $idPetugas = $_SESSION['id_petugas'];

    $updateTanggapanQuery = "UPDATE tanggapan SET isi_tanggapan = ?, tanggal_tanggapan = ? WHERE id_tanggapan = ? AND id_petugas = ?";

    $paramsTanggapan = array($isiTanggapan, $tanggalTanggapan, $idTanggapan, $idPetugas);

    $updateTanggapan = sqlsrv_query($conn, $updateTanggapanQuery, $paramsTanggapan);

    if ($updateTanggapan === false) {
      throw new Exception(print_r(sqlsrv_errors(), true));
    }

    echo "<script>
                alert('Tanggapan berhasil diupdate');
                window.location = '../../View/Petugas/Tanggapan-Petugas.php';
                </script>";
  }
} catch (Exception $e) {
  echo "<script>
        alert('Terjadi kesalahan: " . $e->getMessage() . "');
        document.location = '../../View/Petugas/Tanggapan-Petugas.php';
        </script>";
}
