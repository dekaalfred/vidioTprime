<?php
$host = "localhost";
$user = "root";
$pass = ""; // ganti sesuai password MySQL kamu
$db   = "xpplg5";
 
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>