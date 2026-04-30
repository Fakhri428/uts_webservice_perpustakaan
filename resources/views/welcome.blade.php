<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Archivist') }} — Library Central Management</title>
        <meta name="description" content="Archivist is your all-in-one library management platform. Manage catalogs, loans, members and more.">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <script>
            (function() {
                const theme = localStorage.getItem('theme') || 'light';
                document.documentElement.classList.add(theme);
            })();
        </script>

        <style>
            :root {
                --bg: #f8f9fb;
                --bg-card: #ffffff;
                --text: #1a1d23;
                --text-sub: #6b7280;
                --text-muted: #9ca3af;
                --border: #e5e7eb;
                --accent: #2563eb;
                --accent-hover: #1d4ed8;
                --accent-light: #eff6ff;
                --nav-bg: rgba(248,249,251,0.92);
            }
            html.dark {
                --bg: #0f1117;
                --bg-card: #1a1d26;
                --text: #f1f5f9;
                --text-sub: #94a3b8;
                --text-muted: #64748b;
                --border: #2d3748;
                --accent: #3b82f6;
                --accent-hover: #60a5fa;
                --accent-light: #1e3a5f;
                --nav-bg: rgba(15,17,23,0.92);
            }
            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
            html { scroll-behavior: smooth; }
            body {
                font-family: 'Inter', sans-serif;
                background: var(--bg);
                color: var(--text);
                transition: background 0.2s, color 0.2s;
                line-height: 1.6;
                overflow-x: hidden;
            }

            /* NAV */
            .nav {
                position: fixed; top: 0; left: 0; right: 0; z-index: 100;
                backdrop-filter: blur(12px);
                background: var(--nav-bg);
                border-bottom: 1px solid var(--border);
                height: 64px;
                display: flex; align-items: center;
                transition: background 0.2s, border-color 0.2s;
            }
            .nav-inner {
                max-width: 1200px; margin: 0 auto; width: 100%;
                padding: 0 32px;
                display: flex; align-items: center; justify-content: space-between;
            }
            .nav-brand {
                display: flex; align-items: center; gap: 12px;
                text-decoration: none;
            }
            .nav-logo {
                width: 36px; height: 36px;
                background: var(--accent);
                border-radius: 9px;
                display: flex; align-items: center; justify-content: center;
            }
            .nav-brand-text { font-family: 'Outfit', sans-serif; font-size: 17px; font-weight: 700; color: var(--text); }
            .nav-brand-sub { font-size: 10px; color: var(--text-muted); letter-spacing: 1.5px; text-transform: uppercase; font-weight: 500; line-height: 1; }
            .nav-actions { display: flex; align-items: center; gap: 10px; }

            /* BUTTONS */
            .btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; border-radius: 8px; font-size: 13.5px; font-weight: 600; cursor: pointer; text-decoration: none; border: none; transition: all 0.15s; font-family: 'Inter', sans-serif; }
            .btn-outline { background: transparent; color: var(--text-sub); border: 1px solid var(--border); }
            .btn-outline:hover { border-color: var(--accent); color: var(--accent); background: var(--accent-light); }
            .btn-primary { background: var(--accent); color: white; }
            .btn-primary:hover { background: var(--accent-hover); transform: translateY(-1px); }
            .btn-large { padding: 14px 28px; font-size: 15px; border-radius: 10px; }

            .theme-btn {
                width: 36px; height: 36px;
                border-radius: 8px;
                border: 1px solid var(--border);
                background: var(--bg-card);
                display: flex; align-items: center; justify-content: center;
                cursor: pointer; color: var(--text-sub);
                transition: all 0.15s;
            }
            .theme-btn:hover { background: var(--accent-light); color: var(--accent); }

            /* HERO */
            .hero {
                min-height: 100vh;
                display: flex; align-items: center;
                padding: 100px 32px 60px;
                position: relative;
                overflow: hidden;
            }
            .hero-bg {
                position: absolute; inset: 0;
                background: radial-gradient(ellipse 70% 60% at 60% 40%, rgba(37,99,235,0.1) 0%, transparent 70%);
            }
            html.dark .hero-bg {
                background: radial-gradient(ellipse 70% 60% at 60% 40%, rgba(59,130,246,0.12) 0%, transparent 70%);
            }
            .hero-inner {
                max-width: 1200px; margin: 0 auto;
                display: flex; align-items: center; gap: 60px;
                position: relative;
            }
            .hero-content { flex: 1; }
            .hero-eyebrow {
                display: inline-flex; align-items: center; gap: 8px;
                background: var(--accent-light); color: var(--accent);
                padding: 5px 14px; border-radius: 20px;
                font-size: 12px; font-weight: 600; letter-spacing: 0.5px;
                margin-bottom: 24px;
                border: 1px solid rgba(37,99,235,0.2);
            }
            .hero-title {
                font-family: 'Outfit', sans-serif;
                font-size: clamp(36px, 5vw, 58px);
                font-weight: 800;
                line-height: 1.1;
                color: var(--text);
                margin-bottom: 20px;
            }
            .hero-title .accent-text { color: var(--accent); }
            .hero-subtitle { font-size: 17px; color: var(--text-sub); line-height: 1.7; margin-bottom: 36px; max-width: 480px; }
            .hero-cta { display: flex; gap: 14px; flex-wrap: wrap; }
            .hero-stats {
                display: flex; gap: 32px; margin-top: 48px; padding-top: 32px;
                border-top: 1px solid var(--border);
            }
            .hero-stat-value { font-family: 'Outfit', sans-serif; font-size: 26px; font-weight: 700; color: var(--text); }
            .hero-stat-label { font-size: 13px; color: var(--text-muted); }

            /* Hero visual */
            .hero-visual {
                flex: 0 0 480px;
            }
            .hero-window {
                background: var(--bg-card);
                border: 1px solid var(--border);
                border-radius: 16px;
                overflow: hidden;
                box-shadow: 0 20px 60px rgba(0,0,0,0.12), 0 4px 16px rgba(0,0,0,0.08);
            }
            .window-bar {
                background: var(--bg);
                border-bottom: 1px solid var(--border);
                padding: 12px 16px;
                display: flex; align-items: center; gap: 8px;
            }
            .window-dot { width: 10px; height: 10px; border-radius: 50%; }
            .window-title { font-size: 12px; color: var(--text-muted); margin-left: 8px; font-weight: 500; }
            .window-body { padding: 16px; }
            .book-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
            .book-card-mini {
                border-radius: 8px; overflow: hidden;
                border: 1px solid var(--border);
                background: var(--bg);
            }
            .book-cover-mini {
                height: 70px;
                display: flex; align-items: center; justify-content: center;
                font-size: 22px;
            }
            .book-info-mini { padding: 6px 8px; }
            .book-cat-mini { font-size: 9px; color: var(--accent); font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase; }
            .book-title-mini { font-size: 11px; font-weight: 600; color: var(--text); margin-top: 1px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
            .badge-mini {
                display: inline-block; padding: 2px 6px; border-radius: 10px;
                font-size: 9px; font-weight: 600; margin-top: 3px;
            }
            .avail-mini { background: #dcfce7; color: #166534; }
            .loan-mini  { background: #fee2e2; color: #991b1b; }
            html.dark .avail-mini { background: #14532d; color: #86efac; }
            html.dark .loan-mini  { background: #7f1d1d; color: #fca5a5; }

            /* FEATURES */
            .section { max-width: 1200px; margin: 0 auto; padding: 80px 32px; }
            .section-eyebrow {
                text-align: center;
                font-size: 12px; font-weight: 600; letter-spacing: 1.5px;
                text-transform: uppercase; color: var(--accent);
                margin-bottom: 12px;
            }
            .section-title {
                font-family: 'Outfit', sans-serif;
                font-size: 36px; font-weight: 700;
                text-align: center; color: var(--text);
                margin-bottom: 12px;
            }
            .section-sub { text-align: center; color: var(--text-sub); font-size: 16px; max-width: 540px; margin: 0 auto 48px; }
            .features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
            .feature-card {
                background: var(--bg-card);
                border: 1px solid var(--border);
                border-radius: 16px; padding: 28px;
                transition: all 0.2s;
            }
            .feature-card:hover { box-shadow: 0 8px 30px rgba(0,0,0,0.1); transform: translateY(-3px); border-color: var(--accent); }
            .feature-icon {
                width: 48px; height: 48px;
                border-radius: 12px; background: var(--accent-light);
                display: flex; align-items: center; justify-content: center;
                margin-bottom: 16px; color: var(--accent);
            }
            .feature-title { font-family: 'Outfit', sans-serif; font-size: 18px; font-weight: 600; color: var(--text); margin-bottom: 8px; }
            .feature-text { font-size: 14px; color: var(--text-sub); line-height: 1.6; }

            /* CTA SECTION */
            .cta-section {
                background: linear-gradient(135deg, #1e3a5f, #1a2744);
                padding: 80px 32px;
            }
            .cta-inner {
                max-width: 700px; margin: 0 auto; text-align: center;
            }
            .cta-title { font-family: 'Outfit', sans-serif; font-size: 36px; font-weight: 700; color: white; margin-bottom: 14px; }
            .cta-text { font-size: 16px; color: rgba(255,255,255,0.7); margin-bottom: 32px; }
            .cta-btn { background: white; color: #1e3a5f; padding: 14px 32px; border-radius: 10px; font-weight: 700; font-size: 15px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: transform 0.15s; }
            .cta-btn:hover { transform: translateY(-2px); }

            /* FOOTER */
            footer {
                border-top: 1px solid var(--border);
                padding: 28px 32px;
                text-align: center;
                font-size: 13px;
                color: var(--text-muted);
                background: var(--bg-card);
            }
        </style>
    </head>
    <body>
        <!-- Navigation -->
        <nav class="nav">
            <div class="nav-inner">
                <a href="/" class="nav-brand">
                    <div class="nav-logo">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div>
                        <div class="nav-brand-text">{{ config('app.name', 'Archivist') }}</div>
                        <div class="nav-brand-sub">Central Management</div>
                    </div>
                </a>

                <div class="nav-actions">
                    <button class="theme-btn" onclick="toggleTheme()">
                        <svg class="theme-icon-sun" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <svg class="theme-icon-moon" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline">Sign In</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-bg"></div>
            <div class="hero-inner">
                <div class="hero-content">
                    <div class="hero-eyebrow">
                        <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="4"/></svg>
                        Library Management System
                    </div>
                    <h1 class="hero-title">
                        Manage Every<br>
                        <span class="accent-text">Book, Member</span><br>
                        & Loan in One Place
                    </h1>
                    <p class="hero-subtitle">
                        Archivist brings your entire library into one powerful, elegant platform. From cataloging to AI-powered recommendations.
                    </p>
                    <div class="hero-cta">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-large">
                                Open Dashboard
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-primary btn-large">
                                Get Started Free
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-outline btn-large">Sign In</a>
                        @endauth
                    </div>
                    <div class="hero-stats">
                        <div>
                            <div class="hero-stat-value">10,000+</div>
                            <div class="hero-stat-label">Books Catalogued</div>
                        </div>
                        <div>
                            <div class="hero-stat-value">500+</div>
                            <div class="hero-stat-label">Active Members</div>
                        </div>
                        <div>
                            <div class="hero-stat-value">98%</div>
                            <div class="hero-stat-label">Availability Rate</div>
                        </div>
                    </div>
                </div>

                <!-- Hero Visual: mini book grid window -->
                <div class="hero-visual">
                    <div class="hero-window">
                        <div class="window-bar">
                            <div class="window-dot" style="background:#ef4444;"></div>
                            <div class="window-dot" style="background:#f59e0b;"></div>
                            <div class="window-dot" style="background:#22c55e;"></div>
                            <span class="window-title">Archivist — Science Collection</span>
                        </div>
                        <div class="window-body">
                            <div class="book-grid">
                                @foreach([
                                    ['🧬','Biology','Architecture of Life','avail','#dbeafe'],
                                    ['🌌','Astrophysics','Quantum Horizons','loan','#fef3c7'],
                                    ['⚗️','Chemistry','Organic Synthetics','avail','#dcfce7'],
                                    ['💻','Computer Sci.','Neural Networks','avail','#ede9fe'],
                                    ['🪐','Astronomy','Orbital Mechanics','loan','#fce7f3'],
                                    ['🦕','Paleontology','Chronicles of Earth','avail','#fef9c3'],
                                ] as $b)
                                <div class="book-card-mini">
                                    <div class="book-cover-mini" style="background: {{ $b[4] }};">{{ $b[0] }}</div>
                                    <div class="book-info-mini">
                                        <div class="book-cat-mini">{{ $b[1] }}</div>
                                        <div class="book-title-mini">{{ $b[2] }}</div>
                                        <span class="badge-mini {{ $b[3] === 'avail' ? 'avail-mini' : 'loan-mini' }}">
                                            {{ $b[3] === 'avail' ? 'AVAILABLE' : 'ON LOAN' }}
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <div style="background: var(--bg-card); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
            <div class="section">
                <div class="section-eyebrow">Capabilities</div>
                <h2 class="section-title">Everything Your Library Needs</h2>
                <p class="section-sub">A complete suite of tools built for modern library management.</p>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div class="feature-title">Smart Catalog</div>
                        <div class="feature-text">Browse, search and filter thousands of books by title, author, ISBN, or category. Real-time availability at a glance.</div>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                        </div>
                        <div class="feature-title">Circulation Management</div>
                        <div class="feature-text">Track every loan and return. Get notified on overdue items and manage the full circulation lifecycle effortlessly.</div>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m1.636-6.364l.707.707M12 21v-1m0-16a7 7 0 017 7 7 7 0 01-7 7 7 7 0 01-7-7 7 7 0 017-7z"/>
                            </svg>
                        </div>
                        <div class="feature-title">AI Recommendations</div>
                        <div class="feature-text">Powered by an intelligent engine that suggests books tailored to each member's reading history and interests.</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Banner -->
        <div class="cta-section">
            <div class="cta-inner">
                <h2 class="cta-title">Ready to modernize your library?</h2>
                <p class="cta-text">Join hundreds of institutions already using Archivist to manage their collections.</p>
                @auth
                    <a href="{{ url('/dashboard') }}" class="cta-btn">Open Dashboard →</a>
                @else
                    <a href="{{ route('register') }}" class="cta-btn">Create Free Account →</a>
                @endauth
            </div>
        </div>

        <!-- Footer -->
        <footer>
            <p>© {{ date('Y') }} {{ config('app.name', 'Archivist') }} · Central Management System</p>
        </footer>

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
            document.addEventListener('DOMContentLoaded', updateThemeIcon);
        </script>
    </body>
</html>
