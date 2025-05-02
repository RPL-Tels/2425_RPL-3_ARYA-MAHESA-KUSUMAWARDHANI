<?php
include("config.php");

// Set base directory path
$baseDir = $_SERVER['DOCUMENT_ROOT'] . '/Hapus-BG/app/Admin/';
$uploadDir = $baseDir . 'downloads/';

// Create directory if not exists
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Get POST data
$namaFile = $_POST['filename'];
$imageData = $_POST['imagedata'];

// Process image data
$imageData = str_replace('data:image/png;base64,', '', $imageData);
$imageData = str_replace(' ', '+', $imageData);
$imageBinary = base64_decode($imageData);

// Generate unique filename
$filename = uniqid('img_') . '.png';
$gambarPath = $uploadDir . $filename;

// Save image file
file_put_contents($gambarPath, $imageBinary);

// Prepare path for database
$webPath = "/Hapus-BG/app/Admin/downloads/" . $filename;

// Save to database
$tanggalWaktu = date('Y-m-d H:i:s');
$sql = "INSERT INTO history1 (nama, tanggal, gambar) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt, "sss", $namaFile, $tanggalWaktu, $webPath);
mysqli_stmt_execute($stmt);

// Response
echo json_encode([
    'status' => 'success',
    'message' => 'Image saved successfully',
    'file_path' => $webPath
]);
?>