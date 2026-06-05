<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Mercure Karawang - Reservasi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        emerald: {
                            500: '#602460',
                            600: '#4b1b4b',
                            700: '#331233',
                        },
                        dark: '#DFDBCF',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 pb-20 md:pb-0"> <nav class="bg-emerald-700 text-white sticky top-0 z-50 px-4 md:px-6 py-4 shadow-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="text-lg md:text-xl font-bold tracking-wider text-emerald-500">MERCURE <span class="text-white">KARAWANG</span></a>
            <div class="hidden md:flex space-x-6 items-center">
                <a href="/" class="text-emerald-500 font-medium">Beranda</a>
                <a href="{{ route('kamar') }}" class="hover:text-emerald-500 transition">Kamar</a>
                <a href="#" class="hover:text-emerald-500 transition">Tentang Kami</a>
                @guest
                    <a href="{{ route('login') }}" class="text-xs bg-emerald-500 text-white px-3 py-1.5 rounded-md font-semibold">Login</a>
                @endguest
                @auth
                    <div class="flex items-center gap-3">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 text-white">
                            <span class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center font-semibold">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</span>
                            <span class="hidden md:inline">{{ auth()->user()->name }}</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="ml-2">
                            @csrf
                            <button type="submit" class="text-xs bg-transparent border border-white/20 hover:bg-white/10 px-3 py-1.5 rounded-md">Logout</button>
                        </form>
                    </div>
                @endauth
            </div>
            </div>
            <div class="block md:hidden">
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

<!-- Bottom Navigation Bar (Mobile Only) - DYNAMIC ACTIVE STATE -->
    <div class="fixed bottom-0 left-0 right-0 bg-emerald-700 text-white border-t border-emerald-900 flex justify-around items-center py-2 z-50 block md:hidden shadow-xl">
        
        <!-- Menu Beranda -->
        <!-- Akan menyala hijau jika url berada di halaman utama (/) -->
        <a href="/" class="flex flex-col items-center justify-center gap-1 w-full {{ request()->is('/') ? 'text-emerald-500' : 'hover:text-white transition' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-[10px] font-medium tracking-wide">Beranda</span>
        </a>

       <!-- Menu Kamar -->
<a href="{{ route('kamar') }}" class="flex flex-col items-center justify-center gap-1 w-full {{ request()->is('kamar') ? 'text-emerald-500' : 'hover:text-white transition' }}">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
    </svg>
    <span class="text-[10px] font-medium tracking-wide">Kamar</span>
</a>

        <!-- Menu Akun -->
        <!-- Akan menampilkan info pengguna jika sudah login -->
        @guest
            <a href="{{ route('login') }}" class="flex flex-col items-center justify-center gap-1 w-full {{ request()->is('login') || request()->is('register') ? 'text-emerald-500' : 'hover:text-white transition' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="text-[10px] font-medium tracking-wide">Akun</span>
            </a>
        @endguest
        @auth
            <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center gap-1 w-full text-white">
                <span class="w-6 h-6 rounded-full bg-emerald-500 flex items-center justify-center text-xs font-semibold">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</span>
                <span class="text-[10px] font-medium tracking-wide">{{ auth()->user()->name }}</span>
            </a>
        @endauth
    </div>
    <footer class="hidden md:block bg-emerald-700 text-white py-8 border-t border-emerald-900 text-center text-sm">
        <p>&copy; 2026 Hotel Mercure Karawang. Designed by Ibay.</p>
    </footer>
</footer>

    {{-- page scripts --}}
    @stack('scripts')

</body>
</html>