<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "dkafilmnew"; // <--- ini harus sama persis seperti di phpMyAdmin

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>

