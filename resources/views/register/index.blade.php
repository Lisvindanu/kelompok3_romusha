<x-layout>
    <section class="flex items-center justify-center min-h-screen m-0"
        style="background: linear-gradient(180deg, #d7550a 30%, rgba(0, 0, 0, 0.7) 90%);">
        <!-- Register -->
        <div class="bg-neutral-800 bg-opacity-80 flex flex-col items-center rounded-xl shadow-2xl max-w-md w-full p-8">
            <!-- Logo -->
            <div class="mb-6">
                <img src="{{ asset('storage/img/logo.png') }}" alt="Logo" class="mx-auto" width="100">
            </div>

            <!-- Form -->
            <div class="md:w-full px-6 w-full">
                <h2 class="font-bold text-2xl text-white font-pixelify text-center">Register</h2>
                <p class="text-sm mt-4 text-white text-center">Create your account to get started</p>

                @if ($errors->any())
                    <div class="bg-red-500 text-white p-2 rounded-lg mb-4">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                @if (session('success'))
                    <div class="bg-green-500 text-white p-2 rounded-lg mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('auth.register') }}" method="POST" class="flex flex-col gap-4 mt-6">
                    @csrf
                    <input
                        class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition-all duration-300"
                        name="username" placeholder="Username" required>

                    <input
                        class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition-all duration-300"
                        name="fullname" placeholder="Full Name" required>

                    <input
                        class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition-all duration-300"
                        name="email" placeholder="Email" type="email" required>

                    <!-- Password Field -->
                    <div class="relative">
                        <input
                            class="p-3 rounded-xl border border-gray-300 w-full focus:outline-none focus:ring-2 focus:ring-yellow-400 transition-all duration-300"
                            id="password" name="password" placeholder="Password" type="password" required>
                        <i class="fas fa-eye-slash absolute top-1/2 right-3 -translate-y-1/2 cursor-pointer toggle-password"></i>
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="relative">
                        <input
                            class="p-3 rounded-xl border border-gray-300 w-full focus:outline-none focus:ring-2 focus:ring-yellow-400 transition-all duration-300"
                            id="password_confirmation" name="password_confirmation" placeholder="Confirm Password"
                            type="password" required>
                        <i class="fas fa-eye-slash absolute top-1/2 right-3 -translate-y-1/2 cursor-pointer toggle-password"></i>
                    </div>

                    <button type="submit"
                        class="bg-yellow-400 text-red-700 p-3 rounded-xl mt-4 hover:bg-yellow-500 hover:text-red-800 transition-all duration-300 shadow-md transform hover:scale-105">
                        Register
                    </button>
                </form>

                <p class="mt-4 text-xs border-b border-gray-400 py-3 text-white text-center">
                    Already have an account?
                    <a href="/login" class="text-yellow-400 hover:underline">Login</a>
                </p>
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
