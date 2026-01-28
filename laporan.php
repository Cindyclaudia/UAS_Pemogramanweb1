<?php 
require 'config.php';
cek_login();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pusat Laporan | BukuData Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root { --sidebar-bg: #ffffff; --accent-blue: #3b82f6; }
        body { 
            background: linear-gradient(135deg, #a5f3fc 0%, #c4b5fd 50%, #fbcfe8 100%);
            min-height: 100vh; margin: 0; font-family: 'Inter', sans-serif;
        }
        .sidebar { height: 100vh; background: var(--sidebar-bg); width: 260px; position: fixed; padding: 2rem 1rem; }
        .nav-link { color: #000000; border-radius: 12px; margin-bottom: 8px; padding: 12px 15px; transition: 0.3s; text-decoration: none; display: block; }
        .nav-link:hover, .nav-link.active { color: #fff !important; background: rgba(255, 255, 255, 0.1); }
        .nav-link.active { background: var(--accent-blue); }
        .main-content { margin-left: 260px; padding: 40px; }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 24px;
            padding: 40px;
            text-align: center;
            transition: 0.3s;
        }
        .glass-card:hover { transform: translateY(-10px); }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3 class="text-black fw-bold mb-5 px-3">BukuData<span class="text-info">Pro</span></h3>
        <nav class="nav flex-column">
            <a class="nav-link" href="index.php"><i class="bi bi-grid-fill me-2"></i> Dashboard</a>
            <a class="nav-link" href="buku.php"><i class="bi bi-journal-text me-2"></i> Manajemen Buku</a>
            <a class="nav-link active" href="laporan.php"><i class="bi bi-file-earmark-bar-graph me-2"></i> Laporan</a>
            <div style="margin-top: 150px;"><a class="nav-link text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></div>
        </nav>
    </div>

    <div class="main-content">
        <h2 class="fw-bold mb-5">Pusat Laporan Sistem</h2>
        
        <div class="row g-5">
            <div class="col-md-5">
                <div class="glass-card shadow-sm">
                    <i class="bi bi-file-earmark-excel text-success display-2 mb-3"></i>
                    <h4 class="fw-bold">Laporan Excel</h4>
                    <p class="text-muted small">Unduh semua data buku dalam format .xls untuk pengolahan angka.</p>
                    <a href="export_excel.php" class="btn btn-success w-100 py-2 mt-3" style="border-radius:12px;">Download Excel</a>
                </div>
            </div>

            <div class="col-md-5">
                <div class="glass-card shadow-sm">
                    <i class="bi bi-file-earmark-pdf text-danger display-2 mb-3"></i>
                    <h4 class="fw-bold">Laporan PDF</h4>
                    <p class="text-muted small">Cetak laporan buku resmi dalam format PDF yang tidak dapat diubah.</p>
                    <a href="export_pdf.php" target="_blank" class="btn btn-danger w-100 py-2 mt-3" style="border-radius:12px;">Download PDF</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>