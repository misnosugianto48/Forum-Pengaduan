<?php
session_start();

function checkLogin($conn, $username, $password, $userType)
{
  $tableName = '';

  switch ($userType) {
    case 'Admin':
      $tableName = 'admin';
      break;
    case 'Petugas':
      $tableName = 'petugas';
      break;
    case 'Mahasiswa':
      $tableName = 'mahasiswa';
      break;
    default:
      return false;
  }

  $sql = "SELECT * FROM $tableName WHERE username = ? AND pwd = ?";
  $params = array($username, $password);
  $stmt = sqlsrv_query($conn, $sql, $params);

  if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
  }

  $row = sqlsrv_fetch_array($stmt);

  if ($row) {
    $_SESSION['id_user'] = $row["id_$userType"];
    $_SESSION['username'] = $row['username'];
    $_SESSION['level_user'] = $row['level_user'];

    return true;
  } else {
    return false;
  }
}

// Proses login
// Proses login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include "./Model/db.php";
  $username = $_POST['username'];
  $pwd = $_POST['password'];
  $userType = $_POST['userType'];

  if (checkLogin($conn, $username, $pwd, $userType)) {
    // Redirect ke halaman sesuai level jika login sukses
    if ($_SESSION['level_user'] == 'Admin') {
      header("Location: ./View/Index.php");
    } elseif ($_SESSION['level_user'] == 'Petugas') {
      header("Location: ./View/Petugas/Index-Petugas.php");
    } elseif ($_SESSION['level_user'] == 'Mahasiswa') {
      header("Location: ./View/Mahasiswa/Index-Mahasiswa.php");
    } else {
      // Level tidak valid, sesuaikan dengan kebutuhan Anda
      echo "<script>
                  alert('Level tidak valid');
                  window.location = 'Login.php';
                  </script>";
    }
    exit();
  } else {
    echo "<script>
          alert('Periksa username, password, dan jenis pengguna');
          window.location = 'Login.php';
          </script>";
  }
}

// Setelah proses login berhasil
if (isset($_SESSION['id_user'])) {
  // Redirect ke halaman sesuai dengan level jika sudah login
  if ($_SESSION['level_user'] == 'Admin') {
    header("Location: ./View/Index.php");
  } elseif ($_SESSION['level_user'] == 'Petugas') {
    header("Location: ./View/Petugas/Index-Petugas.php");
  } elseif ($_SESSION['level_user'] == 'Mahasiswa') {
    header("Location: ./View/Mahasiswa/Index-Mahasiswa.php");
  }
  exit();
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pustaka RWP</title>
  <link rel="stylesheet" href="./assets/css/styles.min.css" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="#" class="text-nowrap text-center d-block py-3 w-100">
                  <h3 class="text-secondary">Login<i class="ti ti-login"></i></h3>
                </a>
                <form role="form" method="post">
                  <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" aria-describedby="emailHelp" name="username" required>
                  </div>
                  <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                  </div>
                  <div class="mb-3">
                    <label for="userType" class="form-label">User Type</label>
                    <select class="form-select" id="userType" name="userType" required>
                      <option value="Admin">Admin</option>
                      <option value="Petugas">Petugas</option>
                      <option value="Mahasiswa">Mahasiswa</option>
                    </select>
                  </div>
                  <input value="Sign in" type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2" name="login">
                </form>

                <div class="d-flex align-items-center justify-content-center">
                  <p class="fs-4 mb-0 fw-bold">New to User?</p>
                  <a class="text-primary fw-bold ms-2" href="./Register.php">Create an account</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src=" ./assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="./assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>