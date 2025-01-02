<x-layout>
    <x-navbar></x-navbar>

    <script type="text/javascript"
            src="https://app.midtrans.com/snap/snap.js"
            data-client-key="{{ config('services.midtrans.client_key') }}">
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentForm = {
                loading: false,
                name: '{{ session('userData')['fullname'] ?? $userData['fullname'] ?? '' }}',
                phone: '{{ session('userData')['phoneNumber'] ?? $userData['phoneNumber'] ?? '' }}',
                alamat: '{{ session('userData')['address'] ?? $userData['address'] ?? '' }}',

                init() {
                    // Set initial values to form fields
                    document.getElementById('name').value = this.name;
                    document.getElementById('phone').value = this.phone;
                    document.getElementById('alamat').value = this.alamat;

                    // Add event listeners
                    document.getElementById('payment-button').addEventListener('click', this.handlePayment.bind(this));
                },

                updateField(field, value) {
                    this[field] = value;
                },

                async handlePayment(e) {
                    e.preventDefault();

                    // Validate fields
                    if (!this.name || !this.phone || !this.alamat) {
                        alert('Semua field harus diisi!');
                        return;
                    }

                    this.loading = true;
                    this.updateButtonState(true);

                    try {
                        // Log data yang akan dikirim
                        console.log('Sending payment data:', {
                            amount: {{ $totalPrice + $shippingCost }},
                            items: {!! json_encode($selectedItems) !!}
                        });

                        const response = await fetch('{{ route('payment.create') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                amount: {{ $totalPrice + $shippingCost }},
                                items: {!! json_encode($selectedItems) !!}
                            })
                        });

                        // Log response status
                        console.log('Response status:', response.status);

                        if (!response.ok) {
                            const errorText = await response.text();
                            console.error('Server error:', errorText);
                            throw new Error(errorText || 'Failed to create payment');
                        }

                        const data = await response.json();

                        if (!data.token) {
                            throw new Error('No payment token received');
                        }

                        console.log('Payment token received:', data.token);

                        window.snap.pay(data.token, {
                            onSuccess: (result) => {
                                console.log('Payment success:', result);
                                document.getElementById('payment-form').submit();
                            },
                            onPending: (result) => {
                                console.log('Payment pending:', result);
                                alert('Pembayaran pending');
                                this.loading = false;
                                this.updateButtonState(false);
                            },
                            onError: (error) => {
                                console.error('Payment error:', error);
                                alert('Pembayaran gagal');
                                this.loading = false;
                                this.updateButtonState(false);
                            },
                            onClose: () => {
                                console.log('Snap popup closed');
                                this.loading = false;
                                this.updateButtonState(false);
                            }
                        });
                    } catch (error) {
                        console.error('Payment processing error:', error);
                        alert('Gagal memproses pembayaran: ' + error.message);
                        this.loading = false;
                        this.updateButtonState(false);
                    }
                },

                updateButtonState(isLoading) {
                    const button = document.getElementById('payment-button');
                    const loadingText = button.querySelector('[data-loading]');
                    const normalText = button.querySelector('[data-normal]');

                    if (isLoading) {
                        button.disabled = true;
                        loadingText.classList.remove('hidden');
                        normalText.classList.add('hidden');
                    } else {
                        button.disabled = false;
                        loadingText.classList.add('hidden');
                        normalText.classList.remove('hidden');
                    }
                }
            };

            paymentForm.init();
        });
    </script>

    <div class="container min-h-screen mx-auto p-8 mt-14">
        <!-- Form dan Ringkasan -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Formulir Pengiriman -->
            <div class="lg:col-span-2 bg-neutral-800 rounded-lg shadow p-8 text-gray-300">
                <h2 class="text-2xl font-bold mb-8 text-yellow-400">Formulir Pembayaran</h2>
                <form action="{{ route('payment.process') }}" method="POST" class="space-y-8" id="payment-form">
                    @csrf
                    <input type="hidden" name="items" value="{{ request()->query('items') }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label for="name" class="block text-lg text-gray-400">Nama</label>
                            <input type="text" id="name" name="name" required
                                   class="mt-2 block w-full rounded-md bg-neutral-900 border border-gray-700 text-gray-200 px-6 py-4"
                                   onchange="paymentForm.updateField('name', this.value)">
                        </div>
                        <div>
                            <label for="phone" class="block text-lg text-gray-400">Nomor Handphone</label>
                            <input type="text" id="phone" name="phone" required
                                   class="mt-2 block w-full rounded-md bg-neutral-900 border border-gray-700 text-gray-200 px-6 py-4"
                                   onchange="paymentForm.updateField('phone', this.value)">
                        </div>
                    </div>

                    <div>
                        <label for="alamat" class="block text-lg text-gray-400">Alamat</label>
                        <textarea id="alamat" name="alamat" rows="2" required
                                  class="mt-2 block w-full rounded-md bg-neutral-900 border border-gray-700 text-gray-200 px-6 py-4"
                                  onchange="paymentForm.updateField('alamat', this.value)"></textarea>
                    </div>
                </form>
            </div>

            <!-- Ringkasan Produk -->
            <div class="bg-neutral-800 rounded-lg shadow p-8 text-gray-300">
                <h2 class="text-2xl font-bold mb-8 text-yellow-400">Ringkasan Produk</h2>
                <div class="space-y-6">
                    @foreach($selectedItems as $item)
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <img src="{{ 'https://virtual-realm.my.id' . $item['image_url'] }}"
                                     alt="{{ $item['product_name'] }}"
                                     class="w-12 h-12 object-cover rounded-md mr-4"
                                     onerror="this.src='https://virtual-realm.my.id/uploads/images/default-image.jpg'">
                                <span>{{ $item['product_name'] }}</span>
                            </div>
                            <span>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Ringkasan Pembayaran -->
        <div class="mt-8 bg-neutral-800 rounded-lg shadow p-8 text-gray-300">
            <h2 class="text-2xl font-bold mb-8 text-yellow-400">Ringkasan Pembayaran</h2>
            <div class="space-y-6">
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Biaya Pengiriman</span>
                    <span>Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between font-bold text-xl">
                    <span>Total</span>
                    <span class="text-yellow-400">Rp {{ number_format($totalPrice + $shippingCost, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Tombol Buat Pesanan -->
            <div class="mt-6 text-center">
                <button type="button"
                        id="payment-button"
                        class="bg-yellow-500 hover:bg-yellow-400 text-red-800 font-bold py-2 px-6 rounded">
                    <span data-normal>Bayar</span>
                    <span data-loading class="hidden">Memproses...</span>
                </button>
            </div>
        </div>
    </div>
</x-layout>
