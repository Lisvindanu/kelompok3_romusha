<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/cart.js'])
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- font --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400..700&display=swap');
    </style>
    {{-- font awesome --}}
    <script src="https://kit.fontawesome.com/e20865611c.js" crossorigin="anonymous"></script>
    <title>Home</title>
</head>

<body class="h-full">
    <div class="min-h-full">
        <main class="bg-neutral-900">
            <!-- Your content -->
            {{ $slot }}
        </main>
        @stack('scripts')
    </div>
</body>

</html>
