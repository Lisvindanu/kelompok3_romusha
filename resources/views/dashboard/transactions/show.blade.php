<x-layout-dashboard>
    <div class="flex flex-col min-h-screen md:flex-row">
        <x-sidebar></x-sidebar>
        <main class="flex-1 p-6">
            <h1 class="text-2xl font-bold mb-6">Detail Transaksi</h1>
            <div class="bg-white rounded shadow p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-700 mb-2">Informasi Order</h2>
                        <p class="text-gray-600"><strong>Order ID:</strong> {{ $transaction->order_id }}</p>
                        <p class="text-gray-600"><strong>User ID:</strong> {{ $transaction->user_id }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Total yang Dibayarkan</h2>
                    <p class="text-gray-600 text-xl font-semibold">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
                </div>
                <div class="mt-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Status Transaksi</h2>
                    <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="status" class="border border-gray-300 rounded p-2 w-full md:w-1/2">
                            <option value="pending" {{ $transaction->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="success" {{ $transaction->status === 'success' ? 'selected' : '' }}>Success</option>
                            <option value="failed" {{ $transaction->status === 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mt-4 w-full md:w-auto">
                            Update Status
                        </button>
                    </form>
                </div>
                <div class="mt-4">
                    <p class="text-sm text-gray-600">Created: {{ $transaction->created_at }}</p>
                    <p class="text-sm text-gray-600">Last Updated: {{ $transaction->updated_at }}</p>
                </div>
            </div>
        </main>
    </div>
</x-layout-dashboard>
