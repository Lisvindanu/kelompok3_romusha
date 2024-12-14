<x-layout>
    <section class="bg-neutral-900 flex items-center justify-center min-h-screen m-0">
        <!-- Forgot Password -->
        <div
            class="bg-neutral-800 bg-opacity-70 flex rounded-lg shadow-xl max-w-xl w-full p-5 items-center justify-center">
            <div class="md:w-full px-16 w-full max-w-sm">
                <h2 class="font-bold text-2xl text-white font-pixelify">Forgot Password</h2>
                <p class="text-sm mt-4 text-white">Enter your email to reset your password.</p>

                <form action="{{ route('auth.password-reset-request') }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    <input
                        class="p-2 mt-8 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                        name="email" placeholder="Email" required>
                    <button class="bg-yellow-400 text-red-700 p-2 rounded-xl mt-4 hover:scale-105 duration-300">
                        Send Reset Link
                    </button>
                </form>


                <div class="mt-5 text-xs text-white flex justify-between">
                    <a href="/login" class="hover:underline">Back to Login</a>
                    <a href="/register" class="hover:underline">Register</a>
                </div>
            </div>
        </div>
    </section>
</x-layout>
