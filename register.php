<?php
include 'db.php';

if (!isset($_POST['username']) || !isset($_POST['password'])) {
    die("Data tidak lengkap!");
}

$username = trim($_POST['username']);
$password = $_POST['password'];

if ($username === '' || $password === '') {
    die("Username dan password tidak boleh kosong!");
}

// Cek apakah user sudah ada
$stmt = $conn->prepare("SELECT * FROM database WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die("Username sudah terdaftar. Silakan login.");
} else {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO database (username, pasword) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed);
    if ($stmt->execute()) {
        die("Akun berhasil dibuat! Silakan login.");
    } else {
        die("Gagal register: " . $conn->error);
    }
}
$conn->close();
?>