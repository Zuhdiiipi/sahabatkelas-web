<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SahabatKelas')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <style>
        /* Smooth transition for sidebar width */
        #sidebar {
            transition: width 0.3s ease-in-out, transform 0.3s ease-in-out;
        }
        
        /* Desktop Collapsed State (Hanya di Laptop) */
        @media (min-width: 1024px) {
            html.sidebar-collapsed #sidebar {
                width: 5rem; /* w-20 */
            }
            html.sidebar-collapsed .sidebar-text,
            html.sidebar-collapsed .sidebar-group-title {
                display: none;
                opacity: 0;
            }
            html.sidebar-collapsed .sidebar-expanded-content {
                opacity: 0;
                pointer-events: none;
            }
            html.sidebar-collapsed .sidebar-collapsed-content {
                opacity: 1;
                pointer-events: auto;
            }
            html:not(.sidebar-collapsed) .sidebar-collapsed-content {
                opacity: 0;
                pointer-events: none;
            }
            html.sidebar-collapsed #sidebar-header {
                padding-left: 0;
                padding-right: 0;
            }
            html.sidebar-collapsed .sidebar-menu-item {
                justify-content: center;
                padding-left: 0;
                padding-right: 0;
            }
            html.sidebar-collapsed .sidebar-icon {
                margin-right: 0;
            }
            html.sidebar-collapsed #sidebar-footer-box {
                display: none;
            }
        }

        /* Global Dark Mode Overrides */
        html.dark body { background-color: #0f172a; color: #f8fafc; }
        html.dark main { background-color: #0f172a !important; }
        
        /* Neutral backgrounds */
        html.dark .bg-white { background-color: #1e293b !important; border-color: #334155 !important; }
        html.dark .bg-gray-50 { background-color: #0f172a !important; }
        html.dark .bg-gray-100 { background-color: #334155 !important; }
        
        /* Text Grays */
        html.dark .text-gray-800, html.dark .text-gray-900, html.dark .text-gray-700 { color: #f8fafc !important; }
        html.dark .text-gray-500, html.dark .text-gray-600, html.dark .text-gray-400 { color: #94a3b8 !important; }
        
        /* Borders Neutral */
        html.dark .border-gray-100, html.dark .border-gray-200 { border-color: #334155 !important; }
        html.dark .divide-gray-100 > :not([hidden]) ~ :not([hidden]) { border-color: #334155 !important; }
        
        html.dark nav { background-color: #1e293b !important; border-bottom-color: #334155 !important; }

        /* Color Backgrounds (Light to Dark) */
        html.dark .bg-blue-50 { background-color: rgba(30, 58, 138, 0.3) !important; } /* blue-900/30 */
        html.dark .bg-teal-50 { background-color: rgba(19, 78, 74, 0.3) !important; } /* teal-900/30 */
        html.dark .bg-amber-50 { background-color: rgba(120, 53, 15, 0.3) !important; } /* amber-900/30 */
        html.dark .bg-orange-50 { background-color: rgba(124, 45, 18, 0.3) !important; } /* orange-900/30 */
        html.dark .bg-violet-50 { background-color: rgba(76, 29, 149, 0.3) !important; } /* violet-900/30 */
        html.dark .bg-red-50 { background-color: rgba(127, 29, 29, 0.3) !important; } /* red-900/30 */
        html.dark .bg-green-50 { background-color: rgba(20, 83, 45, 0.3) !important; } /* green-900/30 */
        
        html.dark .bg-red-100 { background-color: rgba(127, 29, 29, 0.5) !important; } /* red-900/50 */
        
        /* Color Text (Dark to Light) */
        html.dark .text-blue-600, html.dark .text-blue-700 { color: #60a5fa !important; } /* blue-400 */
        html.dark .text-teal-600, html.dark .text-teal-700 { color: #2dd4bf !important; } /* teal-400 */
        html.dark .text-amber-500, html.dark .text-amber-600, html.dark .text-amber-700 { color: #fbbf24 !important; } /* amber-400 */
        html.dark .text-orange-400, html.dark .text-orange-500, html.dark .text-orange-600, html.dark .text-orange-700 { color: #fb923c !important; } /* orange-400 */
        html.dark .text-violet-600, html.dark .text-violet-700 { color: #a78bfa !important; } /* violet-400 */
        html.dark .text-red-500, html.dark .text-red-600, html.dark .text-red-700 { color: #f87171 !important; } /* red-400 */
        html.dark .text-green-600, html.dark .text-green-700 { color: #4ade80 !important; } /* green-400 */

        /* Color Borders */
        html.dark .border-blue-100, html.dark .border-blue-200 { border-color: rgba(30, 58, 138, 0.5) !important; }
        html.dark .border-teal-100, html.dark .border-teal-200 { border-color: rgba(19, 78, 74, 0.5) !important; }
        html.dark .border-amber-100, html.dark .border-amber-200 { border-color: rgba(120, 53, 15, 0.5) !important; }
        html.dark .border-orange-100, html.dark .border-orange-200 { border-color: rgba(124, 45, 18, 0.5) !important; }
        html.dark .border-violet-100, html.dark .border-violet-200 { border-color: rgba(76, 29, 149, 0.5) !important; }
        html.dark .border-red-100, html.dark .border-red-200 { border-color: rgba(127, 29, 29, 0.5) !important; }

        /* Exceptions where background is used on hover for buttons */
        html.dark .group:hover .group-hover\:bg-blue-600 { background-color: #2563eb !important; color: #ffffff !important; }
        html.dark .group:hover .group-hover\:bg-amber-500 { background-color: #f59e0b !important; color: #ffffff !important; }
        html.dark .group:hover .group-hover\:bg-teal-600 { background-color: #0d9488 !important; color: #ffffff !important; }
        html.dark .group:hover .group-hover\:bg-violet-600 { background-color: #7c3aed !important; color: #ffffff !important; }
    </style>
</head>
<body class="bg-gray-50 font-sans flex h-screen overflow-hidden">
    
    <!-- Script untuk inisialisasi state agar tidak berkedip -->
    <script>
        const storedState = localStorage.getItem('sidebarExpanded');
        if (storedState === 'false') {
            document.documentElement.classList.add('sidebar-collapsed');
        }
    </script>

    <!-- Memanggil potongan sidebar -->
    @auth
        @include('layouts.partials.sidebar')
    @endauth

    <div class="flex-1 flex flex-col h-screen overflow-hidden w-full relative">
        <!-- Memanggil potongan navbar -->
        @include('layouts.partials.navbar')

        <!-- Area utama untuk injeksi konten halaman -->
        <main class="flex-1 overflow-y-auto bg-gray-50/50 p-4 md:p-6 lg:p-8">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const isDesktop = window.innerWidth >= 1024;
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (isDesktop) {
                // Desktop: Toggle collapsed class (mini sidebar)
                const html = document.documentElement;
                html.classList.toggle('sidebar-collapsed');
                
                // Simpan state di localStorage
                const isExpanded = !html.classList.contains('sidebar-collapsed');
                localStorage.setItem('sidebarExpanded', isExpanded);
            } else {
                // Mobile: Toggle off-canvas (muncul dari kiri)
                if (sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                    setTimeout(() => overlay.classList.remove('opacity-0'), 10);
                } else {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('opacity-0');
                    setTimeout(() => overlay.classList.add('hidden'), 300);
                }
            }
        }
    </script>
</body>
</html>