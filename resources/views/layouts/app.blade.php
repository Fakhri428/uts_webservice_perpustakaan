<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Archivist') }} — Central Management</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles

        <style>
            :root {
                --bg-primary: #f8f9fb;
                --bg-card: #ffffff;
                --text-primary: #1a1d23;
                --text-secondary: #6b7280;
                --text-muted: #9ca3af;
                --border: #e5e7eb;
                --accent: #2563eb;
                --accent-hover: #1d4ed8;
                --accent-light: #eff6ff;
                --sidebar-bg: #ffffff;
                --sidebar-active: #eff6ff;
                --sidebar-active-text: #2563eb;
                --shadow: 0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.06);
            }
            html.dark {
                --bg-primary: #0f1117;
                --bg-card: #1a1d26;
                --text-primary: #f1f5f9;
                --text-secondary: #94a3b8;
                --text-muted: #64748b;
                --border: #2d3748;
                --accent: #3b82f6;
                --accent-hover: #60a5fa;
                --accent-light: #1e3a5f;
                --sidebar-bg: #1a1d26;
                --sidebar-active: #1e3a5f;
                --sidebar-active-text: #60a5fa;
                --shadow: 0 1px 3px rgba(0,0,0,0.3), 0 1px 2px rgba(0,0,0,0.2);
            }

            * { box-sizing: border-box; }

            body {
                font-family: 'Inter', sans-serif;
                background-color: var(--bg-primary);
                color: var(--text-primary);
                transition: background-color 0.2s, color 0.2s;
                margin: 0;
            }

            /* Sidebar */
            .sidebar {
                flex: 0 0 220px;
                width: 220px;
                background: var(--sidebar-bg);
                border-right: 1px solid var(--border);
                display: flex;
                flex-direction: column;
                z-index: 50;
                transition: background 0.2s, border-color 0.2s, transform 0.25s;
                height: 100vh;
                position: sticky;
                top: 0;
                overflow-y: auto;
            }

            .sidebar-logo {
                padding: 20px 20px 16px;
                border-bottom: 1px solid var(--border);
            }

            .sidebar-logo .logo-icon {
                width: 36px; height: 36px;
                background: var(--accent);
                border-radius: 8px;
                display: flex; align-items: center; justify-content: center;
                margin-bottom: 6px;
            }

            .sidebar-logo .app-name {
                font-family: 'Outfit', sans-serif;
                font-weight: 700;
                font-size: 14px;
                color: var(--text-primary);
                letter-spacing: 0.5px;
            }

            .sidebar-logo .app-subtitle {
                font-size: 10px;
                color: var(--text-muted);
                letter-spacing: 1px;
                text-transform: uppercase;
                font-weight: 500;
            }

            .sidebar-nav {
                flex: 1;
                padding: 16px 12px;
                overflow-y: auto;
            }

            .nav-label {
                font-size: 10px;
                font-weight: 600;
                letter-spacing: 1px;
                text-transform: uppercase;
                color: var(--text-muted);
                padding: 8px 8px 4px;
                margin-bottom: 2px;
            }

            .nav-item {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 9px 10px;
                border-radius: 8px;
                font-size: 13.5px;
                font-weight: 500;
                color: var(--text-secondary);
                text-decoration: none;
                transition: all 0.15s;
                margin-bottom: 2px;
                cursor: pointer;
            }

            .nav-item:hover {
                background: var(--accent-light);
                color: var(--accent);
            }

            .nav-item.active {
                background: var(--sidebar-active);
                color: var(--sidebar-active-text);
                border-left: 3px solid var(--accent);
                padding-left: 7px;
            }

            .nav-item svg {
                width: 16px;
                height: 16px;
                flex-shrink: 0;
                opacity: 0.7;
            }

            .nav-item.active svg, .nav-item:hover svg { opacity: 1; }

            .sidebar-footer {
                padding: 16px 12px;
                border-top: 1px solid var(--border);
            }

            .quick-stats {
                background: var(--bg-primary);
                border-radius: 10px;
                padding: 12px;
                margin-bottom: 12px;
            }

            .quick-stats-label {
                font-size: 10px;
                font-weight: 600;
                letter-spacing: 1px;
                text-transform: uppercase;
                color: var(--text-muted);
                margin-bottom: 4px;
            }

            .quick-stats-value {
                font-family: 'Outfit', sans-serif;
                font-size: 20px;
                font-weight: 700;
                color: var(--text-primary);
            }

            .quick-stats-sub {
                font-size: 11px;
                color: var(--text-muted);
            }

            /* Main content */
            .main-wrapper {
                flex: 1;
                width: 0; /* prevents flex overflow */
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            .topbar {
                position: sticky;
                top: 0;
                background: var(--bg-card);
                border-bottom: 1px solid var(--border);
                padding: 0 28px;
                height: 60px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                z-index: 40;
                transition: background 0.2s, border-color 0.2s;
                box-shadow: var(--shadow);
            }

            .topbar-title {
                font-family: 'Outfit', sans-serif;
                font-size: 18px;
                font-weight: 600;
                color: var(--text-primary);
            }

            .topbar-actions {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .theme-toggle {
                width: 36px; height: 36px;
                border-radius: 8px;
                border: 1px solid var(--border);
                background: var(--bg-primary);
                display: flex; align-items: center; justify-content: center;
                cursor: pointer;
                color: var(--text-secondary);
                transition: all 0.15s;
            }

            .theme-toggle:hover {
                background: var(--accent-light);
                color: var(--accent);
                border-color: var(--accent);
            }

            .user-menu {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 6px 12px;
                border-radius: 10px;
                cursor: pointer;
                transition: background 0.15s;
            }

            .user-menu:hover { background: var(--bg-primary); }

            .user-avatar {
                width: 32px; height: 32px;
                border-radius: 50%;
                background: var(--accent);
                display: flex; align-items: center; justify-content: center;
                color: white;
                font-weight: 600;
                font-size: 13px;
            }

            .user-info .user-name {
                font-size: 13px;
                font-weight: 600;
                color: var(--text-primary);
                line-height: 1.2;
            }

            .user-info .user-role {
                font-size: 11px;
                color: var(--text-muted);
            }

            .content-area {
                flex: 1;
                padding: 28px;
            }

            /* Hamburger toggle (mobile) */
            .hamburger {
                display: none;
                background: none;
                border: none;
                cursor: pointer;
                color: var(--text-secondary);
                padding: 4px;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .sidebar {
                    position: fixed;
                    top: 0; left: 0; bottom: 0;
                    transform: translateX(-100%);
                    z-index: 200;
                    height: 100vh;
                    box-shadow: 4px 0 20px rgba(0,0,0,0.15);
                }
                .sidebar.open { transform: translateX(0); }
                .main-wrapper { flex: 1; width: 100%; }
                .hamburger { display: flex; }
                .content-area { padding: 16px; }
                .topbar { padding: 0 16px; }
                .sidebar-overlay {
                    display: none;
                    position: fixed; inset: 0;
                    background: rgba(0,0,0,0.4);
                    z-index: 190;
                    backdrop-filter: blur(2px);
                }
                .sidebar-overlay.open { display: block; }
            }
            @media (max-width: 1024px) and (min-width: 769px) {
                .sidebar { flex: 0 0 180px; width: 180px; }
                .content-area { padding: 20px; }
            }

            /* Cards */
            .card {
                background: var(--bg-card);
                border: 1px solid var(--border);
                border-radius: 12px;
                padding: 20px;
                box-shadow: var(--shadow);
                transition: background 0.2s, border-color 0.2s;
            }

            /* Badges */
            .badge {
                display: inline-flex;
                align-items: center;
                padding: 3px 8px;
                border-radius: 20px;
                font-size: 11px;
                font-weight: 600;
                letter-spacing: 0.3px;
            }

            .badge-available { background: #dcfce7; color: #166534; }
            .badge-loan { background: #fee2e2; color: #991b1b; }
            .badge-reserved { background: #dbeafe; color: #1e40af; }

            html.dark .badge-available { background: #14532d; color: #86efac; }
            html.dark .badge-loan { background: #7f1d1d; color: #fca5a5; }
            html.dark .badge-reserved { background: #1e3a5f; color: #93c5fd; }

            /* Buttons */
            .btn-primary {
                background: var(--accent);
                color: white;
                border: none;
                border-radius: 8px;
                padding: 9px 18px;
                font-size: 13.5px;
                font-weight: 600;
                cursor: pointer;
                transition: background 0.15s, transform 0.1s;
                font-family: 'Inter', sans-serif;
                display: inline-flex;
                align-items: center;
                gap: 6px;
                text-decoration: none;
            }

            .btn-primary:hover { background: var(--accent-hover); }
            .btn-primary:active { transform: scale(0.98); }

            .btn-secondary {
                background: transparent;
                color: var(--text-secondary);
                border: 1px solid var(--border);
                border-radius: 8px;
                padding: 8px 16px;
                font-size: 13.5px;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.15s;
                font-family: 'Inter', sans-serif;
                display: inline-flex;
                align-items: center;
                gap: 6px;
                text-decoration: none;
            }

            .btn-secondary:hover {
                border-color: var(--accent);
                color: var(--accent);
                background: var(--accent-light);
            }

            /* Form inputs */
            .form-input {
                width: 100%;
                padding: 10px 14px;
                border: 1px solid var(--border);
                border-radius: 8px;
                background: var(--bg-primary);
                color: var(--text-primary);
                font-size: 14px;
                font-family: 'Inter', sans-serif;
                transition: border-color 0.15s, box-shadow 0.15s;
                outline: none;
            }

            .form-input:focus {
                border-color: var(--accent);
                box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
            }

            .form-label {
                display: block;
                font-size: 13px;
                font-weight: 500;
                color: var(--text-secondary);
                margin-bottom: 5px;
            }

            /* Scrollbar */
            ::-webkit-scrollbar { width: 6px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }
        </style>

        <script>
            (function() {
                const theme = localStorage.getItem('theme') || 'light';
                document.documentElement.classList.remove('light', 'dark');
                document.documentElement.classList.add(theme);
            })();
        </script>
    </head>
    <body>
        <x-banner />
        <!-- Mobile sidebar overlay -->
        <div class="sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>

        <div style="display: flex; min-height: 100vh; align-items: stretch;">
            <!-- Sidebar -->
            <aside class="sidebar">
                <div class="sidebar-logo">
                    <div class="logo-icon">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div class="app-name">{{ config('app.name', 'HELIXS') }}</div>
                    <div class="app-subtitle">Central Management</div>
                </div>

                <nav class="sidebar-nav">
                    <div class="nav-label">Navigation</div>

                    <a href="{{ url('/dashboard') }}" class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ url('/app/books') }}" class="nav-item {{ request()->is('app/books') ? 'active' : '' }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Catalog
                    </a>

                    <a href="{{ url('/app/loans') }}" class="nav-item {{ request()->is('app/loans') ? 'active' : '' }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                        Circulation
                    </a>

                    <a href="{{ url('/app/ai') }}" class="nav-item {{ request()->is('app/ai') ? 'active' : '' }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m1.636-6.364l.707.707M12 21v-1m0-16a7 7 0 017 7 7 7 0 01-7 7 7 7 0 01-7-7 7 7 0 017-7z"/>
                        </svg>
                        AI Assist
                    </a>

                    @if(auth()->check() && auth()->user()->role === 'admin')
                    <div class="nav-label" style="margin-top: 12px;">Administration</div>
                    <a href="{{ url('/admin') }}" class="nav-item {{ request()->is('admin*') ? 'active' : '' }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Settings
                    </a>
                    @endif
                </nav>

                <div class="sidebar-footer">
                    <div class="quick-stats">
                        <div class="quick-stats-label">Quick Stats</div>
                        <div class="quick-stats-value" id="sidebar-book-count">—</div>
                        <div class="quick-stats-sub">Books Catalogued</div>
                    </div>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-item" style="width: 100%; border: none; background: none; text-align: left; color: var(--text-secondary); cursor: pointer;">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="16" height="16">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Sign Out
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Main -->
            <div class="main-wrapper">
                <!-- Topbar -->
                <header class="topbar">
                    <div style="display:flex;align-items:center;gap:12px;">
                        <button class="hamburger" onclick="toggleSidebar()" aria-label="Menu">
                            <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <div class="topbar-title">
                            @if (isset($header))
                                {{ $header }}
                            @else
                                Dashboard
                            @endif
                        </div>
                    </div>

                    <div class="topbar-actions">
                        <!-- Theme Toggle -->
                        <button class="theme-toggle" onclick="toggleTheme()" title="Toggle theme">
                            <!-- Sun icon (shown in light mode) -->
                            <svg class="theme-icon-sun" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <!-- Moon icon (shown in dark mode) -->
                            <svg class="theme-icon-moon" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                        </button>

                        <!-- User info -->
                        @auth
                        <div class="user-menu">
                            <div class="user-avatar">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="user-info">
                                <div class="user-name">{{ auth()->user()->name }}</div>
                                <div class="user-role">{{ ucfirst(auth()->user()->role ?? 'Member') }}</div>
                            </div>
                        </div>
                        @endauth
                    </div>
                </header>

                <!-- Page Content -->
                <main class="content-area">
                    {{ $slot }}
                </main>
            </div>
        </div>

        @stack('modals')
        @livewireScripts
        @stack('scripts')

        <script>
            function toggleTheme() {
                const html = document.documentElement;
                const isDark = html.classList.contains('dark');
                html.classList.remove('light', 'dark');
                html.classList.add(isDark ? 'light' : 'dark');
                localStorage.setItem('theme', isDark ? 'light' : 'dark');
                updateThemeIcon();
            }

            function updateThemeIcon() {
                const isDark = document.documentElement.classList.contains('dark');
                document.querySelectorAll('.theme-icon-sun').forEach(el => el.style.display = isDark ? 'none' : 'block');
                document.querySelectorAll('.theme-icon-moon').forEach(el => el.style.display = isDark ? 'block' : 'none');
            }

            function toggleSidebar() {
                const sb = document.querySelector('.sidebar');
                const ov = document.getElementById('sidebar-overlay');
                sb.classList.toggle('open');
                ov.classList.toggle('open');
            }
            function closeSidebar() {
                document.querySelector('.sidebar')?.classList.remove('open');
                document.getElementById('sidebar-overlay')?.classList.remove('open');
            }

            document.addEventListener('DOMContentLoaded', function() {
                updateThemeIcon();
                fetch('/api/books').then(r => r.json()).then(data => {
                    const count = (data.data || data).length;
                    const el = document.getElementById('sidebar-book-count');
                    if (el) el.textContent = count.toLocaleString();
                }).catch(() => {});
            });
        </script>
    </body>
</html>
