<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnTrack - Platform Belajar Modern</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .font-display {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
        }
        
        .dcd-btn-primary {
            background-color: #004eb1;
            color: white;
            transition: all 0.2s;
        }
        
        .dcd-btn-primary:hover {
            background-color: #003d8f;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 78, 177, 0.2);
        }
        
        .dcd-btn-outline {
            border: 1px solid #004eb1;
            color: #004eb1;
            background: white;
            transition: all 0.2s;
        }
        
        .dcd-btn-outline:hover {
            background-color: #f0f6ff;
        }
        
        html {
            scroll-behavior: smooth;
        }

                .logo img { height: 25px; width: auto; }

    </style>
</head>
<body class="bg-white text-gray-900">

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 bg-white border-b border-gray-200 z-50">
        <div class="max-w-6xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('logo.png') }}" alt="Logo">
                    </a>
                </div>
                
                
                
                <div class="flex items-center space-x-3">
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">Masuk</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium rounded-md dcd-btn-primary">Daftar</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="pt-24 pb-16 px-6 bg-gradient-to-b from-blue-50 to-white">
        <div class="max-w-6xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h1 class="text-4xl lg:text-5xl font-display text-gray-900 leading-tight">
                        Platform Belajar untuk Masa Depan Kariermu
                    </h1>
                    
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Bergabunglah dengan ribuan profesional yang telah meningkatkan kemampuan mereka melalui kursus terstruktur, mentor ahli, dan sertifikat resmi yang diakui industri.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-3 pt-4">
                        <a href="{{ route('register') }}" class="px-6 py-3 text-sm font-medium rounded-md dcd-btn-primary text-center">
                            Daftar Gratis
                        </a>
                        <a href="{{ route('login') }}" class="px-6 py-3 text-sm font-medium rounded-md dcd-btn-outline text-center">
                            Masuk
                        </a>
                    </div>
                    
                    
                </div>
                
                <div class="hidden lg:block">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
                        <div class="aspect-square bg-gradient-to-br from-blue-100 to-blue-50 rounded-lg flex items-center justify-center">
                            <div class="hero-image-wrapper">
                                <img src="{{ asset('rocket.png') }}" alt="Hero Image" id="parallax-img" class="floating-img img-visible">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Feature Section -->
    <section id="fitur" class="py-16 px-6 bg-white">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-display text-gray-900 mb-3">
                    Fitur Unggulan Kami
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Platform yang dirancang untuk memaksimalkan pengalaman belajar Anda dengan tools dan fitur terbaik
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-blue-100 rounded-md flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-display text-gray-900 mb-2">Kurikulum Terstruktur</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Materi pembelajaran disusun sistematis dari dasar hingga mahir dengan roadmap yang jelas.
                    </p>
                </div>
                
                <div class="bg-white rounded-lg border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-blue-100 rounded-md flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-display text-gray-900 mb-2">Akses Seumur Hidup</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Nikmati pembelajaran berkelanjutan tanpa masa kedaluwarsa.
                    </p>
                </div>
                
                <div class="bg-white rounded-lg border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-blue-100 rounded-md flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-display text-gray-900 mb-2">Sertifikat Resmi</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Dapatkan sertifikat yang diakui industri untuk meningkatkan kredibilitas profesional Anda.
                    </p>
                </div>
                
                <div class="bg-white rounded-lg border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-blue-100 rounded-md flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-display text-gray-900 mb-2">Proyek Praktis</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Kerjakan proyek nyata yang dapat ditambahkan langsung ke portofolio profesional Anda.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefit Section -->
    <section id="tentang" class="py-16 px-6 bg-gray-50">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-display text-gray-900 mb-3">
                    Mengapa Memilih LearnTrack?
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Platform pembelajaran terpercaya dengan metode yang terbukti efektif
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 class="text-xl font-display text-gray-900 mb-4">Pembelajaran Fleksibel</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Belajar sesuai dengan ritme dan jadwal Anda sendiri. Akses materi kapan saja dan di mana saja melalui platform kami yang dapat diakses dari berbagai perangkat.
                    </p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Akses seumur hidup ke materi kursus</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Update materi secara berkala</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Belajar dari perangkat apapun</span>
                        </li>
                    </ul>
                </div>
                
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 class="text-xl font-display text-gray-900 mb-4">Rekomendasi Alur Belajar</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Setelah Anda menyelesaikan suatu materi, sistem akan merekomendasikan alur belajar berikutnya agar proses belajar tetap terarah dan berkelanjutan.
                    </p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Materi lanjutan berdasarkan materi yang sudah anda pelajari sebelumnya</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Mempersingkat anda agar tidak belajar 2 kali</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Lebih cepat menjadi profesional</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 px-6 bg-blue-50">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl lg:text-4xl font-display text-gray-900 mb-4">
                Siap Memulai Perjalanan Belajar Anda?
            </h2>
            <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                Bergabunglah dengan ribuan profesional yang telah meningkatkan karier mereka. Daftar sekarang dan dapatkan akses gratis ke kursus pilihan!
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center items-center">
                <a href="#" class="px-8 py-3 text-sm font-medium rounded-md dcd-btn-primary">
                    Mulai Sekarang
                </a>
                <a href="#" class="px-8 py-3 text-sm font-medium rounded-md dcd-btn-outline">
                    Lihat Katalog Kursus
                </a>
            </div>
            
            <div class="flex flex-wrap justify-center items-center gap-8 mt-10 pt-8 border-t border-gray-200">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>Gratis Trial 7 Hari</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>Tidak Perlu Kartu Kredit</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>Garansi Uang Kembali</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="py-12 px-6 bg-white border-t border-gray-200">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="font-display text-xl text-gray-900 mb-4">LearnTrack</div>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Platform pembelajaran online terpercaya untuk mengembangkan skill dan karier Anda.
                    </p>
                </div>
                
                <div>
                    <h4 class="font-display text-sm text-gray-900 mb-3">Produk</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-gray-900">Semua Kursus</a></li>
                        <li><a href="#" class="hover:text-gray-900">Bootcamp</a></li>
                        <li><a href="#" class="hover:text-gray-900">Mentor 1-on-1</a></li>
                        <li><a href="#" class="hover:text-gray-900">Corporate Training</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-display text-sm text-gray-900 mb-3">Perusahaan</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-gray-900">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-gray-900">Karier</a></li>
                        <li><a href="#" class="hover:text-gray-900">Blog</a></li>
                        <li><a href="#" class="hover:text-gray-900">Press Kit</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-display text-sm text-gray-900 mb-3">Dukungan</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-gray-900">Help Center</a></li>
                        <li><a href="#" class="hover:text-gray-900">Hubungi Kami</a></li>
                        <li><a href="#" class="hover:text-gray-900">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-gray-900">Kebijakan Privasi</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="pt-8 border-t border-gray-200 text-center text-sm text-gray-500">
                <p>&copy; 2025 LearnTrack. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>