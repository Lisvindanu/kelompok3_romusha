
<x-layout>
    <section class="bg-neutral-900 flex items-center justify-center min-h-screen m-0">
        <div class="bg-neutral-800 bg-opacity-70 flex rounded-lg shadow-xl max-w-xl w-full p-5 items-center justify-center">
            <div class="md:w-full px-16 w-full max-w-sm">
                <h2 class="font-bold text-2xl text-white font-pixelify">Enter OTP</h2>
                <p class="text-sm mt-4 text-white">We've sent an OTP to your email. Please enter it below:</p>
                <form action="{{ route('auth.verifyOtp') }}" method="POST">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('email') }}">
                    <div class="mb-3">
                        <label for="otp" class="form-label">Enter OTP</label>
                        <input type="text" name="otp" id="otp" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Verify</button>
                </form>
            </div>
        </div>
    </section>
</x-layout>
