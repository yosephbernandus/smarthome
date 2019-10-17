<?php
date_default_timezone_set('Asia/Makassar');

 $host = "localhost";
 $user = "root";
 $pass = "Yoseph_be1509";
 $db   = "tugasakhir";
 $koneksi = mysqli_connect($host, $user, $pass, $db);
 if(mysqli_connect_errno()){
  echo "Gagal Terhubung ".mysqli_connect_error();
 }
 ?>
