<?php 
require 'config.php';
cek_login();

// Ambil Statistik
$total_buku = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM buku"))['t'];
$total_kat = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM kategori"))['t'];

// Ambil Data Buku
$query_buku = mysqli_query($conn, "SELECT buku.*, kategori.nama_kategori FROM buku LEFT JOIN kategori ON buku.id_kategori = kategori.id_kategori ORDER BY id_buku DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>BukuData Pro | Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css" rel="stylesheet">
    
    <style>
        :root { --sidebar-bg: #ffffff; --accent: #3b82f6; }
        body { background: linear-gradient(135deg, #a5f3fc 0%, #c4b5fd 50%, #fbcfe8 100%); min-height: 100vh; font-family: 'Poppins', sans-serif; }
        .sidebar { height: 100vh; background: var(--sidebar-bg); width: 260px; position: fixed; padding: 2rem 1rem; z-index: 100; }
        .nav-link { color: #000000; border-radius: 12px; margin-bottom: 8px; padding: 12px 15px; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { color: #fff !important; background: rgba(255, 255, 255, 0.1); }
        .nav-link.active { background: var(--accent); }
        .main-content { margin-left: 260px; padding: 40px; }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.45); backdrop-filter: blur(15px); -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 24px; padding: 25px; box-shadow: 0 8px 32px rgba(31, 38, 135, 0.07);
        }
        
        /* Perubahan warna tombol sesuai permintaan */
        .btn-add { 
            background: #ffffff; 
            color: #000000; 
            border: none; 
            border-radius: 12px; 
            font-weight: 600; 
            padding: 12px 25px; 
            transition: 0.3s; 
        }
        .btn-add:hover { 
            background: #f8f9fa; 
            color: #000000; 
            transform: scale(1.05); 
        }

        /* Custom Modal Style */
        .modal-content { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(20px); border-radius: 24px; border: none; }
        .form-control { border-radius: 12px; padding: 12px; border: 1px solid #e2e8f0; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h3 class="text-pink fw-bold mb-5 px-3">BukuData<span class="text-info">Pro</span></h3>
        <nav class="nav flex-column">
            <a class="nav-link active" href="index.php"><i class="bi bi-grid-fill me-2"></i> Dashboard</a>
            <a class="nav-link" href="buku.php"><i class="bi bi-journal-text me-2"></i> Manajemen Buku</a>
            <a class="nav-link" href="laporan.php"><i class="bi bi-file-earmark-bar-graph me-2"></i> Laporan</a>
            <div style="margin-top: 150px;"><a class="nav-link text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></div>
        </nav>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div><h2 class="fw-bold text-dark mb-0">Daftar Koleksi Buku</h2><p class="text-muted">Kelola data buku dengan lebih cepat.</p></div>
            <button class="btn btn-add shadow" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-plus-circle-fill me-2"></i>Tambah Buku Baru
            </button>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-4"><div class="glass-card"><p class="text-muted small fw-bold mb-1">TOTAL BUKU</p><h2 class="fw-bold"><?= $total_buku ?></h2></div></div>
            <div class="col-md-4"><div class="glass-card"><p class="text-muted small fw-bold mb-1">KATEGORI</p><h2 class="fw-bold"><?= $total_kat ?></h2></div></div>
        </div>

        <div class="row g-4">
            <?php while($row = mysqli_fetch_assoc($query_buku)): ?>
            <div class="col-md-4">
                <div class="glass-card">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="badge bg-white text-primary shadow-sm rounded-pill px-3 py-2"><?= $row['nama_kategori'] ?></span>
                        <div class="fs-5">
                            <a href="edit.php?id=<?= $row['id_buku'] ?>" class="text-dark me-2"><i class="bi bi-pencil-square"></i></a>
                            <a href="javascript:void(0)" onclick="hapusBuku(<?= $row['id_buku'] ?>)" class="text-danger"><i class="bi bi-trash3-fill"></i></a>
                        </div>
                    </div>
                    <h5 class="fw-bold"><?= $row['judul'] ?></h5>
                    <p class="text-muted small mb-3"><?= $row['penulis'] ?></p>
                    <div class="fw-bold small"><i class="bi bi-box me-1"></i> Stok: <?= $row['stok'] ?></div>
                </div>
            </div>
            <?php endwhile; ?>
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
                    <div class="mb-3"><label class="small fw-bold">Judul Buku</label><input type="text" name="judul" class="form-control" required placeholder="Contoh: Dune"></div>
                    <div class="mb-3"><label class="small fw-bold">Penulis</label><input type="text" name="penulis" class="form-control" placeholder="Nama penulis"></div>
                    <div class="row mb-3">
                        <div class="col"><label class="small fw-bold">Stok</label><input type="number" name="stok" class="form-control" value="0"></div>
                        <div class="col">
                            <label class="small fw-bold">Kategori</label>
                            <select name="id_kategori" class="form-select" style="border-radius: 12px; padding: 12px;">
                                <?php $kats = mysqli_query($conn, "SELECT * FROM kategori"); while($k = mysqli_fetch_assoc($kats)) echo "<option value='".$k['id_kategori']."'>".$k['nama_kategori']."</option>"; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold" style="border-radius: 15px;">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function hapusBuku(id) {
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
                text: 'Data telah diperbarui.',
                timer: 2000,
                showConfirmButton: false
            });
        <?php endif; ?>
    </script>
</body>
</html>