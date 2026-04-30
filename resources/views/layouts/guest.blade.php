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
            * { box-sizing: border-box; margin: 0; padding: 0; }
            body {
                font-family: 'Inter', sans-serif;
                background-color: var(--bg-primary);
                color: var(--text-primary);
                transition: background-color 0.2s, color 0.2s;
            }

            /* Form elements */
            .form-label {
                display: block;
                font-size: 13px;
                font-weight: 600;
                color: var(--text-primary);
                margin-bottom: 6px;
            }
            .form-input {
                width: 100%;
                padding: 10px 14px;
                background: var(--bg-card);
                border: 1.5px solid var(--border);
                border-radius: 8px;
                font-size: 14px;
                color: var(--text-primary);
                font-family: 'Inter', sans-serif;
                transition: border-color 0.15s, box-shadow 0.15s;
                outline: none;
            }
            .form-input::placeholder { color: var(--text-muted); }
            .form-input:focus {
                border-color: var(--accent);
                box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
            }
            html.dark .form-input {
                background: #1e2533;
                border-color: #374151;
                color: #f1f5f9;
            }
            html.dark .form-input::placeholder { color: #64748b; }
            html.dark .form-input:focus {
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59,130,246,0.18);
            }

            /* Buttons */
            .btn-primary {
                display: inline-flex; align-items: center;
                padding: 10px 20px;
                background: var(--accent);
                color: #ffffff;
                border: none; border-radius: 8px;
                font-size: 14px; font-weight: 600;
                cursor: pointer; font-family: 'Inter', sans-serif;
                transition: background 0.15s, transform 0.1s;
                text-decoration: none;
            }
            .btn-primary:hover { background: var(--accent-hover); transform: translateY(-1px); }

            /* Theme toggle button */
            .theme-toggle {
                width: 36px; height: 36px;
                border-radius: 8px;
                border: 1.5px solid var(--border);
                background: var(--bg-card);
                display: flex; align-items: center; justify-content: center;
                cursor: pointer;
                color: var(--text-secondary);
                transition: all 0.15s;
            }
            .theme-toggle:hover { background: var(--accent-light); color: var(--accent); }
        </style>

        <script>
            // Apply saved theme before page render
            (function() {
                const theme = localStorage.getItem('theme') || 'light';
                document.documentElement.classList.remove('light', 'dark');
                document.documentElement.classList.add(theme);
            })();
        </script>
    </head>
    <body>
        <div style="font-family:'Inter',sans-serif; color:var(--text-primary);">
            {{ $slot }}
        </div>

        @livewireScripts

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
