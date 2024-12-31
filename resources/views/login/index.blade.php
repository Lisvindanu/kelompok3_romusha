<x-layout>
    <section class="flex items-center justify-center min-h-screen m-0"
        style="background: linear-gradient(180deg, #d7550a 30%, rgba(0, 0, 0, 0.7) 90%);">
        <!-- Login -->

        <div class="bg-neutral-800 bg-opacity-80 flex flex-col items-center rounded-xl shadow-2xl max-w-md w-full p-8">
            <!-- Logo -->
            <div class="mb-6">
                <img src="{{ asset('storage/img/logo.png') }}" alt="Logo" class="mx-auto" width="100">
            </div>

            <!-- Form -->
            <div class="md:w-full px-6 w-full">
                <h2 class="font-bold text-2xl text-white font-pixelify text-center">Login</h2>

                <form action="{{ route('auth.login') }}" method="POST" class="flex flex-col gap-4 mt-6">
                    @csrf
                    <input
                        class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition-all duration-300"
                        name="email" placeholder="Email" type="email" required>

                    <!-- Password Field with Eye Icon -->
                    <div class="relative">
                        <label for="password" class="sr-only">Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            class="p-3 rounded-xl border border-gray-300 w-full focus:outline-none focus:ring-2 focus:ring-yellow-400 transition-all duration-300"
                            placeholder="Password">
                        <i class="fas fa-eye-slash absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer text-gray-400 toggle-password"></i>
                    </div>

                    <button
                        class="bg-yellow-400 text-red-700 p-3 rounded-xl mt-4 hover:bg-yellow-500 hover:text-red-800 transition-all duration-300 shadow-md transform hover:scale-105">
                        Login
                    </button>
                </form>

                <div class="mt-6 grid grid-cols-3 items-center text-gray-500">
                    <hr class="border-gray-400">
                    <p class="text-center text-sm">OR</p>
                    <hr class="border-gray-400">
                </div>

                <a href="{{ url('/auth/redirect') }}">
                    <button
                        class="bg-white border py-3 w-full rounded-xl mt-5 flex justify-center items-center text-sm hover:scale-105 duration-300 shadow-md hover:bg-yellow-100">
                        <i class="fab fa-google mr-3 text-yellow-500"></i>
                        Login with Google
                    </button>
                </a>

                <p class="mt-4 text-xs border-b border-gray-400 py-3 text-white text-center">
                    Forgot your password?
                    <a href="/forgot-password" class="text-yellow-400 hover:underline">Click here</a>
                </p>

                <div class="mt-4 text-xs text-center text-white flex justify-between items-center">
                    <p>Don't have an account?</p>
                    <a href="/register"
                        class="py-2 px-5 bg-white border rounded-xl hover:bg-yellow-400 hover:text-red-700 duration-300 text-[#00354C]">
                        Register
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- JavaScript -->
    <script>
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', function () {
                const input = this.previousElementSibling;
                if (input.type === 'password') {
                    input.type = 'text';
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye');
                } else {
                    input.type = 'password';
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash');
                }
            });
        });
    </script>
</x-layout>
