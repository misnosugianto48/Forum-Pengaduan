<?php

include "../../Model/db.php";
session_start();

// post

try {
  if (isset($_POST['bsimpan'])) {

    // input validasi
    $tglPengaduan = date('Y-m-d', strtotime($_POST['tgl_pengaduan']));

    $params = array(
      $_SESSION['id_mahasiswa'],
      $_POST['judul'],
      $_POST['isi_pengaduan'],
      $_POST['tgl_pengaduan']
    );

    if (!$_SESSION['id_mahasiswa']) {
      throw new Exception("Missing id");
    }
    // validasi inputan kosong
    if (!$_POST['judul'] || !$_POST['isi_pengaduan'] || !$_POST['tgl_pengaduan']) {
      throw new Exception("Semua field harus diisi");
    }

    // validasi panjang karakter
    if (strlen($_POST['isi_pengaduan']) < 10) {
      throw new Exception("Pengaduan kurang detail!!");
    }

    if (strlen($_POST['judul']) > 50) {
      throw new Exception("Judul Terlalu Panjang!!");
    }

    $query = "INSERT INTO pengaduan (id_mahasiswa, judul, isi_pengaduan, tanggal_pengaduan) VALUES (?, ?, ?, ?)";

    $simpan = sqlsrv_query($conn, $query, $params);
    if ($simpan === false) {
      throw new Exception(print_r(sqlsrv_errors(), true));
    } else {
      echo "<script>
              alert('Data berhasil ditambah');
              window.location = '../../View/Mahasiswa/Pengaduan-Mahasiswa.php';
              </script>";
    }
  }
} catch (Exception $e) {
  echo "<script>
      alert('Terjadi kesalahan: " . $e->getMessage() . "');
      document.location = '../../View/Mahasiswa/Pengaduan-Mahasiswa.php';
      </script>";
}

// update
try {
  if (isset($_POST['bupdate'])) {

    // input validasi
    $tglPengaduan = date('Y-m-d', strtotime($_POST['tanggal_pengaduan']));

    $params = array(
      $_SESSION['id_mahasiswa'],
      $_POST['judul'],
      $_POST['isi_pengaduan'],
      $_POST['tanggal_pengaduan'],
      $_POST['id_pengaduan']
    );

    if (!$_SESSION['id_mahasiswa']) {
      throw new Exception("Missing id");
    }
    // validasi inputan kosong
    if (!$_POST['judul'] || !$_POST['isi_pengaduan'] || !$_POST['tanggal_pengaduan']) {
      throw new Exception("Semua field harus diisi");
    }

    // validasi panjang karakter
    if (strlen($_POST['isi_pengaduan']) < 10) {
      throw new Exception("Pengaduan kurang detail!!");
    }

    if (strlen($_POST['judul']) > 50) {
      throw new Exception("Judul Terlalu Panjang!!");
    }

    $query = "UPDATE pengaduan SET id_mahasiswa = ?, judul = ?, isi_pengaduan = ?, tanggal_pengaduan = ? WHERE id_pengaduan = ?";

    // var_dump($_POST['id_pengaduan']);
    $simpan = sqlsrv_query($conn, $query, $params);
    // var_dump($params);
    if ($simpan === false) {

      throw new Exception(print_r(sqlsrv_errors(), true));
    } else {
      echo "<script>
              alert('Data berhasil diupdate');
              window.location = '../../View/Mahasiswa/Pengaduan-Mahasiswa.php';
              </script>";
    }
  }
} catch (Exception $e) {
  echo "<script>
      alert('Terjadi kesalahan: " . $e->getMessage() . "');
      document.location = '../../View/Mahasiswa/Pengaduan-Mahasiswa.php';
      </script>";
}


// delete
try {
  if (isset($_POST['bdelete'])) {
    $query = "DELETE FROM pengaduan WHERE id_pengaduan = ?";

    $params = array($_POST['id_pengaduan']);

    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
      throw new Exception(print_r(sqlsrv_errors(), true));
    } else {
      echo "<script>
          alert('Data berhasil dihapus');
          window.location = '../../View/Mahasiswa/Pengaduan-Mahasiswa.php';
          </script>";
    }
  }
} catch (Exception $e) {
  echo "<script>
  alert('Terjadi kesalahan: " . $e->getMessage() . "');
  document.location = '../../View/Mahasiswa/Pengaduan-Mahasiswa.php';
  </script>";
}
