<div style="min-height: 100vh; display: flex; background: var(--bg-primary);">
    <!-- Left decorative panel -->
    <div style="width: 400px; flex-shrink: 0; background: linear-gradient(155deg, #0f2448 0%, #1a3563 40%, #0d1c38 100%); display: flex; flex-direction: column; justify-content: space-between; padding: 40px; position: relative; overflow: hidden;">
        <!-- Grid pattern -->
        <div style="position: absolute; inset: 0; opacity: 0.06;">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <defs><pattern id="g" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/></pattern></defs>
                <rect width="100%" height="100%" fill="url(#g)"/>
            </svg>
        </div>

        <!-- Decorative circles -->
        <div style="position: absolute; top: -80px; right: -80px; width: 220px; height: 220px; border-radius: 50%; background: rgba(59,130,246,0.18);"></div>
        <div style="position: absolute; bottom: 80px; left: -60px; width: 160px; height: 160px; border-radius: 50%; background: rgba(99,102,241,0.12);"></div>
        <div style="position: absolute; bottom: -40px; right: 40px; width: 110px; height: 110px; border-radius: 50%; background: rgba(59,130,246,0.1);"></div>

        <!-- Logo -->
        <div style="position: relative;">
            <div style="width: 50px; height: 50px; background: rgba(59,130,246,0.9); border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 18px; box-shadow: 0 4px 24px rgba(59,130,246,0.4);">
                <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div style="font-family: 'Outfit', sans-serif; font-size: 24px; font-weight: 700; color: white; letter-spacing: 0.3px;">{{ config('app.name', 'Archivist') }}</div>
            <div style="font-size: 11px; color: rgba(255,255,255,0.45); letter-spacing: 2px; text-transform: uppercase; font-weight: 500; margin-top: 2px;">Central Management</div>
        </div>

        <!-- Middle content -->
        <div style="position: relative;">
            <!-- Mini book-stack illustration -->
            <div style="display: flex; gap: 7px; margin-bottom: 28px; align-items: flex-end;">
                @foreach([['#3b82f6','68px'], ['#818cf8','84px'], ['#06b6d4','60px'], ['#8b5cf6','76px'], ['#3b82f6','52px']] as $book)
                <div style="width: 18px; height: {{ $book[1] }}; background: {{ $book[0] }}; border-radius: 3px 3px 0 0; opacity: 0.85; box-shadow: 0 -2px 6px rgba(0,0,0,0.2);"></div>
                @endforeach
            </div>
            <h2 style="font-family: 'Outfit', sans-serif; font-size: 28px; font-weight: 700; color: white; line-height: 1.25; margin-bottom: 14px;">Your Library,<br>Perfectly Organized.</h2>
            <p style="font-size: 14px; color: rgba(255,255,255,0.58); line-height: 1.65;">Manage your entire collection — from catalog to circulation — with one unified platform.</p>
        </div>

        <!-- Stats strip -->
        <div style="position: relative; display: flex; border: 1px solid rgba(255,255,255,0.12); border-radius: 14px; overflow: hidden;">
            @foreach([['10K+','Books'], ['500+','Members'], ['98%','Availability']] as $s)
            <div style="flex: 1; padding: 16px 10px; text-align: center; border-right: 1px solid rgba(255,255,255,0.08);">
                <div style="font-family: 'Outfit', sans-serif; font-size: 20px; font-weight: 700; color: white;">{{ $s[0] }}</div>
                <div style="font-size: 11px; color: rgba(255,255,255,0.48); margin-top: 2px;">{{ $s[1] }}</div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Right form panel — fills remaining space -->
    <div style="flex: 1; min-width: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 48px 40px; background: var(--bg-primary); position: relative;">
        <!-- Theme toggle -->
        <button onclick="toggleTheme()" class="theme-toggle" style="position: absolute; top: 24px; right: 24px;">
            <svg class="theme-icon-sun" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <svg class="theme-icon-moon" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
            </svg>
        </button>

        <div style="width: 100%; max-width: 420px;">
            {{ $slot }}
        </div>
    </div>
</div>

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
