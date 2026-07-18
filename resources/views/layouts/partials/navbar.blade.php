@php
    $user = auth()->user();

    /*
     * Nama yang ditampilkan menyesuaikan role.
     * Null-safe operator mencegah error ketika
     * relasi siswa atau guru tidak tersedia.
     */
    $namaPengguna =
        $user?->siswa?->nama
        ?? $user?->guru?->nama
        ?? $user?->name
        ?? $user?->email
        ?? 'Pengguna';

    /*
     * Tautan logo menyesuaikan role pengguna.
     */
    $homeUrl = match ($user?->role) {
        'admin' => route('admin.dashboard'),
        'guru' => route('guru.dashboard'),
        'siswa' => route('siswa.beranda'),
        default => route('login'),
    };

    $kelasAktif =
        'text-teal-600 border-b-2 border-teal-600';

    $kelasTidakAktif =
        'text-gray-600 border-b-2 border-transparent hover:text-teal-600';
@endphp

<nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">

    {{-- Bagian atas --}}
    <div
        class="max-w-7xl mx-auto px-4 py-3
               flex justify-between items-center gap-4"
    >
        {{-- Logo --}}
        <a
            href="{{ $homeUrl }}"
            class="text-xl font-bold text-teal-700
                   flex items-center gap-2 shrink-0"
        >
            <img src="/img/logo.png" alt="Logo" class="w-9 h-9 object-contain">

            <span class="hidden sm:inline">
                SahabatKelas
            </span>
        </a>

        {{-- Informasi pengguna (Profil Dropdown) --}}
        @auth
            <div class="relative inline-block text-left">
                <button onclick="toggleProfileDropdown()" type="button" class="flex items-center gap-3 focus:outline-none rounded-full pr-3 pl-1 py-1 hover:bg-gray-100 transition-colors">
                    <img class="h-10 w-10 rounded-full object-cover shadow-sm border border-gray-200 bg-white" src="https://ui-avatars.com/api/?name={{ urlencode($namaPengguna) }}&background=0d9488&color=fff&bold=true" alt="Avatar">
                    
                    <div class="hidden md:block text-left">
                        <p class="text-sm font-bold text-gray-800 leading-tight">{{ $namaPengguna }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ $user->role }}</p>
                    </div>
                    
                    <svg class="w-4 h-4 text-gray-400 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-56 rounded-xl bg-white shadow-xl border border-gray-100 divide-y divide-gray-100 focus:outline-none z-50 transition-all origin-top-right transform scale-95 opacity-0 duration-150 ease-out">
                    <div class="px-4 py-3">
                        <p class="text-xs text-gray-500">Masuk sebagai</p>
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $user->email }}</p>
                    </div>
                    <div class="py-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Keluar dari Sistem
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endauth
    </div>

    {{-- Navigasi role --}}
    @auth
        <div class="border-t border-gray-100 bg-gray-50/70">
            <div
                class="max-w-7xl mx-auto px-4 py-2
                       flex items-center gap-6 overflow-x-auto
                       text-sm font-medium whitespace-nowrap
                       hide-scrollbar"
            >

                {{-- Menu Admin --}}
                @if ($user->role === 'admin')
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="py-1.5 transition-colors
                            {{ request()->routeIs('admin.dashboard')
                                ? $kelasAktif
                                : $kelasTidakAktif }}"
                    >
                        Dashboard
                    </a>

                    @if (Route::has('admin.users.index'))
                        <a
                            href="{{ route('admin.users.index') }}"
                            class="py-1.5 transition-colors
                                {{ request()->routeIs('admin.users.*')
                                    ? $kelasAktif
                                    : $kelasTidakAktif }}"
                        >
                            Kelola Akun
                        </a>
                    @endif

                    @if (Route::has('admin.kelas.index'))
                        <a
                            href="{{ route('admin.kelas.index') }}"
                            class="py-1.5 transition-colors
                                {{ request()->routeIs('admin.kelas.*')
                                    ? $kelasAktif
                                    : $kelasTidakAktif }}"
                        >
                            Data Kelas
                        </a>
                    @endif

                    @if (Route::has('admin.siswa.index'))
                        <a
                            href="{{ route('admin.siswa.index') }}"
                            class="py-1.5 transition-colors
                                {{ request()->routeIs('admin.siswa.*')
                                    ? $kelasAktif
                                    : $kelasTidakAktif }}"
                        >
                            Data Siswa
                        </a>
                    @endif

                    @if (Route::has('admin.guru.index'))
                        <a
                            href="{{ route('admin.guru.index') }}"
                            class="py-1.5 transition-colors
                                {{ request()->routeIs('admin.guru.*')
                                    ? $kelasAktif
                                    : $kelasTidakAktif }}"
                        >
                            Data Guru
                        </a>
                    @endif

                {{-- Menu Guru --}}
                @elseif ($user->role === 'guru')
                    <a
                        href="{{ route('guru.dashboard') }}"
                        class="py-1.5 transition-colors
                            {{ request()->routeIs('guru.dashboard')
                                ? $kelasAktif
                                : $kelasTidakAktif }}"
                    >
                        Dashboard
                    </a>

                    <a
                        href="{{ route('guru.heatmap') }}"
                        class="py-1.5 transition-colors
                            {{ request()->routeIs(
                                'guru.heatmap',
                                'guru.siswa.detail'
                            )
                                ? $kelasAktif
                                : $kelasTidakAktif }}"
                    >
                        Heatmap Kelas
                    </a>

                    <a
                        href="{{ route('guru.tindak-lanjut.index') }}"
                        class="py-1.5 transition-colors
                            {{ request()->routeIs(
                                'guru.tindak-lanjut.*',
                                'guru.monitoring.*'
                            )
                                ? $kelasAktif
                                : $kelasTidakAktif }}"
                    >
                        Tindak Lanjut
                    </a>

                {{-- Menu Siswa --}}
                @elseif ($user->role === 'siswa')
                    <a
                        href="{{ route('siswa.beranda') }}"
                        class="py-1.5 transition-colors
                            {{ request()->routeIs('siswa.beranda')
                                ? $kelasAktif
                                : $kelasTidakAktif }}"
                    >
                        Beranda
                    </a>

                    <a
                        href="{{ route('siswa.checkin.create') }}"
                        class="py-1.5 transition-colors
                            {{ request()->routeIs('siswa.checkin.*')
                                ? $kelasAktif
                                : $kelasTidakAktif }}"
                    >
                        Check-in
                    </a>

                    <a
                        href="{{ route('siswa.report.create') }}"
                        class="py-1.5 transition-colors
                            {{ request()->routeIs('siswa.report.*')
                                ? $kelasAktif
                                : $kelasTidakAktif }}"
                    >
                        Safe Report
                    </a>
                @endif
            </div>
        </div>
    @endauth
</nav>

<style>
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<script>
    function toggleProfileDropdown() {
        const dropdown = document.getElementById('profile-dropdown');
        if (dropdown.classList.contains('hidden')) {
            dropdown.classList.remove('hidden');
            setTimeout(() => {
                dropdown.classList.remove('scale-95', 'opacity-0');
                dropdown.classList.add('scale-100', 'opacity-100');
            }, 10);
        } else {
            dropdown.classList.remove('scale-100', 'opacity-100');
            dropdown.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                dropdown.classList.add('hidden');
            }, 150);
        }
    }

    // Menutup dropdown jika klik di luar area profile
    window.addEventListener('click', function(e) {
        const dropdown = document.getElementById('profile-dropdown');
        const profileContainer = document.querySelector('.relative.inline-block.text-left');
        
        if (profileContainer && !profileContainer.contains(e.target)) {
            if (dropdown && !dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('scale-100', 'opacity-100');
                dropdown.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    dropdown.classList.add('hidden');
                }, 150);
            }
        }
    });
</script>