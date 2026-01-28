<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "db_perpustakaan");

// Pastikan koneksi aman
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

function cek_login() {
    // Disamakan menjadi 'user' agar sinkron dengan login.php
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit;
    }
}
?>