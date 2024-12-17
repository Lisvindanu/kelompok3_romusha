<x-layout>
    <section class="flex items-center justify-center min-h-screen m-0"
        style="background: linear-gradient(180deg, #d7550a 30%, rgba(0, 0, 0, 0.7) 90%);">
        <div class="bg-neutral-800 bg-opacity-80 flex flex-col items-center rounded-xl shadow-2xl max-w-md w-full p-8">
            <!-- Logo (opsional, jika ada logo) -->
            <div class="mb-6">
                <img src="{{ asset('storage/img/logo.png') }}" alt="Logo" class="mx-auto" width="100"> 
            </div>

            <!-- Form -->
            <div class="md:w-full px-6 w-full">
                <h2 class="font-bold text-2xl text-white font-pixelify text-center">Forgot Password</h2>
                <p class="text-sm mt-4 text-white text-center">Enter your email to reset your password.</p>

                <form action="{{ route('auth.password-reset-request') }}" method="POST" class="flex flex-col gap-4 mt-6">
                    @csrf
                    <input
                        class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition-all duration-300"
                        name="email" placeholder="Email" type="email" required>

                    <button
                        class="bg-yellow-400 text-red-700 p-3 rounded-xl mt-4 hover:bg-yellow-500 hover:text-red-800 transition-all duration-300 shadow-md transform hover:scale-105">
                        Send Reset Link
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
