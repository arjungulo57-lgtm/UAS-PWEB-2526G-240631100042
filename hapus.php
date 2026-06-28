<?php
require 'koneksi.php';

$id   = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$conn = koneksiDB();

if ($id > 0) {
    $cek = mysqli_query($conn, "SELECT id FROM mahasiswa WHERE id=$id");
    if (mysqli_num_rows($cek) > 0) {
        mysqli_query($conn, "DELETE FROM mahasiswa WHERE id=$id");
    }
}

tutupDB($conn);
header('Location: daftar.php?pesan=hapus');
exit;
?>
