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
                    <a href="" class="block py-3 px-5 bg-yellow-400 text-red-800 font-medium flex items-center gap-3 font-pixelify">
                        <i class="fas fa-key"></i> Ubah Kata Sandi
                    </a>
                    <a href="history-order" class="block py-3 px-5 hover:bg-yellow-400 hover:text-red-800 font-medium flex items-center gap-3 font-pixelify">
                        <i class="fas fa-history"></i> Riwayat Pesanan
                    </a>
                    <a href="#" class="block py-3 px-5 hover:bg-yellow-400 hover:text-red-800 font-medium flex items-center gap-3 font-pixelify">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-span-12 md:col-span-9">
                <div class="bg-neutral-800 rounded-lg shadow-md p-8">
                    <h2 class="text-xl font-bold text-yellow-400 mb-6 font-pixelify">Ubah Kata Sandi</h2>

                    <!-- Change Password Form -->
                    <form action="" method="POST" class="space-y-6">
                        @csrf

                        <!-- Current Password -->
                        <div class="relative">
                            <label for="current_password" class="block text-lg text-gray-400 font-pixelify">Kata Sandi Lama</label>
                            <div class="flex items-center mt-2">
                                <input 
                                    id="current_password"
                                    name="current_password"
                                    type="password"
                                    required
                                    class="bg-neutral-900 text-gray-200 text-lg rounded-md px-6 py-4 w-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition-all duration-300"
                                    placeholder="Masukkan Kata Sandi Lama"
                                />
                                <i class="fas fa-eye absolute right-4 cursor-pointer text-gray-400"></i>
                            </div>
                        </div>

                        <!-- New Password -->
                        <div class="relative">
                            <label for="new_password" class="block text-lg text-gray-400 font-pixelify">Kata Sandi Baru</label>
                            <div class="flex items-center mt-2">
                                <input 
                                    id="new_password"
                                    name="new_password"
                                    type="password"
                                    required
                                    class="bg-neutral-900 text-gray-200 text-lg rounded-md px-6 py-4 w-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition-all duration-300"
                                    placeholder="Masukkan Kata Sandi Baru"
                                />
                                <i class="fas fa-eye absolute right-4 cursor-pointer text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="relative">
                            <label for="confirm_password" class="block text-lg text-gray-400 font-pixelify">Konfirmasi Kata Sandi Baru</label>
                            <div class="flex items-center mt-2">
                                <input 
                                    id="confirm_password"
                                    name="confirm_password"
                                    type="password"
                                    required
                                    class="bg-neutral-900 text-gray-200 text-lg rounded-md px-6 py-4 w-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition-all duration-300"
                                    placeholder="Konfirmasi Kata Sandi Baru"
                                />
                                <i class="fas fa-eye absolute right-4 cursor-pointer text-gray-400"></i>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button 
                                type="submit" 
                                class="bg-yellow-500 text-red-800 py-2 px-8 rounded-md font-medium hover:bg-yellow-400 transition font-pixelify">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>
