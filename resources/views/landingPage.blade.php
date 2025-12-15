<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Platform belajar terpercaya untuk kembangkan skill Anda dengan materi berkualitas tinggi.">
    <title>Selamat Datang di Platform Belajar</title>
<style>
    /* Sisipkan CSS yang diperbarui di sini */
    body {
        /* Penting: Beri padding di atas body agar konten tidak tertutup nav fixed */
        padding-top: 60px; /* Tetap 60px, karena tinggi nav (50px) tidak berubah */
        margin: 0;
        font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
    }

    .nav {
        /* Posisi Fixed dan Lebar Penuh */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);

        /* Pengaturan Flexbox Utama */
        display: flex;
        align-items: center; /* Pusatkan item secara vertikal */
        height: 50px; /* Tinggi nav tetap 50px */
        padding: 0 20px;
    }

    .logo a {
        display: flex;
        align-items: center;
        height: 100%;
    }

    .logo img {
        /* PERUBAHAN: Tinggi logo kini disetel ke 35px */
        height: 35px; 
        max-height: 100%; /* Batasi agar tidak melebihi tinggi nav */
        width: auto; /* Jaga rasio aspek gambar */
    }

    /* Container untuk Login/Register */
    .auth-links {
        margin-left: auto; /* Mendorong ke kanan */
        padding: 40px;
        display: flex;
        gap: 10px;
        align-items: center;
    }

    /* Gaya untuk tombol (Opsional, untuk tampilan yang lebih baik) */
    .btn {
        text-decoration: none;
        padding: 5px 10px;
        border-radius: 4px;
        /* Tambahkan font-bold dan text-gray-800 di sini */
        font-weight: bold; /* font-bold */
        color: #4A5568; /* text-gray-800 analog */
        font-size: 0.875rem; /* text-sm analog */
    }

    .btn-login {
        border: 1px solid #4A5568;
    }

    .btn-register {
        background-color: #4A5568;
        color: white;
        /* Sesuaikan agar register juga tebal dan ukuran font sama */
        font-weight: bold; 
        font-size: 0.875rem; 
    }

    header {
        /* 1. Atur Tampilan */
        display: flex;
        flex-direction: column; /* Susun item secara vertikal */
        justify-content: center; /* Pusatkan item secara vertikal */
        align-items: center; /* Pusatkan item secara horizontal */
        text-align: center;
        
        /* 2. Atur Ukuran & Posisi */
        min-height: calc(100vh - 60px); /* Isi sisa tinggi layar (100vh - tinggi nav 60px) */
        padding: 20px;
        background-color: #f7f9fc; /* Latar belakang abu-abu terang */
    }

    header h1 {
        font-size: 2.5rem; /* Judul besar */
        color: #1a202c;
        margin-bottom: 10px;
    }

    header p {
        font-size: 1.25rem; /* Sub-judul */
        color: #4A5568;
        margin-bottom: 30px;
    }
    
</style>
</head>
<body>
    <nav class="nav">
        <div class="logo">
            <a href="{{ url('/') }}" aria-label="Kembali ke beranda">
                <img src="{{ asset('logo.png') }}" alt="Logo Platform Belajar" class="logo">
            </a>
        </div>

        <div class="auth-links">
            @if (Route::has('login'))
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-login">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-login">
                        Login
                    </a>
                    
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-register">
                            Register
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <header>
        <h1>Bangun Kariermu Bersama Kami</h1>
        <p>Mulai Belajar Tersetruktur</p>
        <a href="{{ route('login') }}" class="btn btn-register">
                            Mulai
                        </a>
    </header>
</body>
</html>