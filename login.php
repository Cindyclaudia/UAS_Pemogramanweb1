<?php
require 'config.php';

// Pastikan session dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// LOGIKA PENTING: Jika user SUDAH login, baru lempar ke index.
// JANGAN panggil fungsi cek_login() di file ini agar tidak redirect loop.
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$error = false;

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Query mencari user di tabel 'users'
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Menggunakan perbandingan teks biasa agar lebih mudah untuk UAS
        if ($password === $row['password']) {
            $_SESSION['user'] = $row['username'];
            header("Location: index.php");
            exit;
        }
    }
    $error = true;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | BukuData Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap');

        body { 
            background: linear-gradient(135deg, #a5f3fc 0%, #c4b5fd 50%, #fbcfe8 100%); 
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-family: 'Poppins', sans-serif;
            margin: 0;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 35px;
            padding: 50px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .brand-name { font-size: 2.2rem; font-weight: 800; color: #1e293b; margin-bottom: 10px; }
        .brand-subtitle { font-size: 0.9rem; color: #64748b; margin-bottom: 40px; }

        .form-label { display: block; text-align: left; font-weight: 600; font-size: 0.85rem; color: #475569; margin-bottom: 8px; }

        .form-control {
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 15px;
            padding: 14px 20px;
            margin-bottom: 25px;
        }

        /* Tombol Putih Font Hitam Sesuai Instruksi */
        .btn-login {
            background: #ffffff;
            color: #000000;
            border: none;
            border-radius: 15px;
            padding: 15px;
            font-weight: 700;
            width: 100%;
            transition: 0.3s;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }

        .btn-login:hover {
            background: #f8f9fa;
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="brand-name">BukuData<span class="text-info">Pro</span></div>
        <p class="brand-subtitle">Silakan login untuk mengelola perpustakaan</p>
        
        <form method="POST">
            <div class="mb-3 text-start">
                <label class="form-label">USERNAME</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
            </div>
            
            <div class="mb-4 text-start">
                <label class="form-label">PASSWORD</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>

            <button type="submit" name="login" class="btn btn-login shadow">
                LOGIN SEKARANG
            </button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        <?php if($error): ?>
            Swal.fire({
                icon: 'error',
                title: 'Akses Ditolak',
                text: 'Username atau password salah!',
                background: 'rgba(255, 255, 255, 0.9)',
                backdrop: `blur(8px)`,
                confirmButtonColor: '#3b82f6'
            });
        <?php endif; ?>
    </script>
</body>
</html>