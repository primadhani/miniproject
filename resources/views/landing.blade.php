<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Platform belajar terpercaya untuk kembangkan skill Anda dengan materi berkualitas tinggi.">
    <title>LearnTrack - Parallax Experience</title>
<style>
        /* === RESET & BASE === */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            padding-top: 50px;
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f9fafb;
            overflow-x: hidden;
            color: #333;
        }

        /* === NAVBAR === */
        .nav {
            position: fixed; top: 0; left: 0; width: 100%; z-index: 1000;
            background-color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex; align-items: center; height: 50px; padding: 0 20px;
        }
        .logo img { height: 25px; width: auto; }
        .auth-links { margin-left: auto; display: flex; gap: 10px; }
        .btn { text-decoration: none; padding: 6px 14px; border-radius: 4px; font-weight: bold; font-size: 0.875rem; transition: 0.3s; }
        .btn-register { background-color: #4A5568; color: white; }

        /* === HERO SECTION (RESPONSIVE) === */
        .hero-section {
            position: relative;
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px 5%;
            margin-top: -50px;
            background: linear-gradient(135deg, #f0f9ff 0%, #e6f7ff 100%);
            overflow: hidden;
        }

        .hero-container {
            display: flex;
            align-items: center;
            width: 100%;
            max-width: 1200px;
            z-index: 2;
            flex-wrap: wrap; /* Membuat konten turun di layar kecil */
        }

        .hero-text {
            flex: 1;
            min-width: 300px;
            padding: 20px;
            text-align: left;
        }

        .hero-text h1 { font-size: 3rem; line-height: 1.2; color: #1a202c; margin-bottom: 20px; opacity: 0; }
        .hero-text p { font-size: 1.25rem; color: #4A5568; margin-bottom: 30px; opacity: 0; }
        .btn-hero { padding: 12px 30px; font-size: 1.1rem; display: inline-block; opacity: 0; }

        .hero-image-wrapper {
            flex: 1;
            min-width: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .floating-img {
            width: 100%;
            max-width: 450px;
            border-radius: 20px;
            /* box-shadow: 0 20px 40px rgba(0,0,0,0.1); */
            opacity: 0;
            transition: opacity 0.8s ease-out;
        }

        /* === ANIMASI LOAD === */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-load-1 { animation: fadeInUp 0.8s ease-out forwards; }
        .animate-load-2 { animation: fadeInUp 0.8s ease-out 0.3s forwards; }
        .animate-load-3 { animation: fadeInUp 0.8s ease-out 0.6s forwards; }
        .img-visible { opacity: 1 !important; }

        /* === SECTIONS: FEATURES & TESTIMONIALS === */
        .features, .testimonials { padding: 80px 20px; text-align: center; }
        .features { background: white; }
        .testimonials { background: #f0f9ff; }

        .section-title { font-size: 2.2rem; margin-bottom: 40px; }

        .grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 25px;
            max-width: 1100px;
            margin: 0 auto;
        }

        .card {
            flex: 1 1 300px;
            padding: 30px;
            background: #f8fafc;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: 0.3s;
        }
        .card:hover { transform: translateY(-10px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }

        /* === SCROLL REVEAL === */
        .reveal { opacity: 0; transform: translateY(40px); transition: 0.8s ease-out; }
        .reveal.active { opacity: 1; transform: translateY(0); }

        footer { background: #1a202c; color: white; padding: 30px; text-align: center; }

        /* === MEDIA QUERIES (RESPONSIVE) === */
        @media (max-width: 768px) {
            .hero-text { text-align: center; padding: 0; margin-bottom: 40px; }
            .hero-text h1 { font-size: 2.2rem; }
            .hero-image-wrapper { order: 2; } /* Gambar di bawah teks pada HP */
            .floating-img { max-width: 280px; }
        }
    </style>
</head>
<body>

    <nav class="nav">
        <div class="logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('logo.png') }}" alt="Logo">
            </a>
        </div>
        <div class="auth-links">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-login">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-login">Login</a>
                <a href="{{ route('register') }}" class="btn btn-register">Register</a>
            @endauth
        </div>
    </nav>

<header class="hero-section">
        <div class="hero-container">
            <div class="hero-text">
                <h1 class="animate-load-1">Bangun Kariermu Bersama Kami</h1>
                <p class="animate-load-2">Platform belajar terstruktur dengan mentor ahli, proyek nyata, dan sertifikat resmi.</p>
                <a href="{{ route('login') }}" class="btn btn-register btn-hero animate-load-3">Mulai Belajar</a>
            </div>
            <div class="hero-image-wrapper">
                <img src="{{ asset('rocket.png') }}" alt="Hero Image" id="parallax-img" class="floating-img img-visible">
            </div>
        </div>
    </header>

    <section class="features">
        <h2 class="section-title reveal">Mengapa Belajar di Sini?</h2>
        <p class="subtitle reveal">Kami hadir untuk membantu proses belajar yang efektif dan relevan.</p>
        
        <div class="grid">
            <div class="card reveal" style="transition-delay: 0.1s;">
                <h3>Kurikulum Update</h3>
                <p>Materi pembelajaran diperbarui secara berkala sesuai kebutuhan industri global.</p>
            </div>
            <div class="card reveal" style="transition-delay: 0.2s;">
                <h3>Materi Lanjutan</h3>
                <p>Rekomendasi jalur belajar yang dipersonalisasi sesuai minat dan bakat Anda.</p>
            </div>
            <div class="card reveal" style="transition-delay: 0.3s;">
                <h3>Sertifikat Digital</h3>
                <p>Dapatkan pengakuan resmi yang bisa Anda pamerkan di LinkedIn dan portofolio.</p>
            </div>
        </div>
    </section>

    <section class="testimonials">
        <h2 class="section-title reveal">Suara Siswa Kami</h2>
        <div class="grid">
            <div class="card reveal" style="background: white; transition-delay: 0.1s;">
                <p>"Kursusnya sangat terstruktur. Sangat membantu karier saya!"</p>
                <br><strong>— Rani, Developer</strong>
            </div>
            <div class="card reveal" style="background: white; transition-delay: 0.2s;">
                <p>"Mentor sangat responsif dalam menjawab kendala teknis."</p>
                <br><strong>— Dito, Data Scientist</strong>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 LearnTrack. All Rights Reserved.</p>
    </footer>

 <script>
        // Parallax Gerak ke Kanan Atas
        window.addEventListener('scroll', function() {
            // Hanya aktif jika lebar layar > 768px agar tidak merusak tampilan mobile
            if (window.innerWidth > 768) {
                const scrollValue = window.scrollY;
                const targetImg = document.getElementById('parallax-img');
                
                if (scrollValue < window.innerHeight) {
                    // Bergeser ke kanan (X) dan ke atas (Y)
                    targetImg.style.transform = `translate(${scrollValue * 0.3}px, ${scrollValue * -0.3}px)`;
                }
            }
        });

        // Intersection Observer untuk Animasi Masuk (Fitur & Testimoni)
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.reveal').forEach((el) => {
            observer.observe(el);
        });
    </script>
</body>
</html>