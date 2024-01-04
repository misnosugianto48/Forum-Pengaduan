<?php
include "../Model/db.php";

// post
try {
  if (isset($_POST['bsimpan'])) {
    // input validasi
    $nip = $_POST['nip'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = $_POST['level'];

    // validasi inputan kosong
    if (!$nip || !$username || !$password || !$level) {
      throw new Exception("Semua field harus diisi");
    }

    // validasi panjang karakter
    if (strlen($nip) > 10) {
      throw new Exception("NIP Terlalu Panjang!!");
    }

    if (strlen($username) > 20) {
      throw new Exception("username Terlalu Panjang!!");
    }

    if (strlen($password) < 5) {
      throw new Exception("Panjang Password kurang dari 8");
    } elseif (strlen($password) > 10) {
      throw new Exception("Password terlalu panjang");
    }

    // var_dump($nip, $username, $password);
    $query = "INSERT INTO petugas(nip, username, pwd, level_user) VALUES (?, ?, ?, ?)";

    $params = array($nip, $username, $password, $level);

    $simpan = sqlsrv_query($conn, $query, $params);
    var_dump($simpan);
    if ($simpan === false) {
      throw new Exception(print_r(sqlsrv_errors(), true));
    } else {
      echo "<script>
              alert('Data berhasil ditambah');
              window.location = '../View/User.php';
              </script>";
    }
  }
} catch (Exception $e) {
  echo "<script>
      alert('Terjadi kesalahan: " . $e->getMessage() . "');
      document.location = '../View/User.php';
      </script>";
}


// update
try {
  if (isset($_POST['bupdate'])) {
    $nip = $_POST['nip'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = $_POST['level'];

    // validasi inputan kosong
    if (!$nip || !$username || !$password) {
      throw new Exception("Semua field harus diisi");
    }

    // validasi panjang karakter
    if (strlen($nip) > 10) {
      throw new Exception("NIP Terlalu Panjang!!");
    }

    if (strlen($username) > 20) {
      throw new Exception("username Terlalu Panjang!!");
    }

    if (strlen($password) < 5) {
      throw new Exception("Panjang Password kurang");
    } elseif (strlen($password) > 10) {
      throw new Exception("Password terlalu panjang");
    }

    $query = "UPDATE petugas SET nip = ?, username = ?, pwd = ?, level_user = ? WHERE id_petugas = ?";

    $params = array($nip, $username, $password, $level, $_POST['id_petugas']);

    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
      throw new (print_r(sqlsrv_errors(), true));
    } else {
      echo "<script>
          alert('Data berhasil diubah');
          document.location = '../View/User.php';
          </script>";
    }
  }
} catch (Exception $e) {
  echo "<script>
  alert('Terjadi kesalahan: " . $e->getMessage() . "');
  document.location = '../View/User.php';
  </script>";
}


// delete
try {
  if (isset($_POST['bdelete'])) {
    $query = "DELETE FROM petugas WHERE id_petugas = ?";

    $params = array($_POST['id_petugas']);

    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
      throw new Exception(print_r(sqlsrv_errors(), true));
    } else {
      echo "<script>
          alert('Data berhasil dihapus');
          window.location = '../View/User.php';
          </script>";
    }
  }
} catch (Exception $e) {
  echo "<script>
  alert('Terjadi kesalahan: " . $e->getMessage() . "');
  document.location = '../View/User.php';
  </script>";
}
