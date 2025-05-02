<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cbt3";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data dari formulir login
$nama = $_POST['nama'];
$password = $_POST['pass'];

// Query untuk memeriksa keberadaan pengguna
$sql = "SELECT * FROM adminlog WHERE nama='$nama' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Login berhasil
    header( 'Location: form-admin.php?status=sukses' );
} else {
    // Login gagal
    echo "Username atau password salah.";
}

// Tutup koneksi database
$conn->close();
?>
