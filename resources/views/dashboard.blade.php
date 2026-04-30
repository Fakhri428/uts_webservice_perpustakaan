<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    <!-- Stats Cards -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 28px;">
        @php
            $stats = [
                ['label'=>'Total Books', 'id'=>'stat-books', 'value'=>'—', 'icon'=>'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'color'=>'#2563eb', 'bg'=>'#eff6ff'],
                ['label'=>'Active Loans', 'id'=>'stat-loans', 'value'=>'—', 'icon'=>'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4', 'color'=>'#f59e0b', 'bg'=>'#fef3c7'],
                ['label'=>'Members', 'id'=>'stat-members', 'value'=>'—', 'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'color'=>'#10b981', 'bg'=>'#d1fae5'],
                ['label'=>'Overdue', 'id'=>'stat-overdue', 'value'=>'0', 'icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'color'=>'#ef4444', 'bg'=>'#fee2e2'],
            ];
        @endphp

        @foreach($stats as $s)
        <div class="card" style="display: flex; flex-direction: column; gap: 12px;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <span style="font-size: 13px; color: var(--text-secondary); font-weight: 500;">{{ $s['label'] }}</span>
                <div style="width: 36px; height: 36px; border-radius: 9px; background: {{ $s['bg'] }}; display: flex; align-items: center; justify-content: center;">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="{{ $s['color'] }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="{{ $s['icon'] }}"/>
                    </svg>
                </div>
            </div>
            <div style="font-family: 'Outfit', sans-serif; font-size: 28px; font-weight: 700; color: var(--text-primary);" id="{{ $s['id'] }}">{{ $s['value'] }}</div>
        </div>
        @endforeach
    </div>

    <!-- Welcome & Quick Actions -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 28px;">
        <!-- Welcome card -->
        <div style="background: linear-gradient(135deg, #1e3a5f 0%, #1a2744 100%); border-radius: 16px; padding: 28px; position: relative; overflow: hidden;">
            <div style="position: absolute; top: -30px; right: -30px; width: 120px; height: 120px; border-radius: 50%; background: rgba(59,130,246,0.2);"></div>
            <div style="position: absolute; bottom: -20px; right: 60px; width: 80px; height: 80px; border-radius: 50%; background: rgba(99,102,241,0.15);"></div>
            <div style="position: relative;">
                <p style="font-size: 12px; color: rgba(255,255,255,0.6); letter-spacing: 1px; text-transform: uppercase; font-weight: 500; margin-bottom: 6px;">Welcome back</p>
                <h2 style="font-family: 'Outfit', sans-serif; font-size: 22px; font-weight: 700; color: white; margin-bottom: 8px;">{{ auth()->user()->name }}</h2>
                <p style="font-size: 13px; color: rgba(255,255,255,0.65); line-height: 1.5; margin-bottom: 20px;">Ready to manage your library? Here's what's happening today.</p>
                <a href="{{ url('/app/books') }}" style="display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.15); color: white; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; backdrop-filter: blur(4px); border: 1px solid rgba(255,255,255,0.2); transition: background 0.15s;" onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                    Browse Catalog
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            </div>
        </div>

        <!-- Quick actions -->
        <div class="card">
            <h3 style="font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 16px;">Quick Actions</h3>
            <div style="display: flex; flex-direction: column; gap: 8px;">
                @foreach([
                    ['/app/books','Browse Book Catalog','View and manage all library books','M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253','#2563eb','#eff6ff'],
                    ['/app/loans','Manage Loans','Track circulations and returns','M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4','#f59e0b','#fef3c7'],
                    ['/app/ai','AI Recommendations','Get personalized book suggestions','M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m1.636-6.364l.707.707M12 21v-1','#10b981','#d1fae5'],
                ] as [$link, $title, $desc, $icon, $col, $bg])
                <a href="{{ url($link) }}" style="display: flex; align-items: center; gap: 12px; padding: 12px; border-radius: 10px; text-decoration: none; border: 1px solid var(--border); transition: all 0.15s;" onmouseover="this.style.borderColor='{{ $col }}'; this.style.background='{{ $bg }}'" onmouseout="this.style.borderColor='var(--border)'; this.style.background='transparent'">
                    <div style="width: 36px; height: 36px; border-radius: 9px; background: {{ $bg }}; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="{{ $col }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $icon }}"/></svg>
                    </div>
                    <div>
                        <div style="font-size: 13.5px; font-weight: 600; color: var(--text-primary);">{{ $title }}</div>
                        <div style="font-size: 12px; color: var(--text-muted);">{{ $desc }}</div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Books -->
    <div class="card">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
            <h3 style="font-size: 14px; font-weight: 600; color: var(--text-primary);">Recent Catalog Entries</h3>
            <a href="{{ url('/app/books') }}" style="font-size: 12px; color: var(--accent); text-decoration: none; font-weight: 500;">View All →</a>
        </div>
        <div id="recent-books" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px;">
            <!-- Loaded via JS -->
            @foreach(range(1,4) as $i)
            <div class="book-skeleton" style="border: 1px solid var(--border); border-radius: 10px; overflow: hidden; animation: pulse 1.5s infinite;">
                <div style="height: 80px; background: var(--border);"></div>
                <div style="padding: 10px;">
                    <div style="height: 8px; background: var(--border); border-radius: 4px; margin-bottom: 6px;"></div>
                    <div style="height: 8px; background: var(--border); border-radius: 4px; width: 70%;"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @push('scripts')
    <script>
        const BOOK_EMOJIS = ['📚','🔬','🧬','🌌','💻','🦋','🌿','🎭','📖','🔭'];
        const BOOK_COLORS = ['#dbeafe','#fce7f3','#dcfce7','#ede9fe','#fef3c7','#e0f2fe','#fef9c3','#ffedd5'];

        async function loadDashboardData() {
            try {
                const res = await fetch('/api/books');
                const data = await res.json();
                const books = data.data || data;

                // Stats
                document.getElementById('stat-books').textContent = books.length.toLocaleString();

                const loansRes = await fetch('/api/loans').catch(() => null);
                if (loansRes && loansRes.ok) {
                    const loansData = await loansRes.json();
                    const loans = loansData.data || loansData || [];
                    const active = Array.isArray(loans) ? loans.filter(l => !l.returned_at).length : 0;
                    const overdue = Array.isArray(loans) ? loans.filter(l => !l.returned_at && l.due_date && new Date(l.due_date) < new Date()).length : 0;
                    document.getElementById('stat-loans').textContent = active.toLocaleString();
                    document.getElementById('stat-overdue').textContent = overdue.toLocaleString();
                }

                // Recent books grid
                const recentBooks = books.slice(0, 4);
                const grid = document.getElementById('recent-books');
                grid.innerHTML = recentBooks.map((b, i) => {
                    const emoji = BOOK_EMOJIS[i % BOOK_EMOJIS.length];
                    const bg = BOOK_COLORS[i % BOOK_COLORS.length];
                    const avail = (b.stock || 0) > 0;
                    return `<div style="border: 1px solid var(--border); border-radius: 10px; overflow: hidden; transition: all 0.2s; cursor: pointer;" onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.12)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.boxShadow=''; this.style.transform=''">
                        <div style="height: 80px; background: ${bg}; display: flex; align-items: center; justify-content: center; font-size: 32px;">${emoji}</div>
                        <div style="padding: 10px;">
                            <div style="font-size: 10px; color: var(--accent); font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 3px;">${b.category || 'General'}</div>
                            <div style="font-size: 12.5px; font-weight: 600; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${b.title}</div>
                            <div style="font-size: 11px; color: var(--text-muted); margin-bottom: 6px;">${b.author || 'Unknown'}</div>
                            <span style="display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: 600; ${avail ? 'background:#dcfce7; color:#166534;' : 'background:#fee2e2; color:#991b1b;'}">${avail ? 'AVAILABLE' : 'ON LOAN'}</span>
                        </div>
                    </div>`;
                }).join('') || '<div style="grid-column: span 4; text-align: center; color: var(--text-muted); font-size: 14px; padding: 20px;">No books found</div>';

            } catch(e) {
                console.error('Dashboard data error:', e);
            }
        }

        loadDashboardData();

        // Skeleton pulse
        const style = document.createElement('style');
        style.textContent = '@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.5} }';
        document.head.appendChild(style);
    </script>
    @endpush
</x-app-layout>
