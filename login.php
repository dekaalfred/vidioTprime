<?php
session_start();
include 'koneksi.php'; // pastikan file koneksi ke database ada

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
$cek = mysqli_num_rows($query);

if ($cek > 0) {
  $_SESSION['username'] = $username;
  echo json_encode(['status' => 'success', 'message' => 'Login berhasil']);
} else {
  echo json_encode(['status' => 'error', 'message' => 'Username atau password salah']);
}
?>
