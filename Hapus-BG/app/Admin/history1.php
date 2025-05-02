<?php
// Koneksi ke database
$host = "localhost";
$username = "username_db";
$password = "password_db";
$database = "cbt3";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Fungsi untuk menyimpan data download
function simpanDataDownload($namaFile, $gambarPath) {
    global $conn;
    
    // Mendapatkan tanggal dan waktu sekarang
    $tanggalWaktu = date('Y-m-d H:i:s');
    
    // Menyimpan data ke database
    $sql = "INSERT INTO history1 (nama, tanggal, gambar) VALUES (?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $namaFile, $tanggalWaktu, $gambarPath);
    
    if (mysqli_stmt_execute($stmt)) {
        return true;
    } else {
        return false;
    }
}

// Contoh penggunaan saat file didownload
if (isset($_GET['download'])) {
    $namaFile = basename($_GET['download']);
    $filePath = "path/ke/file/" . $namaFile;
    
    // Path untuk menyimpan gambar (thumbnail/screenshot)
    $gambarPath = "path/ke/gambar/" . uniqid() . ".jpg";
    
    // Simulasikan pengambilan gambar (dalam implementasi nyata bisa dari upload atau generate thumbnail)
    // Contoh sederhana - copy dari sumber tertentu
    copy("path/ke/sumber/gambar.jpg", $gambarPath);
    
    // Simpan data ke database
    if (simpanDataDownload($namaFile, $gambarPath)) {
        // Lanjutkan proses download
        if (file_exists($filePath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($filePath).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
            exit;
        }
    } else {
        echo "Gagal menyimpan data download.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Download File</title>
</head>
<body>
    <h1>Download File</h1>
    
    <!-- Contoh link download -->
    <a href="?download=contoh_file.pdf">Download Contoh File PDF</a>
    <br>
    <a href="?download=dokumen.docx">Download Contoh Dokumen Word</a>
</body>
</html>