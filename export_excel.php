<?php
require 'config.php';
cek_login();

// Header untuk memberi tahu browser bahwa ini adalah file Excel
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Buku_".date('Ymd').".xls");

$query = mysqli_query($conn, "SELECT buku.*, kategori.nama_kategori 
                              FROM buku 
                              LEFT JOIN kategori ON buku.id_kategori = kategori.id_kategori");
?>
<table border="1">
    <tr>
        <th colspan="5" style="font-size: 1.4rem;">LAPORAN DATA BUKU - BUKUDATA PRO</th>
    </tr>
    <tr>
        <th>No</th>
        <th>Judul Buku</th>
        <th>Penulis</th>
        <th>Kategori</th>
        <th>Stok</th>
    </tr>
    <?php 
    $no = 1;
    while($d = mysqli_fetch_array($query)): 
    ?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= $d['judul']; ?></td>
        <td><?= $d['penulis']; ?></td>
        <td><?= $d['nama_kategori']; ?></td>
        <td><?= $d['stok']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>