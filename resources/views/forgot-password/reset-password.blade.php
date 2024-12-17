<x-layout>
    <section class="flex items-center justify-center min-h-screen m-0"
        style="background: linear-gradient(180deg, #d7550a 30%, rgba(0, 0, 0, 0.7) 90%);">
        <div class="bg-neutral-800 bg-opacity-80 flex flex-col items-center rounded-xl shadow-2xl max-w-md w-full p-8">
            <!-- Logo (opsional, jika ada logo) -->
            <div class="mb-6">
                <img src="{{ asset('storage/img/logo.png') }}" alt="Logo" class="mx-auto" width="100"> <!-- Ganti dengan path logo jika ada -->
            </div>

            <!-- Form -->
            <div class="md:w-full px-6 w-full">
                <h2 class="font-bold text-2xl text-white font-pixelify text-center">Reset Password</h2>
                <p class="text-sm mt-4 text-white text-center">Enter a new password for your account.</p>

                <form action="{{ route('auth.reset-password') }}" method="POST" class="flex flex-col gap-4 mt-6">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <input
                        class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition-all duration-300"
                        type="password" name="newPassword" placeholder="New Password" required>
                    <input
                        class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition-all duration-300"
                        type="password" name="newPassword_confirmation" placeholder="Confirm New Password" required>

                    <button
                        class="bg-yellow-400 text-red-700 p-3 rounded-xl hover:bg-yellow-500 hover:text-red-800 transition-all duration-300 shadow-md transform hover:scale-105">
                        Reset Password
                    </button>
                </form>

                <div class="mt-6 text-xs text-center text-white flex justify-between">
                    <a href="/login" class="hover:underline">Back to Login</a>
                    <a href="/register" class="hover:underline">Register</a>
                </div>
            </div>
        </div>
    </section>
</x-layout>
