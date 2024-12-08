<x-layout>
    <section class="bg-neutral-900 flex items-center justify-center min-h-screen m-0">
        <!-- Login -->

        <div
            class="bg-neutral-800 bg-opacity-70 flex rounded-lg shadow-xl max-w-xl w-full p-5 items-center justify-center">
            <!-- Form -->
            <div class="md:w-full px-16 w-full max-w-sm">
                <h2 class="font-bold text-2xl text-white font-pixelify">Login</h2>
                <p class="text-sm mt-4 text-white">Test By Kakaa</p>

                <form action="{{ route('auth.login') }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    <input
                        class="p-2 mt-8 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                        name="email" placeholder="Email">
                    <div class="relative">
                        <input
                            class="p-2 rounded-xl border border-gray-300 w-full focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            name="password" placeholder="Password" type="password">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-eye absolute top-1/2 right-3 -translate-y-1/2 pointer-events-none"
                            viewBox="0 0 16 16">
                            <path
                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                            <path
                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                        </svg>
                    </div>
                    <button
                        class="bg-yellow-400 text-red-700 p-2 rounded-xl mt-4 hover:scale-105 duration-300">Login</button>
                </form>

                <div class="mt-10 grid grid-cols-3 items-center text-gray-500">
                    <hr class="border-gray-400">
                    <p class="text-center text-sm">OR</p>
                    <hr class="border-gray-400">
                </div>

                <a href="{{ url('/auth/redirect') }}">
                    <button
                        class="bg-white border py-2 w-full rounded-xl mt-5 flex justify-center items-center text-sm hover:scale-105 duration-300">
                        <i class="fab fa-google mr-3 text-yellow-500"></i>
                        Login with Google
                    </button>
                </a>

                <p class="mt-5 text-xs border-b border-gray-400 py-4 text-white">
                    Forgot your password?
                    <a href="/lupa-password" class="text-yellow-400 hover:underline">Click here</a>
                </p>
                <div class="mt-3 text-xs flex justify-between items-center text-white">
                    <p>Don't have an account?</p>
                    <a href="/register"
                        class="py-2 px-5 bg-white border rounded-xl hover:scale-110 hover:bg-yellow-400 hover:text-red-700 duration-300 text-[#00354C]">Register</a>
                </div>
            </div>
        </div>
    </section>
</x-layout>
