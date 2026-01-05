<!DOCTYPE html>
<html lang="en">
@include('components.header')

<body class="bg-gray-50 antialiased">
    <div class="min-h-screen bg-gray-50">
        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Main Content Area -->
        <main class="md:ml-64 lg:ml-72 flex flex-col min-h-screen">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mx-4 mt-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
                    <p class="font-semibold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mx-4 mt-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
                    <p class="font-semibold">Error!</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="mx-4 mt-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
                    <p class="font-semibold">Ada kesalahan:</p>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Content -->
            <div class="flex-1">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Toggle mobile menu
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const closeMenuBtn = document.getElementById('close-menu-btn');

        if (menuBtn && mobileMenu && closeMenuBtn) {
            menuBtn.addEventListener('click', () => {
                mobileMenu.classList.remove('translate-x-full');
            });

            closeMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.add('translate-x-full');
            });
        }
    </script>
</body>

</html>
