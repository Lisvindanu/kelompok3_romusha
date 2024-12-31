@props(['activePage' => '', 'userData' => []])

<div class="col-span-12 md:col-span-3">
    <!-- Account Profile -->
    <div class="bg-neutral-800 rounded-lg shadow-md p-4 flex flex-col md:flex-row items-center gap-4">
        <div class="flex-grow text-center md:text-left">
            <h4 class="text-lg font-semibold text-white">{{ $userData['fullname'] ?? $userData['username'] }}</h4>
        </div>
    </div>

    <!-- Profile Links -->
    <div class="bg-neutral-800 rounded-lg shadow-md mt-6 divide-y divide-yellow-300">
        <a href="/profile-users"
           class="block py-3 px-5 {{ $activePage === 'profile' ? 'bg-yellow-400 text-red-800' : 'hover:bg-yellow-400 hover:text-red-800' }} font-medium flex items-center gap-3 font-pixelify">
            <i class="fas fa-user-circle"></i> Info Profil
        </a>
        <a href="{{ route('change.password.form') }}"
           class="block py-3 px-5 {{ $activePage === 'password' ? 'bg-yellow-400 text-red-800' : 'hover:bg-yellow-400 hover:text-red-800' }} font-medium flex items-center gap-3 font-pixelify">
            <i class="fas fa-key"></i> Ubah Kata Sandi
        </a>
        <a href="/history-order"
           class="block py-3 px-5 {{ $activePage === 'history' ? 'bg-yellow-400 text-red-800' : 'hover:bg-yellow-400 hover:text-red-800' }} font-medium flex items-center gap-3 font-pixelify">
            <i class="fas fa-history"></i> Riwayat Pesanan
        </a>
        <form action="{{ route('auth.logout') }}" method="POST" class="block">
            @csrf
            <button type="submit"
                    class="w-full text-left py-3 px-5 hover:bg-yellow-400 hover:text-red-800 font-medium flex items-center gap-3 font-pixelify">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </button>
        </form>
    </div>
</div>
