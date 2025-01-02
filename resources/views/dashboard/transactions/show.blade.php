<x-layout-dashboard>
    <div class="flex flex-col min-h-screen md:flex-row">
        <x-sidebar></x-sidebar>
        <main class="flex-1 p-6">
            <h1 class="text-2xl font-bold mb-6">Detail Transaksi</h1>
            <div class="bg-white rounded shadow p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-700 mb-2">Informasi Pemesan</h2>
                        <p class="text-gray-600"><strong>Nama Pemesan:</strong> Muhamad Marsa Nur Jaman</p>
                        <p class="text-gray-600"><strong>Alamat:</strong> Kp Tarigu Rt 02 / Rw 09</p>
                    </div>
                </div>
                <div class="mt-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Detail Produk</h2>
                    <table class="min-w-full table-auto divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama Barang
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kategori
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kuantitas
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total Harga
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-600">Stray</td>
                                <td class="px-4 py-2 text-sm text-gray-600">Game</td>
                                <td class="px-4 py-2 text-sm text-gray-600">2</td>
                                <td class="px-4 py-2 text-sm text-gray-600">Rp 350.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Total yang Dibayarkan</h2>
                    <p class="text-gray-600 text-xl font-semibold">Rp 350.000</p>
                </div>
                <div class="mt-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Status Transaksi</h2>
                    <form action="" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="status" class="border border-gray-300 rounded p-2 w-full md:w-1/2">
                            <option value="Berhasil">Berhasil</option>
                            <option value="Dalam Proses">Dalam Proses</option>
                            <option value="Di Batalkan">Di Batalkan</option>
                        </select>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mt-4 w-full md:w-auto">
                            Update Status
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</x-layout-dashboard>
