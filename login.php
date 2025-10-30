<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "xpplg5");

// Cek koneksi
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}
include 'db.php';

// Validasi input
if (!isset($_POST['username']) || !isset($_POST['password'])) {
    die("Data tidak lengkap! Silakan isi username dan password.");
}

$username = trim($_POST['username']);
$password = $_POST['password'];

if ($username === '' || $password === '') {
    die("Username dan password tidak boleh kosong!");
}

// Cek apakah user sudah ada
$stmt = $mysqli->prepare("SELECT * FROM database WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Login
    $row = $result->fetch_assoc();
    if ($row['password'] === 'GOOGLE') {
        die("Akun ini hanya bisa login dengan Google!");
    } elseif (password_verify($password, $row['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $row['username'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['logged_in'] = true;
        
        // Redirect ke halaman utama
        header("Location: index.php");
        exit();
    } else {
        die("Password yang Anda masukkan salah!");
    }
} else {
    // User belum terdaftar
    die("Akun tidak ditemukan. Silakan daftar terlebih dahulu.");
}
$conn->close();
?>