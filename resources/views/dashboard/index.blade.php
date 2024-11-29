<x-layout-dashboard>
    <div class="flex flex-col min-h-screen md:flex-row">
        <!-- Sidebar -->
        <x-sidebar></x-sidebar>

        <!-- Konten Utama -->
        <main class="flex-1 p-6">
            <div class="flex justify-between items-center border-b pb-4 mb-4">
                <h1 class="text-2xl font-semibold">Selamat Datang Kembali, Anjay Bisa</h1>
            </div>

            <div class="my-4">
                <canvas id="myChart" class="w-full bg-white rounded shadow"></canvas>
            </div>
        </main>
    </div>

    <!-- JavaScript untuk Toggle Sidebar -->
    <script>
        const toggleButton = document.getElementById('toggleButton');
        const sidebar = document.getElementById('sidebar');

        toggleButton.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });
    </script>
</x-layout-dashboard>
