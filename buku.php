<?php 
require 'config.php';
cek_login();

// Logika Hapus (Dijalankan jika ada parameter ?hapus=id di URL)
if(isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM buku WHERE id_buku=$id");
    header("Location: buku.php?pesan=terhapus");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Buku | BukuData Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css" rel="stylesheet">
    <style>
        :root { --sidebar-bg: #ffffff; --accent: #3b82f6; }
        body { background: linear-gradient(135deg, #a5f3fc 0%, #c4b5fd 50%, #fbcfe8 100%); min-height: 100vh; font-family: 'Poppins', sans-serif; }
        .sidebar { height: 100vh; background: var(--sidebar-bg); width: 260px; position: fixed; padding: 2rem 1rem; z-index: 100; }
        .nav-link { color: #000000; border-radius: 12px; margin-bottom: 8px; padding: 12px 15px; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { color: #fff !important; background: var(--accent); }
        .nav-link.active { background: var(--accent); }
        .main-content { margin-left: 260px; padding: 40px; }
        
        .glass-panel {
            background: rgba(255, 255, 255, 0.45); backdrop-filter: blur(15px); -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 24px; padding: 30px; box-shadow: 0 8px 32px rgba(31, 38, 135, 0.07);
        }

        /* Tombol Putih Font Hitam sesuai permintaan */
        .btn-add { 
            background: #ffffff; 
            color: #000000; 
            border: none; 
            border-radius: 12px; 
            font-weight: 600; 
            padding: 12px 25px; 
            transition: 0.3s; 
        }
        .btn-add:hover { background: #f8f9fa; color: #000000; transform: scale(1.05); }

        .table { --bs-table-bg: transparent; }
        .modal-content { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(20px); border-radius: 24px; border: none; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3 class="text-pink fw-bold mb-5 px-3">BukuData<span class="text-info">Pro</span></h3>
        <nav class="nav flex-column">
            <a class="nav-link" href="index.php"><i class="bi bi-grid-fill me-2"></i> Dashboard</a>
            <a class="nav-link active" href="buku.php"><i class="bi bi-journal-text me-2"></i> Manajemen Buku</a>
            <a class="nav-link" href="laporan.php"><i class="bi bi-file-earmark-bar-graph me-2"></i> Laporan</a>
            <div style="margin-top: 150px;"><a class="nav-link text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></div>
        </nav>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="fw-bold text-dark">Manajemen Koleksi</h2>
            <button class="btn btn-add shadow" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-plus-circle-fill me-2"></i>Tambah Buku Baru
            </button>
        </div>

        <div class="glass-panel">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th class="border-0">Judul</th>
                        <th class="border-0">Penulis</th>
                        <th class="border-0">Kategori</th>
                        <th class="border-0">Stok</th>
                        <th class="border-0 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q = mysqli_query($conn, "SELECT buku.*, kategori.nama_kategori FROM buku LEFT JOIN kategori ON buku.id_kategori = kategori.id_kategori ORDER BY id_buku DESC");
                    while($r = mysqli_fetch_assoc($q)): ?>
                    <tr>
                        <td class="fw-bold border-0"><?= $r['judul'] ?></td>
                        <td class="border-0"><?= $r['penulis'] ?></td>
                        <td class="border-0"><span class="badge bg-white text-primary shadow-sm"><?= $r['nama_kategori'] ?></span></td>
                        <td class="border-0"><?= $r['stok'] ?></td>
                        <td class="text-center border-0">
                            <a href="edit.php?id=<?= $r['id_buku'] ?>" class="btn btn-sm btn-light border shadow-sm me-1"><i class="bi bi-pencil"></i></a>
                            <a href="javascript:void(0)" onclick="confirmHapus(<?= $r['id_buku'] ?>)" class="btn btn-sm btn-danger shadow-sm"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="proses_tambah.php" method="POST" class="modal-content p-3 shadow-lg">
                <div class="modal-header border-0">
                    <h4 class="fw-bold mb-0">Tambah Buku Baru</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3"><label class="small fw-bold">Judul Buku</label><input type="text" name="judul" class="form-control rounded-3" required></div>
                    <div class="mb-3"><label class="small fw-bold">Penulis</label><input type="text" name="penulis" class="form-control rounded-3"></div>
                    <div class="row">
                        <div class="col-6 mb-3"><label class="small fw-bold">Stok</label><input type="number" name="stok" class="form-control rounded-3" value="0"></div>
                        <div class="col-6 mb-3">
                            <label class="small fw-bold">Kategori</label>
                            <select name="id_kategori" class="form-select rounded-3">
                                <?php $kats = mysqli_query($conn, "SELECT * FROM kategori"); while($k = mysqli_fetch_assoc($kats)) echo "<option value='".$k['id_kategori']."'>".$k['nama_kategori']."</option>"; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-4">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmHapus(id) {
            Swal.fire({
                title: 'Hapus Buku?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: 'rgba(255, 255, 255, 0.9)',
                backdrop: `blur(5px)`
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'buku.php?hapus=' + id;
                }
            })
        }

        <?php if(isset($_GET['pesan'])): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Aksi berhasil dilakukan.',
                timer: 2000,
                showConfirmButton: false
            });
        <?php endif; ?>
    </script>
</body>
</html>