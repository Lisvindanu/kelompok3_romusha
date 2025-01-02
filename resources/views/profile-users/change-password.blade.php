<x-layout>
    <x-navbar></x-navbar>
    <div class="min-h-screen flex flex-col items-center px-4 md:px-10 pt-10 bg-neutral-900 text-gray-300">
        <!-- Account Wrapper -->
        <div class="container grid grid-cols-1 md:grid-cols-12 gap-6 pt-4 pb-16 mt-7">
            <x-profile-sidebar :activePage="'password'" :userData="$userData" />

            <!-- Main Content -->
            <div class="col-span-12 md:col-span-9">
                <div class="bg-neutral-800 rounded-lg shadow-md p-8">
                    <h2 class="text-xl font-bold text-yellow-400 mb-6 font-pixelify">Ubah Kata Sandi</h2>

                    <!-- Change Password Form -->
                    <form id="passwordForm" action="{{ route('update.password') }}" method="POST" class="space-y-6">
                        @csrf
                        <!-- Current Password -->
                        <div class="relative">
                            <label for="current_password" class="block text-lg text-gray-400 font-pixelify">Kata Sandi
                                Lama</label>
                            <div class="flex items-center mt-2">
                                <input id="current_password" name="current_password" type="password" required
                                    class="bg-neutral-900 text-gray-200 text-lg rounded-md px-6 py-4 w-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition-all duration-300"
                                    placeholder="Masukkan Kata Sandi Lama" />
                                <i class="fas fa-eye absolute right-4 cursor-pointer text-gray-400 toggle-password"></i>
                            </div>
                        </div>

                        <!-- New Password -->
                        <div class="relative">
                            <label for="new_password" class="block text-lg text-gray-400 font-pixelify">Kata Sandi
                                Baru</label>
                            <div class="flex items-center mt-2">
                                <input id="new_password" name="new_password" type="password" required minlength="8"
                                    class="bg-neutral-900 text-gray-200 text-lg rounded-md px-6 py-4 w-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition-all duration-300"
                                    placeholder="Masukkan Kata Sandi Baru (min. 8 karakter)" />
                                <i class="fas fa-eye absolute right-4 cursor-pointer text-gray-400 toggle-password"></i>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="relative">
                            <label for="confirm_password" class="block text-lg text-gray-400 font-pixelify">Konfirmasi
                                Kata Sandi Baru</label>
                            <div class="flex items-center mt-2">
                                <input id="confirm_password" name="confirm_password" type="password" required
                                    class="bg-neutral-900 text-gray-200 text-lg rounded-md px-6 py-4 w-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition-all duration-300"
                                    placeholder="Konfirmasi Kata Sandi Baru" />
                                <i class="fas fa-eye absolute right-4 cursor-pointer text-gray-400 toggle-password"></i>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit" id="submitBtn"
                                class="bg-yellow-500 text-red-800 py-2 px-8 rounded-md font-medium hover:bg-yellow-400 transition font-pixelify">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                    <script>
                        // Custom SweetAlert2 theme
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            customClass: {
                                popup: 'colored-toast'
                            },
                        });

                        // Add custom styles for the toast
                        const style = document.createElement('style');
                        style.textContent = `
                            .colored-toast.swal2-icon-success {
                                background-color: #1F2937 !important;
                                color: #ffffff !important;
                                border-radius: 10px !important;
                                border-left: 4px solid #10B981 !important;
                            }
                            .colored-toast .swal2-title {
                                color: #ffffff !important;
                                font-family: 'Pixelify Sans', sans-serif !important;
                            }
                            .colored-toast .swal2-close {
                                color: #ffffff !important;
                            }
                        `;
                        document.head.appendChild(style);

                        // Toggle password visibility
                        document.querySelectorAll('.toggle-password').forEach(icon => {
                            icon.addEventListener('click', function() {
                                const input = this.parentElement.querySelector('input');
                                if (input.type === 'password') {
                                    input.type = 'text';
                                    this.classList.remove('fa-eye');
                                    this.classList.add('fa-eye-slash');
                                } else {
                                    input.type = 'password';
                                    this.classList.remove('fa-eye-slash');
                                    this.classList.add('fa-eye');
                                }
                            });
                        });

                        // Form submission
                        const form = document.getElementById('passwordForm');
                        const submitBtn = document.getElementById('submitBtn');

                        form.addEventListener('submit', async function(e) {
                            e.preventDefault();
                            submitBtn.disabled = true;
                            submitBtn.innerText = 'Menyimpan...';

                            try {
                                const formData = new FormData(form);
                                const response = await fetch(form.action, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        current_password: formData.get('current_password'),
                                        new_password: formData.get('new_password'),
                                        confirm_password: formData.get('confirm_password')
                                    })
                                });

                                const data = await response.json();

                                if (data.status === 'success') {
                                    await Toast.fire({
                                        icon: 'success',
                                        title: 'Password berhasil diubah!'
                                    });
                                    setTimeout(() => {
                                        window.location.href = '/login';
                                    }, 1000);
                                } else {
                                    submitBtn.disabled = false;
                                    submitBtn.innerText = 'Simpan Perubahan';
                                    Toast.fire({
                                        icon: 'error',
                                        title: data.message || 'Terjadi kesalahan'
                                    });
                                }
                            } catch (error) {
                                submitBtn.disabled = false;
                                submitBtn.innerText = 'Simpan Perubahan';
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Terjadi kesalahan'
                                });
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-layout>
