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
                        name="email" placeholder="Email" type="email" required>

                    <div class="relative">
                        <input
                            class="p-3 rounded-xl border border-gray-300 w-full focus:outline-none focus:ring-2 focus:ring-yellow-400 transition-all duration-300"
                            type="password" name="password" placeholder="Password" required>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-eye absolute top-1/2 right-3 -translate-y-1/2 pointer-events-none"
                            viewBox="0 0 16 16">
                            <path
                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                            <path
                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                        </svg>
                    </div>

                    <div class="relative">
                        <input
                            class="p-3 rounded-xl border border-gray-300 w-full focus:outline-none focus:ring-2 focus:ring-yellow-400 transition-all duration-300"
                            type="password" name="password_confirmation" placeholder="Confirm Password" required>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-eye absolute top-1/2 right-3 -translate-y-1/2 pointer-events-none"
                            viewBox="0 0 16 16">
                            <path
                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                            <path
                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                        </svg>
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
</x-layout>
