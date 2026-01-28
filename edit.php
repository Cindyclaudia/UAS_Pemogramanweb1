<?php 
require 'config.php';
cek_login();

// Ambil ID dari URL
$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM buku WHERE id_buku = $id");
$b = mysqli_fetch_assoc($data);

// Jika ID tidak ditemukan, kembalikan ke buku.php
if (!$b) { header("Location: buku.php"); exit; }

// Logika Update
if(isset($_POST['update'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
    $stok = $_POST['stok'];
    $id_kategori = $_POST['id_kategori'];
    
    $query = "UPDATE buku SET judul='$judul', penulis='$penulis', stok='$stok', id_kategori='$id_kategori' WHERE id_buku=$id";
    if(mysqli_query($conn, $query)) {
        header("Location: buku.php?pesan=diupdate");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Buku | BukuData Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root { --sidebar-bg: #1e293b; --accent-blue: #3b82f6; }
        body { 
            background: linear-gradient(135deg, #a5f3fc 0%, #c4b5fd 50%, #fbcfe8 100%);
            min-height: 100vh; margin: 0; font-family: 'Inter', sans-serif;
        }
        /* Sidebar tetap ada agar navigasi mudah */
        .sidebar { height: 100vh; background: var(--sidebar-bg); width: 260px; position: fixed; padding: 2rem 1rem; }
        .nav-link { color: #94a3b8; border-radius: 12px; margin-bottom: 8px; padding: 12px 15px; transition: 0.3s; text-decoration: none; display: block; }
        .nav-link:hover, .nav-link.active { color: #fff !important; background: rgba(255, 255, 255, 0.1); }
        .nav-link.active { background: var(--accent-blue); }
        
        .main-content { margin-left: 260px; padding: 40px; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        
        /* Glassmorphism Card untuk Form */
        .glass-form {
            background: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            padding: 12px;
        }
        .btn-update { background: var(--accent-blue); color: white; border: none; border-radius: 12px; font-weight: 600; }
        .btn-update:hover { background: #2563eb; color: white; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h3 class="text-white fw-bold mb-5 px-3">BukuData<span class="text-info">Pro</span></h3>
        <nav class="nav flex-column">
            <a class="nav-link" href="index.php"><i class="bi bi-grid-fill me-2"></i> Dashboard</a>
            <a class="nav-link active" href="buku.php"><i class="bi bi-journal-text me-2"></i> Manajemen Buku</a>
            <a class="nav-link" href="laporan.php"><i class="bi bi-file-earmark-bar-graph me-2"></i> Laporan</a>
            <div style="margin-top: 150px;">
                <a class="nav-link text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
            </div>
        </nav>
    </div>

    <div class="main-content">
        <div class="glass-form">
            <h3 class="fw-bold mb-4 text-center">Edit Data Buku</h3>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Judul Buku</label>
                    <input type="text" name="judul" class="form-control" value="<?= $b['judul'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Penulis</label>
                    <input type="text" name="penulis" class="form-control" value="<?= $b['penulis'] ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Kategori</label>
                    <select name="id_kategori" class="form-select">
                        <?php 
                        $kats = mysqli_query($conn, "SELECT * FROM kategori");
                        while($k = mysqli_fetch_assoc($kats)): 
                            $selected = ($k['id_kategori'] == $b['id_kategori']) ? 'selected' : '';
                        ?>
                            <option value="<?= $k['id_kategori'] ?>" <?= $selected ?>><?= $k['nama_kategori'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted">Stok</label>
                    <input type="number" name="stok" class="form-control" value="<?= $b['stok'] ?>">
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" name="update" class="btn btn-update py-3">Simpan Perubahan</button>
                    <a href="buku.php" class="btn btn-light py-3" style="border-radius: 12px;">Batal</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>