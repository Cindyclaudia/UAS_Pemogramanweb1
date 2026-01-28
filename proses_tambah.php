<?php
require 'config.php';
cek_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
    $stok = $_POST['stok'];
    $id_kategori = $_POST['id_kategori'];

    $query = "INSERT INTO buku (judul, penulis, stok, id_kategori) VALUES ('$judul', '$penulis', '$stok', '$id_kategori')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: index.php?pesan=sukses");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>