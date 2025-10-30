<?php
include 'db.php';

// Ambil credential dari Google One Tap
$data = json_decode(file_get_contents('php://input'));
if (!$data || !isset($data->credential)) {
    echo json_encode(["message" => "Data tidak valid!"]);
    exit;
}
$credential = $data->credential;

// Decode JWT Google secara manual (tanpa verifikasi signature)
function decode_jwt($jwt) {
    $parts = explode('.', $jwt);
    if (count($parts) != 3) return false;
    $payload = $parts[1];
    $payload = str_replace(['-', '_'], ['+', '/'], $payload);
    $payload = base64_decode(str_pad($payload, strlen($payload) % 4 ? strlen($payload) + 4 - strlen($payload) % 4 : strlen($payload), '=', STR_PAD_RIGHT));
    return json_decode($payload, true);
}

$payload = decode_jwt($credential);
if ($payload && isset($payload['name'])) {
    $username = $payload['name'];
    // Cek apakah user sudah ada
    $stmt = $conn->prepare("SELECT * FROM database WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo json_encode(["message" => "Login Google berhasil!"]);
    } else {
        $google_pass = "GOOGLE";
        $stmt = $conn->prepare("INSERT INTO database (username, pasword) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $google_pass);
        if ($stmt->execute()) {
            echo json_encode(["message" => "Akun Google berhasil dibuat dan login!"]);
        } else {
            echo json_encode(["message" => "Gagal register Google: " . $conn->error]);
        }
    }
} else {
    echo json_encode(["message" => "Token Google tidak valid!"]);
}
$conn->close();
?>