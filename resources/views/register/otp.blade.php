<x-layout>
    <section class="flex items-center justify-center min-h-screen m-0"
        style="background: linear-gradient(180deg, #d7550a 30%, rgba(0, 0, 0, 0.7) 90%);">
        <div class="bg-neutral-800 bg-opacity-80 flex flex-col items-center rounded-xl shadow-2xl max-w-md w-full p-8">
            <!-- Logo -->
            <div class="mb-6">
                <img src="{{ asset('storage/img/logo.png') }}" alt="Logo" class="mx-auto" width="100"> <!-- Ganti dengan path logo jika ada -->
            </div>

            <!-- Form -->
            <div class="md:w-full px-6 w-full">
                <h2 class="font-bold text-2xl text-white font-pixelify text-center">Enter OTP</h2>
                <p class="text-sm mt-4 text-white text-center">We've sent an OTP to your email. Please enter it below:</p>

                <form action="{{ route('auth.verifyOtp') }}" method="POST" class="flex flex-col gap-4 mt-6">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('email') }}">

                    <div class="mb-3">
                        <input type="text" name="otp" id="otp" class="p-3 rounded-xl border border-gray-300 w-full focus:outline-none focus:ring-2 focus:ring-yellow-400 transition-all duration-300" required placeholder="Enter OTP">
                    </div>

                    <button type="submit" class="bg-yellow-400 text-red-700 py-2 rounded-xl  hover:bg-yellow-500 hover:text-red-800 transition-all duration-300 shadow-md transform hover:scale-105">
                        Verify
                    </button>
                </form>
            </div>
        </div>
    </section>
</x-layout>
