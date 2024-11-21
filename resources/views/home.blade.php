<x-layout>
    {{-- Hero Section --}}
    <div class="relative bg-cover bg-center bg-no-repeat text-white h-screen flex items-center justify-center py-20 px-6 md:px-12"
        style="background-image: url('{{ asset('storage/img/hero.png') }}');">
        <div class="absolute inset-0"
            style="background: linear-gradient(0deg, rgb(29, 29, 29) 1%, rgba(241, 241, 241, 0) 10%);">
        </div>
        <!-- Container -->
        <div class="container flex flex-col md:flex-row items-center relative z-10 ml-[-200px]"
            style="margin-top: -150px;">
            <!-- Latar belakang teks -->
            <div class="md:w-55 mb-8 md:mb-0 bg-gray-800 bg-opacity-70 p-6 rounded-lg">
                <h1 class="text-5xl md:text-7xl font-bold mb-4 font-pixelify">
                    Retro Game Hub
                </h1>
                <p class="text-2xl md:text-3xl mb-6 font-pixelify">
                    Tempat Terbaik untuk Membeli Game dan Console Klasik
                </p>
                <p class="text-base md:text-lg mb-8 font-pixelify">Jelajahi koleksi game nostalgia dan rasakan
                    pengalaman bermain layaknya masa lalu. Belanja mudah, aman, dan cepat!
                </p>
                <a href="#"
                    class="bg-yellow-400 text-red-700 hover:bg-yellow-500 font-semibold py-3 px-6 rounded shadow-md transition duration-300 font-pixelify">
                    Mulai Berbelanja
                </a>
            </div>
        </div>
    </div>

    {{-- Woy ke judul na didienya di, judul na bere comment, terus card na oge bbere comment, comment nu urang ie hapusnyakkkk --}}
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    </div>
</x-layout>
