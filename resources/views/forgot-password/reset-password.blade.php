<x-layout>
    <section class="bg-neutral-900 flex items-center justify-center min-h-screen m-0">
        <!-- Reset Password -->
        <div class="bg-neutral-800 bg-opacity-70 flex rounded-lg shadow-xl max-w-xl w-full p-5 items-center justify-center">
            <div class="md:w-full px-16 w-full max-w-sm">
                <h2 class="font-bold text-2xl text-white font-pixelify">Reset Password</h2>
                <p class="text-sm mt-4 text-white">Enter a new password for your account.</p>

                <form action="{{ route('auth.reset-password') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div>
                        <label for="newPassword" class="text-white">New Password:</label>
                        <input type="password" name="newPassword" id="newPassword" required class="w-full p-2 mt-2 rounded-md">
                    </div>
                    <div>
                        <label for="newPassword_confirmation" class="text-white">Confirm New Password:</label>
                        <input type="password" name="newPassword_confirmation" id="newPassword_confirmation" required class="w-full p-2 mt-2 rounded-md">
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 mt-4 rounded-md">Reset Password</button>
                </form>

                <div class="mt-5 text-xs text-white flex justify-between">
                    <a href="/login" class="hover:underline">Back to Login</a>
                    <a href="/register" class="hover:underline">Register</a>
                </div>
            </div>
        </div>
    </section>
</x-layout>
