<x-layout>
    <x-navbar></x-navbar>
    <div class="min-h-screen flex flex-col items-center px-4 mt-10 md:px-10 pt-10 bg-neutral-900 text-gray-300">
        <!-- Buttons Section -->
        <div class="flex flex-col gap-8 w-full max-w-2xl mt-10">
            <!-- Game Button -->
            <a href="/games" class="group relative bg-gradient-to-r from-blue-600 to-indigo-600 p-6 rounded-2xl shadow-md transform transition hover:scale-105 hover:shadow-xl">
                <!-- Border Glow -->
                <div class="absolute inset-0 blur-md opacity-30 group-hover:opacity-50 bg-gradient-to-r from-blue-400 to-indigo-400 rounded-2xl"></div>
                <!-- Content -->
                <div class="relative flex items-center space-x-6">
                    <!-- Icon -->
                    <div class="bg-blue-800 p-5 rounded-full shadow-lg">
                        <i class="fas fa-rocket fa-3x text-white"></i> 
                    </div>
                    <!-- Description -->
                    <div>
                        <h2 class="text-2xl font-bold text-white font-pixelify">Games</h2>
                        <p class="text-sm text-gray-100">Kembali ke masa lalu dengan permainan retro yang penuh tantangan dan kenangan manis. Temukan game yang akan membawa nostalgia dan keseruan!</p>
                    </div>
                </div>
            </a>

            <!-- Console Button -->
            <a href="/consoles" class="group relative bg-gradient-to-r from-green-600 to-teal-600 p-6 rounded-2xl shadow-md transform transition hover:scale-105 hover:shadow-xl">
                <div class="absolute inset-0 blur-md opacity-30 group-hover:opacity-50 bg-gradient-to-r from-green-400 to-teal-400 rounded-2xl"></div>
                <div class="relative flex items-center space-x-6">
                    <div class="bg-green-800 p-5 rounded-full shadow-lg">
                        <i class="fas fa-gamepad fa-3x text-white"></i> 
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white font-pixelify">Consoles</h2>
                        <p class="text-sm text-gray-100">Rasakan kembali masa-masa konsol ikonik yang membentuk generasi. Dari cartridge klasik hingga kontroler vintage, semuanya ada di sini!</p>
                    </div>
                </div>
            </a>

            <!-- E-Wallet Button -->
            <a href="/ewallet" class="group relative bg-gradient-to-r from-yellow-600 to-orange-600 p-6 rounded-2xl shadow-md transform transition hover:scale-105 hover:shadow-xl">
                <div class="absolute inset-0 blur-md opacity-30 group-hover:opacity-50 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-2xl"></div>
                <div class="relative flex items-center space-x-6">
                    <div class="bg-yellow-800 p-5 rounded-full shadow-lg">
                        <i class="fas fa-gift fa-3x text-white"></i> 
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white font-pixelify">E-Wallet</h2>
                        <p class="text-sm text-gray-100">Isi saldo e-wallet kamu untuk membeli game retro favorit dengan cepat dan aman. Nikmati kemudahan transaksi di dunia digital gaming yang klasik dan modern!</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</x-layout>
