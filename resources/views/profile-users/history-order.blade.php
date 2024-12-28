<x-layout>
    <x-navbar></x-navbar>
    <div class="min-h-screen flex flex-col items-center px-4 md:px-10 pt-10 bg-neutral-900 text-gray-300">
        <!-- Account Wrapper -->
        <div class="container grid grid-cols-1 md:grid-cols-12 gap-6 pt-4 pb-16 mt-7">
            <!-- Sidebar -->
            <div class="col-span-12 md:col-span-3">
                <!-- Account Profile -->
                <div class="bg-neutral-800 rounded-lg shadow-md p-4 flex flex-col md:flex-row items-center gap-4">
                    <div class="flex-grow text-center md:text-left">
                        <h4 class="text-lg font-semibold text-white">John Doe</h4>
                    </div>
                </div>

                <!-- Profile Links -->
                <div class="bg-neutral-800 rounded-lg shadow-md mt-6 divide-y divide-yellow-300">
                    <a href="profile-users" class="block py-3 px-5 hover:bg-yellow-400 hover:text-red-800 font-medium flex items-center gap-3 font-pixelify">
                        <i class="fas fa-user-circle"></i> Info Profil
                    </a>
                    <a href="change-password" class="block py-3 px-5 hover:bg-yellow-400 hover:text-red-800 font-medium flex items-center gap-3 font-pixelify">
                        <i class="fas fa-key"></i> Ubah Kata Sandi
                    </a>
                    <a href="" class="block py-3 px-5 bg-yellow-400 text-red-800 font-medium flex items-center gap-3 font-pixelify">
                        <i class="fas fa-history"></i> Riwayat Pesanan
                    </a>
                    <a href="#" class="block py-3 px-5 hover:bg-yellow-400 hover:text-red-800 font-medium flex items-center gap-3 font-pixelify">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-span-12 md:col-span-9">
                <div class="bg-neutral-800 rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-pixelify text-yellow-400 mb-4">Riwayat Pesanan</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Produk A -->
                        <div class="bg-neutral-900 rounded-lg shadow-md p-4 flex items-center gap-4">
                            <img src="{{ asset('storage/img/order1.jpg') }}" alt="Order Image" 
                                class="w-16 h-16 rounded-md object-cover border border-gray-600">
                            <div class="flex-grow">
                                <h3 class="text-lg font-semibold text-gray-200">Produk A</h3>
                                <p class="text-sm text-gray-400">Total: <span class="text-white">Rp 500.000</span></p>
                            </div>
                            <a href="#" class="text-sm text-white px-3 py-1 bg-yellow-500 rounded-md">Proses</a>
                        </div>

                        <!-- Produk B -->
                        <div class="bg-neutral-900 rounded-lg shadow-md p-4 flex items-center gap-4">
                            <img src="{{ asset('storage/img/order2.jpg') }}" alt="Order Image" 
                                class="w-16 h-16 rounded-md object-cover border border-gray-600">
                            <div class="flex-grow">
                                <h3 class="text-lg font-semibold text-gray-200">Produk B</h3>
                                <p class="text-sm text-gray-400">Total: <span class="text-white">Rp 300.000</span></p>
                            </div>
                            <a href="#" class="text-sm text-white px-3 py-1 bg-green-600 rounded-md">Selesai</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
