<?php

$serverName = "localhost";
$connectionOptions = array(
  "database" => "pengaduandb",
  "uid" => "sa",
  "pwd" => "Aquarius1"
);
$conn = sqlsrv_connect($serverName, $connectionOptions);
if (!$conn) {
  echo "<script>alert('Failed Connected')</script>;";
  die(print_r(sqlsrv_errors(), true));
}
