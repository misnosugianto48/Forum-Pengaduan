<?php

session_start();
$_SESSION['id_user'] = '';
$_SESSION['username'] = '';
$_SESSION['password'] = '';
session_destroy();
header("location: ../Login.php");
