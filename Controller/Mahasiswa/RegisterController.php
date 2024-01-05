<?php

include "../../Model/db.php";

// register
// post
try {
  if (isset($_POST['bregister'])) {
    // input validasi
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // validasi inputan kosong
    if (!$nama || !$nim || !$email || !$username || !$password) {
      throw new Exception("Semua field harus diisi");
    }

    // validasi panjang karakter
    if (strlen($nim) > 10) {
      throw new Exception("NIM Terlalu Panjang!!");
    }

    if (strlen($nama) > 20) {
      throw new Exception("username Terlalu Panjang!!");
    }

    if (strlen($email) > 30) {
      throw new Exception("email Terlalu Panjang!!");
    }

    if (strlen($username) > 30) {
      throw new Exception("username Terlalu Panjang!!");
    }

    if (strlen($password) < 5) {
      throw new Exception("Panjang Password kurang dari 8");
    } elseif (strlen($password) > 10) {
      throw new Exception("Password terlalu panjang");
    }

    // var_dump($nama, $nim, $email, $password);
    $query = "INSERT INTO mahasiswa ( nama, nim, email,username, pwd) VALUES (?, ?, ?,?, ?)";

    $params = array($nama, $nim, $email, $username, $password);

    $simpan = sqlsrv_query($conn, $query, $params);
    var_dump($simpan);
    if ($simpan === false) {
      print_r(sqlsrv_errors(), true);
    } else {
      echo "<script>
              alert('Register berhasil');
              </script>";
      header("Location: ../../View/Mahasiswa/Index-Mahasiswa.php");
    }
  }
} catch (Exception $e) {
  echo "<script>
      alert('Terjadi kesalahan: " . $e->getMessage() . "');
      document.location = '../../Register.php';
      </script>";
}
