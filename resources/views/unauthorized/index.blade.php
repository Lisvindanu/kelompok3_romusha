<x-layout>
    <section class="flex items-center justify-center min-h-screen m-0"
             style="background: linear-gradient(180deg, #d7550a 30%, rgba(0, 0, 0, 0.7) 90%);">
        <div class="bg-neutral-800 bg-opacity-80 flex flex-col items-center rounded-xl shadow-2xl max-w-md w-full p-8">
            <!-- Logo -->
            <div class="mb-6">
                <img src="{{ asset('storage/img/logo.png') }}" alt="Logo" class="mx-auto" width="100">
            </div>

            <!-- Content -->
            <div class="w-full px-6 text-center">
                <div class="mb-6">
                    <svg class="mx-auto h-16 w-16 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>

                <h2 class="font-bold text-2xl text-white font-pixelify mb-4">Unauthorized Access</h2>

                <p class="text-gray-300 mb-8">
                    Sorry, you don't have permission to access this page. Please contact your administrator if you believe this is a mistake.
                </p>

                <a href="{{ route('home') }}">
                    <button class="bg-yellow-400 text-red-700 p-3 rounded-xl w-full hover:bg-yellow-500 hover:text-red-800 transition-all duration-300 shadow-md transform hover:scale-105">
                        Return to Home
                    </button>
                </a>

                @guest
                    <div class="mt-6 grid grid-cols-3 items-center text-gray-500">
                        <hr class="border-gray-400">
                        <p class="text-center text-sm">OR</p>
                        <hr class="border-gray-400">
                    </div>

                    <div class="mt-4 text-xs text-center text-white">
                        <p class="mb-2">Already have an account?</p>
                        <a href="{{ route('login') }}"
                           class="py-2 px-5 bg-white border rounded-xl hover:bg-yellow-400 hover:text-red-700 duration-300 text-[#00354C] inline-block">
                            Login here
                        </a>
                    </div>
                @endguest
            </div>
        </div>
    </section>
</x-layout>
