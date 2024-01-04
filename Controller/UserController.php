<?php
include "../db.php";

// post
if (isset($_POST['bsimpan'])) {
  // input validasi
  $nip = $_POST['nip'];
  $nama = $_POST['nama'];
  $password = $_POST['password'];

  // validasi inputan kosong

  $query = "INSERT INTO petugas (nip, nama, password) VALUES (?, ?, ?)";

  $params = array($_POST['nip'], $_POST['nama'], $_POST['password']);

  $simpan = sqlsrv_query($conn, $query, $params);

  if ($simpan === false) {
    echo "<script>
        alert('Data gagal ditambah');
        document.location = '../user.php';
        </script>";
    die(print_r(sqlsrv_errors(), true));
  } else {
    echo "<script>
        alert('Data berhasil ditambah');
        window.location = '../user.php';
        </script>";
  }
}

// update
if (isset($_POST['bupdate'])) {

  $query = "UPDATE tb_user SET username = ?, pwd = ?, nama = ?, jk = ?, nohp = ?, lvl = ? 
            WHERE id_user = ?";

  $params = array($_POST['username'], $_POST['password'], $_POST['nama'], $_POST['jenisKelamin'], $_POST['notelepon'], $_POST['level'], $_POST['id_user']);

  $stmt = sqlsrv_query($conn, $query, $params);

  if ($stmt === false) {
    echo "<script>
        alert('Data gagal diubah');
        document.location = '../user.php';
        </script>";
    die(print_r(sqlsrv_errors(), true));
  } else {
    echo "<script>
        alert('Data berhasil diubah');
        document.location = '../user.php';
        </script>";
  }
}

// delete
if (isset($_POST['bdelete'])) {

  // Perbaiki kesalahan penulisan variabel $query
  $query = "DELETE FROM tb_user WHERE id_user = ?";

  // Siapkan parameter untuk mencegah SQL injection
  $params = array($_POST['id_user']);

  // Jalankan query dengan parameter
  $stmt = sqlsrv_query($conn, $query, $params);

  if ($stmt === false) {
    echo "<script>
        alert('Data gagal dihapus');
        window.location = '../user.php';
        </script>";
    die(print_r(sqlsrv_errors(), true));
  } else {
    echo "<script>
        alert('Data berhasil dihapus');
        window.location = '../user.php';
        </script>";
  }
}
