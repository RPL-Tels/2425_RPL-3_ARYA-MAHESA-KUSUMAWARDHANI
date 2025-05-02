<?php
include( "config.php");
// cek apakah tombol daftar sudah diklik atau blum?
if(isset($_POST[ 'submit' ])){
 // ambil data dari formulir
 $tanggal = date("d-m-Y");
 $nama = $_POST[ 'nama' ];
 $email = $_POST[ 'email' ];
 $feedback = $_POST[ 'feedback' ];
 // buat query
 $sql = "INSERT INTO feedback1 (tanggal,nama, email, feedback) VALUE (now(), '$nama', '$email', '$feedback')" ;
 $query = mysqli_query( $db, $sql);
 // apakah query simpan berhasil?
 if( $query ) {
 // kalau berhasil alihkan ke halaman index.php dengan status=sukses
 header( 'Location: ../Revisi2.php?status=sukses' );
 } else {
 // kalau gagal alihkan ke halaman indek.php dengan status=gagal
 header( 'Location: ../Revisi2.php?status=gagal' );
 }
} else {
 die( "Akses dilarang..." );
}
?>