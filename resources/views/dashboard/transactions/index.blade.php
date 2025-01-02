<x-layout-dashboard>
    <div class="flex flex-col min-h-screen md:flex-row">
        <x-sidebar></x-sidebar>
        <main class="flex-1 p-6">
            <h1 class="text-2xl font-bold mb-6">Daftar Transaksi</h1>

            <!-- Tampilan untuk Desktop dan Tablet -->
            <div class="hidden md:block overflow-x-auto bg-white rounded shadow mt-4">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nomor</th>
                            <th scope="col"
                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Pemesan</th>
                            <th scope="col"
                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Produk</th>
                            <th scope="col"
                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kuantitas</th>
                            <th scope="col"
                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Harga</th>
                            <th scope="col"
                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th scope="col"
                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Transaksi 1 (Pembeli dengan 2 produk) -->
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-700" rowspan="2">1</td>
                            <td class="px-4 py-2 text-sm text-gray-700" rowspan="2">John Doe</td>
                            <td class="px-4 py-2 text-sm text-gray-700">Laptop</td>
                            <td class="px-4 py-2 text-sm text-gray-700">1</td>
                            <td class="px-4 py-2 text-sm text-gray-700">Rp 10,000,000</td>
                            <td class="px-4 py-2" rowspan="2">
                                <span
                                    class="bg-green-200 text-green-800 px-2 py-1 rounded text-xs font-medium">Berhasil</span>
                            </td>
                            <td class="px-4 py-2 text-sm" rowspan="2">
                                <a href="/dashboard/transactions/detail"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-xs font-medium">Lihat
                                    Detail</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-700">Smartphone</td>
                            <td class="px-4 py-2 text-sm text-gray-700">1</td>
                            <td class="px-4 py-2 text-sm text-gray-700">Rp 5,000,000</td>
                        </tr>

                        <!-- Transaksi 2 -->
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-700">2</td>
                            <td class="px-4 py-2 text-sm text-gray-700">Jane Smith</td>
                            <td class="px-4 py-2 text-sm text-gray-700">Mouse</td>
                            <td class="px-4 py-2 text-sm text-gray-700">1</td>
                            <td class="px-4 py-2 text-sm text-gray-700">Rp 500,000</td>
                            <td class="px-4 py-2">
                                <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded text-xs font-medium">Dalam
                                    Proses</span>
                            </td>
                            <td class="px-4 py-2 text-sm">
                                <a href="/dashboard/transactions/deatil"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-xs font-medium">Lihat
                                    Detail</a>
                            </td>
                        </tr>

                        <!-- Transaksi 3 -->
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-700">3</td>
                            <td class="px-4 py-2 text-sm text-gray-700">Sam Wilson</td>
                            <td class="px-4 py-2 text-sm text-gray-700">Keyboard</td>
                            <td class="px-4 py-2 text-sm text-gray-700">2</td>
                            <td class="px-4 py-2 text-sm text-gray-700">Rp 1,000,000</td>
                            <td class="px-4 py-2">
                                <span class="bg-red-200 text-red-800 px-2 py-1 rounded text-xs font-medium">Di
                                    Batalkan</span>
                            </td>
                            <td class="px-4 py-2 text-sm">
                                <a href="/dashboard/transactions/detail"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-xs font-medium">Lihat
                                    Detail</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <!-- Tampilan untuk Mobile -->
            <div class="overflow-x-auto bg-white rounded shadow mt-4 md:hidden">
                <div class="flex flex-col space-y-4">
                    <!-- Transaksi 1 -->
                    <div class="border border-gray-200 rounded p-4 hover:bg-gray-50">
                        <div class="flex justify-between">
                            <h2 class="text-lg font-semibold text-gray-900">John Doe</h2>
                            <span class="bg-green-200 text-green-800 px-2 py-1 rounded text-sm">Berhasil</span>
                        </div>
                        <div class="mt-2">
                            <table class="min-w-full divide-y divide-gray-200">
                                <tbody>
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-500">Produk:</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">Laptop</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-500">Kuantitas:</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">2</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-500">Harga:</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">Rp 10,000,000</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="flex items-center mt-2 space-x-2">
                            <a href="/dashboard/transactions/detail"
                                class="text-blue-500 hover:text-blue-700 text-xs font-semibold">Lihat Detail</a>
                        </div>
                    </div>

                    <!-- Transaksi 2 -->
                    <div class="border border-gray-200 rounded p-4 hover:bg-gray-50">
                        <div class="flex justify-between">
                            <h2 class="text-lg font-semibold text-gray-900">Jane Smith</h2>
                            <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded text-sm">Dalam Proses</span>
                        </div>
                        <div class="mt-2">
                            <table class="min-w-full divide-y divide-gray-200">
                                <tbody>
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-500">Produk:</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">Mouse</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-500">Kuantitas:</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">1</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-500">Harga:</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">Rp 500,000</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="flex items-center mt-2 space-x-2">
                            <a href="/dashboard/transactions/detail"
                                class="text-blue-500 hover:text-blue-700 text-xs font-semibold">Lihat Detail</a>
                        </div>
                    </div>

                    <!-- Transaksi 3 -->
                    <div class="border border-gray-200 rounded p-4 hover:bg-gray-50">
                        <div class="flex justify-between">
                            <h2 class="text-lg font-semibold text-gray-900">Alice Brown</h2>
                            <span class="bg-red-200 text-red-800 px-2 py-1 rounded text-sm">Di Batalkan</span>
                        </div>
                        <div class="mt-2">
                            <table class="min-w-full divide-y divide-gray-200">
                                <tbody>
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-500">Produk:</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">Keyboard</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-500">Kuantitas:</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">1</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-500">Harga:</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">Rp 300,000</td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr class="my-2 border-gray-700">
                            <table class="min-w-full divide-y divide-gray-200">
                                <tbody>
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-500">Produk:</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">Mouse</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-500">Kuantitas:</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">2</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-500">Harga:</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">Rp 600,000</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="flex items-center mt-2 space-x-2">
                            <a href="/dashboard/transactions/detail"
                                class="text-blue-500 hover:text-blue-700 text-xs font-semibold">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>
</x-layout-dashboard>
