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
                        purple: {
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        /* Safe area untuk device mobile (seperti iPhone berponi) */
        .pb-safe { padding-bottom: env(safe-area-inset-bottom); }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 pb-20 md:pb-0 min-h-screen flex flex-col"> 

    <nav class="bg-purple-700/95 backdrop-blur-md text-white sticky top-0 z-50 px-4 md:px-8 py-3 shadow-lg border-b border-purple-600/50 transition-all">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            
            <a href="/" class="flex items-center gap-3 transition-transform hover:scale-105">
                <img src="{{ asset('Asset/Logo/Logo%20Mercure%20Karawang%20White.png') }}" alt="Mercure Karawang" class="h-9 md:h-11 drop-shadow-md">
            </a>

            <div class="hidden md:flex space-x-2 items-center">
                <a href="/" class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request()->is('/') ? 'bg-purple-600/80 text-white' : 'text-purple-100 hover:bg-purple-600/50 hover:text-white' }}">
                    Beranda
                </a>
                <a href="{{ route('kamar') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request()->is('kamar') ? 'bg-purple-600/80 text-white' : 'text-purple-100 hover:bg-purple-600/50 hover:text-white' }}">
                    Kamar
                </a>
                <a href="#" class="px-4 py-2 rounded-lg text-sm font-medium transition-all text-purple-100 hover:bg-purple-600/50 hover:text-white">
                    Tentang Kami
                </a>

                <div class="w-px h-6 bg-purple-500/50 mx-2"></div>

                @guest
                    <a href="{{ route('login') }}" class="ml-2 bg-white text-purple-700 hover:bg-gray-100 px-5 py-2 rounded-xl text-sm font-bold shadow-md transition-all active:scale-95">
                        Login
                    </a>
                @endguest
                
                @auth
                    <div class="relative ml-2" id="accountDropdownWrapper">
                        <button id="accountToggle" class="flex items-center gap-2.5 text-white hover:bg-purple-600/50 p-1.5 pr-3 rounded-full focus:outline-none transition-colors border border-transparent hover:border-purple-500/30">
                            <span class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center text-sm font-bold shadow-inner">
                                {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                            </span>
                            <span class="text-sm font-medium max-w-[120px] truncate">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 text-purple-200 transition-transform duration-200" id="dropdownArrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <div id="accountMenu" class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-2xl border border-gray-100 py-2 z-50 opacity-0 invisible translate-y-2 transition-all duration-300 ease-in-out">
                            <div class="px-4 py-3 border-b border-gray-50 mb-1">
                                <p class="text-xs text-gray-500">Login sebagai</p>
                                <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                Edit Akun
                            </a>
                            <a href="{{ route('reservation.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                Riwayat Pemesanan
                            </a>
                            <div class="h-px bg-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors text-left">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="hidden md:block bg-purple-700 text-purple-200 py-8 border-t border-purple-900 text-center text-sm mt-auto">
        <p>&copy; 2026 Hotel Mercure Karawang. Designed by Ibay.</p>
    </footer>

    <div class="fixed bottom-0 left-0 right-0 bg-white shadow-[0_-4px_20px_-10px_rgba(0,0,0,0.1)] border-t border-gray-100 flex justify-around items-center px-2 py-2 md:hidden z-40 pb-safe transition-all rounded-t-2xl">
        
        <a href="/" class="flex flex-col items-center justify-center w-full py-1 group">
            <div class="flex flex-col items-center justify-center p-1 rounded-xl transition-all duration-300 {{ request()->is('/') ? 'text-purple-600 scale-110' : 'text-gray-400 group-hover:text-purple-500' }}">
                <svg class="h-6 w-6 mb-1" fill="{{ request()->is('/') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="text-[10px] font-semibold tracking-wide">Beranda</span>
            </div>
        </a>

        <a href="{{ route('kamar') }}" class="flex flex-col items-center justify-center w-full py-1 group">
            <div class="flex flex-col items-center justify-center p-1 rounded-xl transition-all duration-300 {{ request()->is('kamar') ? 'text-purple-600 scale-110' : 'text-gray-400 group-hover:text-purple-500' }}">
                <svg class="h-6 w-6 mb-1" fill="{{ request()->is('kamar') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <span class="text-[10px] font-semibold tracking-wide">Kamar</span>
            </div>
        </a>

        @guest
            <a href="{{ route('login') }}" class="flex flex-col items-center justify-center w-full py-1 group">
                <div class="flex flex-col items-center justify-center p-1 rounded-xl transition-all duration-300 {{ request()->is('login') || request()->is('register') ? 'text-purple-600 scale-110' : 'text-gray-400 group-hover:text-purple-500' }}">
                    <svg class="h-6 w-6 mb-1" fill="{{ request()->is('login') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="text-[10px] font-semibold tracking-wide">Akun</span>
                </div>
            </a>
        @endguest
        @auth
            <button id="mobileAccountToggle" class="flex flex-col items-center justify-center w-full py-1 focus:outline-none group">
                <div class="flex flex-col items-center justify-center p-1 rounded-xl transition-all duration-300 text-gray-400 group-hover:text-purple-500">
                    <div class="w-6 h-6 rounded-full bg-purple-100 text-purple-700 flex items-center justify-center text-xs font-bold mb-1 border border-purple-200 shadow-sm">
                        {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                    </div>
                    <span class="text-[10px] font-semibold tracking-wide">Menu</span>
                </div>
            </button>
        @endauth
    </div>

    @auth
        <div id="mobileMenuOverlay" class="fixed inset-0 bg-black/40 z-[45] hidden opacity-0 transition-opacity duration-300 backdrop-blur-sm md:hidden"></div>
        <div id="mobileAccountMenu" class="fixed bottom-24 left-4 right-4 bg-white rounded-2xl shadow-2xl z-[50] transform translate-y-[150%] opacity-0 transition-all duration-300 flex flex-col overflow-hidden md:hidden border border-gray-100">
            <div class="p-4 bg-gray-50 flex items-center gap-3 border-b border-gray-100">
                <div class="w-10 h-10 rounded-full bg-purple-600 text-white flex items-center justify-center text-lg font-bold shadow-md">
                    {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 text-sm">{{ auth()->user()->name }}</h4>
                    <p class="text-xs text-gray-500">Menu Pengguna</p>
                </div>
            </div>
            <div class="p-2 space-y-1">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:bg-purple-50 hover:text-purple-700 rounded-xl transition-colors">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    Edit Profil
                </a>
                <a href="{{ route('reservation.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:bg-purple-50 hover:text-purple-700 rounded-xl transition-colors">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Riwayat Pemesanan
                </a>
                <div class="h-px bg-gray-100 my-2"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm font-bold text-red-600 hover:bg-red-50 rounded-xl transition-colors text-left">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        Keluar
                    </button>
                </form>
            </div>
            <button id="closeMobileMenu" class="py-3 text-sm font-bold text-gray-400 bg-white border-t border-gray-50 active:bg-gray-50">Tutup</button>
        </div>
    @endauth

    {{-- page scripts --}}
    @stack('scripts')
    
    <script>
        // Desktop Dropdown Logic
        document.addEventListener('click', function(e){
            const wrapper = document.getElementById('accountDropdownWrapper');
            const menu = document.getElementById('accountMenu');
            const toggle = document.getElementById('accountToggle');
            const arrow = document.getElementById('dropdownArrow');
            
            if(!wrapper || !menu || !toggle) return;
            
            if(toggle.contains(e.target)){
                const isHidden = menu.classList.contains('opacity-0');
                if (isHidden) {
                    menu.classList.remove('opacity-0', 'invisible', 'translate-y-2');
                    menu.classList.add('opacity-100', 'visible', 'translate-y-0');
                    arrow.classList.add('rotate-180');
                } else {
                    menu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                    menu.classList.add('opacity-0', 'invisible', 'translate-y-2');
                    arrow.classList.remove('rotate-180');
                }
            } else if(!wrapper.contains(e.target)){
                menu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                menu.classList.add('opacity-0', 'invisible', 'translate-y-2');
                arrow.classList.remove('rotate-180');
            }
        });

        // Mobile Floating Menu Logic
        document.addEventListener('DOMContentLoaded', function(){
            const mobileToggle = document.getElementById('mobileAccountToggle');
            const overlay = document.getElementById('mobileMenuOverlay');
            const mobileMenu = document.getElementById('mobileAccountMenu');
            const closeBtn = document.getElementById('closeMobileMenu');

            if(!mobileToggle || !overlay || !mobileMenu) return;

            function openMobileMenu() {
                overlay.classList.remove('hidden');
                // Allow display block to apply before adding opacity for smooth transition
                setTimeout(() => {
                    overlay.classList.remove('opacity-0');
                    mobileMenu.classList.remove('translate-y-[150%]', 'opacity-0');
                }, 10);
            }

            function closeMobileMenuFunc() {
                overlay.classList.add('opacity-0');
                mobileMenu.classList.add('translate-y-[150%]', 'opacity-0');
                setTimeout(() => {
                    overlay.classList.add('hidden');
                }, 300); // Wait for transition to finish
            }

            mobileToggle.addEventListener('click', openMobileMenu);
            overlay.addEventListener('click', closeMobileMenuFunc);
            if(closeBtn) closeBtn.addEventListener('click', closeMobileMenuFunc);
        });
    </script>
</body>
</html>