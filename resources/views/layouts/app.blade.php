<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestion Restaurant') - Restaurant Manager</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen">
    @auth
        <div class="flex min-h-screen">
            @include('layouts.sidebar')

            <!-- Main Content -->
            <div class="ml-0 flex min-w-0 flex-1 flex-col lg:ml-64">
                <!-- Header -->
                <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/90 px-4 py-3 shadow-sm backdrop-blur-lg sm:px-6 lg:px-8 lg:py-4 lg:-ml-64 lg:pl-72 lg:pr-8">
                    <div class="flex min-w-0 items-center justify-between gap-3">
                        <div class="flex min-w-0 items-center gap-3">
                            <button id="sidebarToggle" type="button" aria-label="Ouvrir le menu" aria-expanded="false" class="inline-flex h-10 w-10 shrink-0 items-center justify-center text-slate-600 hover:bg-slate-100 lg:hidden">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                            <span class="truncate font-semibold text-slate-800">@yield('title', 'Restaurant Manager')</span>
                        </div>
                        <div class="flex shrink-0 items-center gap-2 sm:gap-4">
                            <!-- Search Bar -->
                            <div class="relative hidden w-full max-w-2xl flex-1 md:block">
                                <input type="text" placeholder="Rechercher..." class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <!-- Profile Dropdown -->
                            <div class="relative">
                                <button onclick="toggleProfileDropdown()" class="flex items-center space-x-2 text-sm text-slate-600 hover:text-slate-800 transition-colors">
                                    <div class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-full flex items-center justify-center text-white font-bold shadow">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    <span class="hidden md:block">{{ auth()->user()->name }}</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div id="profileDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-slate-200 hidden z-50">
                                    <div class="px-4 py-3 border-b border-slate-200">
                                        <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
                                    </div>
                                    <div class="py-2">
                                        <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">Mon Profil</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">Paramètres</a>
                                    </div>
                                    <div class="border-t border-slate-200">
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">Déconnexion</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="min-w-0 flex-1 p-4 sm:p-6 lg:p-8">
                    @yield('content')
                </main>
            </div>
        </div>
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const appSidebar = document.getElementById('appSidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');

        function setSidebarOpen(isOpen) {
            if (!appSidebar || !sidebarBackdrop || !sidebarToggle) return;

            appSidebar.classList.toggle('-translate-x-full', !isOpen);
            sidebarBackdrop.classList.toggle('hidden', !isOpen);
            sidebarToggle.setAttribute('aria-expanded', String(isOpen));
        }

        sidebarToggle?.addEventListener('click', () => {
            setSidebarOpen(sidebarToggle.getAttribute('aria-expanded') !== 'true');
        });
        sidebarBackdrop?.addEventListener('click', () => setSidebarOpen(false));
        appSidebar?.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => setSidebarOpen(false));
        });
        document.addEventListener('keydown', event => {
            if (event.key === 'Escape') setSidebarOpen(false);
        });

        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('profileDropdown');
            const button = e.target.closest('button');
            if (dropdown && !dropdown.contains(e.target) && (!button || !button.onclick)) {
                dropdown.classList.add('hidden');
            }
        });

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: {!! json_encode(session('success')) !!},
                confirmButtonColor: '#10b981',
                confirmButtonText: 'OK',
                position: 'top-end',
                toast: true,
                timer: 5000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: {!! json_encode(session('error')) !!},
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'OK',
                position: 'top-end',
                toast: true,
                timer: 5000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        @endif
    </script>
    @stack('scripts')
</body>
</html>
