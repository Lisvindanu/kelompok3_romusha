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
                    <a href="#" class="block py-3 px-5 bg-yellow-400 text-red-800 font-medium flex items-center gap-3 font-pixelify">
                        <i class="fas fa-user-circle"></i> Info Profil
                    </a>
                    <a href="#" class="block py-3 px-5 hover:bg-yellow-400 hover:text-red-800 font-medium flex items-center gap-3 font-pixelify">
                        <i class="fas fa-key"></i> Ubah Kata Sandi
                    </a>
                    <a href="#" class="block py-3 px-5 hover:bg-yellow-400 hover:text-red-800 font-medium flex items-center gap-3 font-pixelify">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-span-12 md:col-span-9">
                <div class="bg-neutral-800 rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-yellow-400 mb-6 font-pixelify">Profil Pribadi</h2>

                    <!-- Profile Display -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-lg text-gray-400 font-pixelify">Nama</label>
                            <p id="name" class="bg-neutral-900 text-gray-200 text-lg rounded-md px-6 py-4 mt-2"></p>
                        </div>
                        <div>
                            <label for="email" class="block text-lg text-gray-400 font-pixelify">Email</label>
                            <p id="email" class="bg-neutral-900 text-gray-200 text-lg rounded-md px-6 py-4 mt-2"></p>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button 
                            id="edit-button" 
                            class="bg-yellow-500 text-red-800 py-2 px-6 rounded-md font-medium hover:bg-yellow-400 transition font-pixelify">
                            Ubah Profil
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
