<?php
session_start();

function checkLogin($username, $password)
{
  include "db.php";

  $sql = "SELECT * FROM tb_user WHERE username = '$username' AND pwd = '$pwd'";
  $params = array($username, $pwd);
  $stmt = sqlsrv_query($conn, $sql, $params);

  if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
  }

  $row = sqlsrv_fetch_array($stmt);

  if ($row) {
    $_SESSION['id_user'] = $row['id_user'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['lvl'] = $row['lvl'];

    return true;
  } else {
    return false;
  }
}

// Proses login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $pwd = $_POST['password'];

  if (checkLogin($username, $pwd)) {
    // Redirect ke halaman admin jika login sukses
    if ($_SESSION['lvl'] == 'Admin') {
      header("Location: index.php");
      exit();
    } else {
      header("Location: login.php");
      exit();
    }
  } else {
    echo "<script>
    alert('Periksa username dan passwordmu');
    </script>";
  }
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
                  <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
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