<?php
require 'config.php';
cek_login();

$query = mysqli_query($conn, "SELECT buku.*, kategori.nama_kategori 
                              FROM buku 
                              LEFT JOIN kategori ON buku.id_kategori = kategori.id_kategori");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan PDF</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="background: #fff3cd; padding: 15px; margin-bottom: 20px; border-radius: 8px;">
        <strong>Mode Cetak:</strong> Klik tombol di bawah untuk menyimpan sebagai PDF.
        <button onclick="window.print()" style="padding: 5px 15px; cursor: pointer;">Cetak Ke PDF</button>
    </div>

    <div class="header">
        <h1>BUKUDATA PRO</h1>
        <p>Laporan Inventaris Buku Perpustakaan | Tanggal: <?= date('d F Y') ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Kategori</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; while($r = mysqli_fetch_assoc($query)): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $r['judul'] ?></td>
                <td><?= $r['penulis'] ?></td>
                <td><?= $r['nama_kategori'] ?></td>
                <td><?= $r['stok'] ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <script>
        // Otomatis membuka jendela print saat halaman dimuat
        // window.print();
    </script>
</body>
</html>