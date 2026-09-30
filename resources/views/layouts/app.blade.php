<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIM-BK')</title>

    <!-- PWA & Mobile Web App Meta -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#1E1B4B">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="SIM-BK">
    <link rel="apple-touch-icon" href="/icon-192.png">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#9FA1FF',
                        'primary-hover': '#8E90FF',
                        'primary-dark': '#7D80F5',
                        'primary-text': '#1E1B4B',
                        secondary: '#B5BAFF',
                        'secondary-hover': '#A4AAFF',
                        'secondary-text': '#1E1B4B',
                        accent: '#AEE2FF',
                        'accent-text': '#0369A1',
                        mint: '#D9F9DF',
                        'mint-text': '#14532D',
                        'app-bg': '#FFFFFF',
                        surface: '#F8FAFF',
                        'surface-hover': '#F1F5F9',
                        'surface-border': '#E2E8F0',
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        function simbkApp() {
            return {
                sidebarOpen: false,
                notifOpen: false,
                unreadCount: 0,
                notifications: [],
                fetchNotifications() {
                    fetch('/api/notifications')
                        .then(res => res.json())
                        .then(data => {
                            this.unreadCount = data.unread_count || 0;
                            this.notifications = data.notifications || [];
                        })
                        .catch(() => {});
                },
                init() {
                    this.fetchNotifications();
                    setInterval(() => this.fetchNotifications(), 8000);
                }
            };
        }
    </script>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; background-color: #FFFFFF; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94A3B8; }
    </style>
</head>
<body class="bg-white text-[#1E293B] h-screen flex overflow-hidden w-full relative" x-data="simbkApp()">

    <!-- OVERLAY GELAP (Mobile Sidebar) -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-[#1E1B4B]/40 z-40 md:hidden backdrop-blur-sm" style="display: none;"></div>

    <!-- SIDEBAR -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 z-50 w-64 bg-[#F8FAFF] border-r border-[#E2E8F0] flex flex-col justify-between h-full transform transition-transform duration-300 ease-in-out md:relative md:translate-x-0 shrink-0 shadow-xl md:shadow-none">
        
        <button @click="sidebarOpen = false" class="md:hidden absolute top-6 right-4 text-[#64748B] hover:text-[#1E1B4B] bg-white p-1.5 rounded-lg border border-[#E2E8F0] active:scale-95 transition-all cursor-pointer">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <div class="overflow-y-auto">
            <!-- Logo & Brand Header -->
            <div class="h-20 flex items-center px-6 gap-3 border-b border-[#E2E8F0] bg-white">
                <div class="w-10 h-10 bg-[#9FA1FF] rounded-xl flex items-center justify-center text-[#1E1B4B] font-bold text-base shadow-xs border border-[#8E90FF]">
                    <svg class="w-6 h-6 text-[#1E1B4B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <div>
                    <h1 class="font-bold text-lg text-[#1E1B4B] leading-tight">SIM-BK</h1>
                    <p class="text-[11px] text-[#64748B] font-medium">Bimbingan Konseling</p>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="px-3 space-y-1.5 py-5 pb-6">
                <!-- Dashboard -->
                <a href="/guru/dashboard" class="flex items-center gap-3 px-4 py-3 {{ request()->is('guru/dashboard') ? 'bg-[#B5BAFF]/35 text-[#1E1B4B] font-bold shadow-xs' : 'text-[#64748B] hover:text-[#1E1B4B] hover:bg-white font-medium' }} rounded-xl text-sm transition-all active:scale-95 relative">
                    <svg class="w-5 h-5 {{ request()->is('guru/dashboard') ? 'text-[#1E1B4B]' : 'text-[#64748B]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                    @if(request()->is('guru/dashboard'))
                        <div class="absolute right-0 top-1/2 -translate-y-1/2 w-1.5 h-6 bg-[#9FA1FF] rounded-l-full"></div>
                    @endif
                </a>
                
                <!-- Data Siswa -->
                <a href="/guru/students" class="flex items-center gap-3 px-4 py-3 {{ request()->is('guru/students*') ? 'bg-[#B5BAFF]/35 text-[#1E1B4B] font-bold shadow-xs' : 'text-[#64748B] hover:text-[#1E1B4B] hover:bg-white font-medium' }} rounded-xl text-sm transition-all active:scale-95 relative">
                    <svg class="w-5 h-5 {{ request()->is('guru/students*') ? 'text-[#1E1B4B]' : 'text-[#64748B]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Data Siswa
                    @if(request()->is('guru/students*'))
                        <div class="absolute right-0 top-1/2 -translate-y-1/2 w-1.5 h-6 bg-[#9FA1FF] rounded-l-full"></div>
                    @endif
                </a>
                
                <!-- Kuisioner -->
                <a href="/guru/questionnaires" class="flex items-center gap-3 px-4 py-3 {{ request()->is('guru/questionnaires*') ? 'bg-[#B5BAFF]/35 text-[#1E1B4B] font-bold shadow-xs' : 'text-[#64748B] hover:text-[#1E1B4B] hover:bg-white font-medium' }} rounded-xl text-sm transition-all active:scale-95 relative">
                    <svg class="w-5 h-5 {{ request()->is('guru/questionnaires*') ? 'text-[#1E1B4B]' : 'text-[#64748B]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Kuisioner & Angket
                    @if(request()->is('guru/questionnaires*'))
                        <div class="absolute right-0 top-1/2 -translate-y-1/2 w-1.5 h-6 bg-[#9FA1FF] rounded-l-full"></div>
                    @endif
                </a>

                <!-- Konseling -->
                <a href="/guru/counseling" class="flex items-center gap-3 px-4 py-3 {{ request()->is('guru/counseling*') ? 'bg-[#B5BAFF]/35 text-[#1E1B4B] font-bold shadow-xs' : 'text-[#64748B] hover:text-[#1E1B4B] hover:bg-white font-medium' }} rounded-xl text-sm transition-all active:scale-95 relative">
                    <svg class="w-5 h-5 {{ request()->is('guru/counseling*') ? 'text-[#1E1B4B]' : 'text-[#64748B]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    Konseling Siswa
                    @if(request()->is('guru/counseling*'))
                        <div class="absolute right-0 top-1/2 -translate-y-1/2 w-1.5 h-6 bg-[#9FA1FF] rounded-l-full"></div>
                    @endif
                </a>


                <!-- Kalender -->
                <a href="/guru/calendar" class="flex items-center gap-3 px-4 py-3 {{ request()->is('guru/calendar*') ? 'bg-[#B5BAFF]/35 text-[#1E1B4B] font-bold shadow-xs' : 'text-[#64748B] hover:text-[#1E1B4B] hover:bg-white font-medium' }} rounded-xl text-sm transition-all active:scale-95 relative">
                    <svg class="w-5 h-5 {{ request()->is('guru/calendar*') ? 'text-[#1E1B4B]' : 'text-[#64748B]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Kalender Kegiatan
                    @if(request()->is('guru/calendar*'))
                        <div class="absolute right-0 top-1/2 -translate-y-1/2 w-1.5 h-6 bg-[#9FA1FF] rounded-l-full"></div>
                    @endif
                </a>
            </nav>
        </div>

        <!-- Footer Sidebar -->
        <div class="p-5 border-t border-[#E2E8F0] bg-white shrink-0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-rose-600 hover:bg-rose-50 rounded-xl font-bold text-sm transition-all active:scale-95 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col h-full overflow-hidden relative bg-white">
        
<header class="h-16 md:h-20 flex items-center justify-between px-4 sm:px-6 md:px-10 shrink-0 border-b border-[#E2E8F0] bg-white/95 backdrop-blur-md relative z-50">
            <button @click="sidebarOpen = true" class="md:hidden p-2 text-[#1E1B4B] hover:bg-[#F8FAFF] active:scale-95 rounded-xl transition-all cursor-pointer">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <div class="flex items-center gap-3 sm:gap-4 ml-auto">

                <!-- Notification Bell -->
                <div class="relative">
                    <button @click="notifOpen = !notifOpen" class="p-2.5 bg-white border border-[#E2E8F0] hover:bg-[#F8FAFF] active:scale-95 rounded-2xl text-[#1E1B4B] transition-all shadow-2xs relative cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <template x-if="unreadCount > 0">
                            <span class="absolute -top-1 -right-1 bg-rose-500 text-white text-[10px] font-extrabold w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow-sm animate-pulse" x-text="unreadCount"></span>
                        </template>
                    </button>

                    <!-- Dropdown (Responsive: fixed left-3 right-3 on mobile, absolute right-0 on desktop) -->
                    <div x-show="notifOpen" @click.away="notifOpen = false" x-cloak
                         class="fixed left-3 right-3 top-16 sm:top-auto sm:left-auto sm:right-0 sm:absolute sm:mt-3 w-auto sm:w-80 md:w-96 max-w-[calc(100vw-1.5rem)] bg-white border border-[#E2E8F0] rounded-3xl shadow-2xl z-[100] overflow-hidden space-y-2 py-3">
                        
                        <div class="px-5 py-2 border-b border-[#E2E8F0] flex items-center justify-between">
                            <h4 class="font-bold text-sm text-[#1E1B4B]">Notifikasi Sistem</h4>
                            <form action="/notifications/read-all" method="POST">
                                @csrf
                                <button type="submit" class="text-[11px] text-[#9FA1FF] hover:underline active:scale-95 font-bold cursor-pointer transition-all">Tandai semua dibaca</button>
                            </form>
                        </div>


                        <div class="max-h-80 overflow-y-auto divide-y divide-[#E2E8F0]/60 px-2">
                            <template x-for="item in notifications" :key="item.id">
                                <form :action="'/notifications/' + item.id + '/read'" method="POST" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left p-3 rounded-2xl hover:bg-[#F8FAFF] active:scale-[0.98] transition-all flex items-start gap-3 cursor-pointer"
                                            :class="!item.is_read ? 'bg-[#9FA1FF]/10 font-bold' : 'opacity-80'">
                                        <div class="w-2 h-2 rounded-full mt-1.5 shrink-0" :class="!item.is_read ? 'bg-[#9FA1FF]' : 'bg-transparent'"></div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs text-[#1E1B4B] truncate" x-text="item.title"></p>
                                            <p class="text-[11px] text-[#64748B] line-clamp-2 mt-0.5 font-normal" x-text="item.message"></p>
                                            <span class="text-[9px] text-[#94A3B8] block mt-1" x-text="item.time_ago"></span>
                                        </div>
                                    </button>
                                </form>
                            </template>
                            <template x-if="notifications.length === 0">
                                <div class="py-8 text-center text-xs text-[#64748B] font-semibold">
                                    Tidak ada notifikasi baru.
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="relative" x-data="{ userMenuOpen: false }">
                    <button @click="userMenuOpen = !userMenuOpen" class="flex items-center gap-3 pl-2 cursor-pointer focus:outline-none active:scale-95 transition-all">
                        <div class="text-right hidden sm:block">
                            <span class="text-sm font-bold text-[#1E1B4B] block leading-tight">{{ Auth::user()->username ?? 'Tim Guru BK' }}</span>
                            <span class="text-[11px] text-[#64748B] font-semibold">Guru Bimbingan Konseling</span>
                        </div>
                        <div class="w-10 h-10 bg-[#9FA1FF] border border-[#8E90FF] rounded-full flex items-center justify-center text-[#1E1B4B] font-bold shadow-xs hover:bg-[#8E90FF] transition-all">
                            <svg class="w-5 h-5 text-[#1E1B4B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                    </button>

                    <!-- User Dropdown Menu -->
                    <div x-show="userMenuOpen" @click.away="userMenuOpen = false" x-cloak class="absolute right-0 mt-3 w-56 max-w-[calc(100vw-1.5rem)] bg-white border border-[#E2E8F0] rounded-2xl shadow-xl py-2 z-50">
                        <div class="px-4 py-2 border-b border-[#E2E8F0]">
                            <span class="text-xs font-bold text-[#1E1B4B] block">{{ Auth::user()->username ?? 'Guru BK' }}</span>
                            <span class="text-[10px] text-[#64748B] block truncate">{{ Auth::user()->email ?? '-' }}</span>
                        </div>
                        <button type="button" @click="userMenuOpen = false; $dispatch('open-password-modal')" class="w-full text-left px-4 py-2.5 text-xs font-bold text-[#1E1B4B] hover:bg-[#F8FAFF] active:scale-95 flex items-center gap-2.5 transition-all cursor-pointer">
                            <svg class="w-4 h-4 text-[#9FA1FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                            <span>Ubah Kata Sandi</span>
                        </button>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2.5 text-xs font-bold text-rose-600 hover:bg-rose-50 active:scale-95 flex items-center gap-2.5 transition-all cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dynamic Content Area -->
        <div class="flex-1 overflow-y-auto bg-white">
            @if(session('password_success'))
                <div class="mx-6 md:mx-10 mt-4 p-4 bg-[#D9F9DF]/80 border border-[#BBF7D0] text-[#14532D] text-xs rounded-2xl flex items-center justify-between font-bold">
                    <span>{{ session('password_success') }}</span>
                    <button type="button" onclick="this.parentElement.remove()" class="text-[#14532D] font-bold">&times;</button>
                </div>
            @endif
            @if(isset($errors) && ($errors->has('current_password') || $errors->has('password')))
                <div class="mx-6 md:mx-10 mt-4 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-2xl flex items-center justify-between font-bold">
                    <div>
                        @error('current_password') <p>{{ $message }}</p> @enderror
                        @error('password') <p>{{ $message }}</p> @enderror
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-rose-600 font-bold">&times;</button>
                </div>
            @endif

            @yield('content')
        </div>

    </main>

    <!-- MODAL UBAH KATA SANDI GURU -->
    <div x-data="{ openModal: false }" @open-password-modal.window="openModal = true" x-show="openModal" x-cloak class="fixed inset-0 z-[99999] overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="openModal = false" class="bg-white rounded-3xl border border-[#E2E8F0] max-w-md w-full max-h-[90vh] overflow-y-auto p-5 sm:p-8 shadow-2xl space-y-6 relative">
            <div class="flex items-center justify-between pb-3 border-b border-[#E2E8F0]">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-[#B5BAFF]/30 text-[#1E1B4B] border border-[#B5BAFF] flex items-center justify-center font-bold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-[#1E1B4B]">Ubah Kata Sandi Guru BK</h3>
                </div>
                <button type="button" @click="openModal = false" class="w-8 h-8 rounded-full bg-[#F8FAFF] hover:bg-[#B5BAFF] text-[#1E1B4B] flex items-center justify-center font-bold text-lg cursor-pointer transition-all">&times;</button>
            </div>

            <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-[#64748B] uppercase mb-1.5">Kata Sandi Saat Ini</label>
                    <input type="password" name="current_password" required placeholder="Masukkan kata sandi lama..." class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#64748B] uppercase mb-1.5">Kata Sandi Baru</label>
                    <input type="password" name="password" required minlength="6" placeholder="Minimal 6 karakter..." class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#64748B] uppercase mb-1.5">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="password_confirmation" required minlength="6" placeholder="Ulangi kata sandi baru..." class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]">
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-[#E2E8F0]">
                    <button type="button" @click="openModal = false" class="px-4 py-2 bg-[#F8FAFF] hover:bg-[#E2E8F0] text-[#1E1B4B] text-xs font-bold rounded-xl border border-[#E2E8F0] cursor-pointer">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-[#9FA1FF] hover:bg-[#8E90FF] text-[#1E1B4B] text-xs font-bold rounded-xl border border-[#8E90FF] shadow-xs cursor-pointer">Perbarui Kata Sandi</button>
                </div>
            </form>
        </div>
    </div>


    <!-- PWA Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js', { scope: '/' })
                    .then(function(reg) {
                        window.swRegistration = reg;
                        console.log('SIM-BK ServiceWorker active:', reg.scope);
                    })
                    .catch(function(err) {
                        console.warn('SIM-BK ServiceWorker error:', err);
                    });
            });
        }
    </script>
</body>
</html>