<x-app-layout>
    <x-slot name="header">My Library</x-slot>

    <style>
        .udash-wrap { display: flex; gap: 24px; align-items: flex-start; }

        /* ── LEFT SIDEBAR ── */
        .udash-sidebar {
            flex: 0 0 250px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* Welcome card */
        .welcome-card {
            background: linear-gradient(140deg, #0f2448 0%, #1a3563 60%, #1e40af 100%);
            border-radius: 16px;
            padding: 22px;
            position: relative;
            overflow: hidden;
        }
        .welcome-card::before {
            content: '';
            position: absolute;
            top: -40px; right: -40px;
            width: 120px; height: 120px;
            border-radius: 50%;
            background: rgba(59,130,246,0.25);
        }
        .welcome-card::after {
            content: '';
            position: absolute;
            bottom: -20px; left: -20px;
            width: 80px; height: 80px;
            border-radius: 50%;
            background: rgba(99,102,241,0.18);
        }
        .welcome-card-inner { position: relative; }
        .welcome-card .hi { font-size: 11px; color: rgba(255,255,255,0.55); letter-spacing: 1px; text-transform: uppercase; font-weight: 600; margin-bottom: 4px; }
        .welcome-card .name { font-family: 'Outfit', sans-serif; font-size: 18px; font-weight: 700; color: white; margin-bottom: 12px; line-height: 1.2; }
        .welcome-card .browse-btn {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,0.15); color: white;
            padding: 7px 14px; border-radius: 8px;
            font-size: 12px; font-weight: 600; text-decoration: none;
            border: 1px solid rgba(255,255,255,0.2);
            transition: background 0.15s;
        }
        .welcome-card .browse-btn:hover { background: rgba(255,255,255,0.25); }

        /* Collections panel */
        .collections-panel {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 18px;
        }
        .collections-panel h3 {
            font-family: 'Outfit', sans-serif;
            font-size: 15px; font-weight: 700;
            color: var(--text-primary); margin-bottom: 14px;
        }
        .col-section-label {
            font-size: 10px; font-weight: 700; letter-spacing: 1.5px;
            text-transform: uppercase; color: var(--text-muted);
            margin: 12px 0 6px;
        }
        .col-section-label:first-of-type { margin-top: 0; }
        .col-item {
            display: flex; align-items: center; gap: 9px;
            padding: 8px 10px; border-radius: 9px; cursor: pointer;
            transition: all 0.15s; margin-bottom: 2px;
        }
        .col-item:hover { background: var(--accent-light); }
        .col-item.active { background: var(--accent-light); }
        .col-item .col-name { flex: 1; font-size: 13px; color: var(--text-primary); }
        .col-item.active .col-name { color: var(--accent); font-weight: 600; }
        .col-item .col-count {
            font-size: 11.5px; color: var(--text-muted);
            background: var(--bg-primary);
            padding: 2px 8px; border-radius: 10px; font-weight: 500;
        }
        .col-item.active .col-count { background: rgba(37,99,235,0.15); color: var(--accent); }

        .avail-row {
            display: flex; align-items: center; gap: 8px;
            padding: 7px 10px; font-size: 13px; color: var(--text-primary);
            cursor: pointer; border-radius: 9px; margin-bottom: 3px;
        }
        .avail-row:hover { background: var(--accent-light); }
        .avail-row input { width: 15px; height: 15px; accent-color: var(--accent); cursor: pointer; }

        /* ── MAIN GRID ── */
        .udash-main { flex: 1; min-width: 0; }
        .udash-topbar {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 18px; flex-wrap: wrap; gap: 12px;
        }
        .udash-heading h2 {
            font-family: 'Outfit', sans-serif; font-size: 22px; font-weight: 700;
            color: var(--text-primary); line-height: 1.2;
        }
        .udash-heading p { font-size: 13px; color: var(--text-muted); margin-top: 2px; }
        .udash-search {
            position: relative;
        }
        .udash-search svg { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); pointer-events: none; }
        .udash-search input {
            padding: 8px 14px 8px 34px;
            background: var(--bg-card);
            border: 1.5px solid var(--border);
            border-radius: 9px;
            font-size: 13px; color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            outline: none; width: 210px; transition: border-color 0.15s;
        }
        .udash-search input::placeholder { color: var(--text-muted); }
        .udash-search input:focus { border-color: var(--accent); }
        html.dark .udash-search input { background: #1e2533; color: #f1f5f9; border-color: #374151; }

        /* Book grid */
        #user-books-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }
        .ubook-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.2s;
        }
        .ubook-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 32px rgba(0,0,0,0.13);
            border-color: var(--accent);
        }
        .ubook-cover {
            height: 155px; position: relative;
            display: flex; align-items: center; justify-content: center;
            font-size: 48px; overflow: hidden;
        }
        .ubook-badge {
            position: absolute; top: 9px; right: 9px;
            padding: 3px 9px; border-radius: 20px;
            font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.3px;
        }
        .ubook-info { padding: 11px 13px 13px; }
        .ubook-cat { font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--accent); margin-bottom: 4px; }
        .ubook-title {
            font-family: 'Outfit', sans-serif; font-size: 13.5px; font-weight: 700;
            color: var(--text-primary); line-height: 1.3; margin-bottom: 3px;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        .ubook-author { font-size: 11.5px; color: var(--text-muted); margin-bottom: 9px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .ubook-foot {
            display: flex; align-items: center; justify-content: space-between;
            padding-top: 8px; border-top: 1px solid var(--border);
        }
        .ubook-meta { font-size: 11px; color: var(--text-muted); }
        .ubook-bm {
            background: none; border: none; cursor: pointer;
            color: var(--text-muted); transition: color 0.15s; padding: 2px;
        }
        .ubook-bm:hover { color: var(--accent); }

        /* Detail modal */
        .u-modal-backdrop {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.55); z-index: 100;
            align-items: center; justify-content: center;
            backdrop-filter: blur(4px);
        }
        .u-modal-backdrop.open { display: flex; }
        .u-modal-box {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 20px; width: 100%; max-width: 520px;
            max-height: 90vh; overflow-y: auto;
            box-shadow: 0 24px 64px rgba(0,0,0,0.3);
            animation: slideUp 0.2s ease;
        }
        @keyframes slideUp { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:translateY(0)} }
        .u-modal-cover { height: 190px; display:flex; align-items:center; justify-content:center; font-size:68px; position:relative; border-radius:20px 20px 0 0; overflow:hidden; }
        .u-modal-body { padding: 22px; }
        .u-modal-cat { font-size:10.5px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--accent); margin-bottom:5px; }
        .u-modal-title { font-family:'Outfit',sans-serif; font-size:21px; font-weight:700; color:var(--text-primary); margin-bottom:4px; }
        .u-modal-author { font-size:13px; color:var(--text-muted); margin-bottom:14px; }
        .u-modal-desc { font-size:13.5px; color:var(--text-secondary); line-height:1.7; margin-bottom:18px; }
        .u-modal-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:18px; }
        .u-modal-meta { background:var(--bg-primary); border-radius:10px; padding:11px; }
        .u-modal-meta-label { font-size:10px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:var(--text-muted); margin-bottom:2px; }
        .u-modal-meta-val { font-size:13.5px; font-weight:600; color:var(--text-primary); }
        .u-modal-close { position:absolute; top:12px; right:12px; background:rgba(0,0,0,0.35); color:white; border:none; border-radius:50%; width:32px; height:32px; display:flex; align-items:center; justify-content:center; cursor:pointer; }
        .u-modal-close:hover { background:rgba(0,0,0,0.6); }

        /* Pagination */
        .u-pagination {
            display: flex; align-items: center; justify-content: space-between;
            margin-top: 20px; padding-top: 14px; border-top: 1px solid var(--border);
            font-size: 13px; color: var(--text-muted);
        }
        .u-page-btns { display: flex; gap: 5px; }
        .u-page-btn {
            width: 32px; height: 32px; border-radius: 8px;
            border: 1px solid var(--border); background: var(--bg-card);
            color: var(--text-primary); font-size: 12.5px; font-weight: 500;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            transition: all 0.15s; font-family: 'Inter', sans-serif;
        }
        .u-page-btn:hover { border-color: var(--accent); color: var(--accent); background: var(--accent-light); }
        .u-page-btn.active { background: var(--accent); color: #fff; border-color: var(--accent); }
        .u-page-btn:disabled { opacity: 0.4; cursor: not-allowed; }

        /* Responsive */
        @media (max-width: 900px) {
            .udash-wrap { flex-direction: column; }
            .udash-sidebar { flex: none; width: 100%; flex-direction: row; flex-wrap: wrap; gap: 12px; }
            .welcome-card { flex: 1; min-width: 220px; }
            .collections-panel { flex: 2; min-width: 260px; }
            #user-books-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 600px) {
            #user-books-grid { grid-template-columns: repeat(2, 1fr); }
            .udash-search input { width: 160px; }
        }

        @keyframes pulse { 0%,100%{opacity:1}50%{opacity:.5} }
        .skel { animation: pulse 1.4s infinite; }
    </style>

    <div class="udash-wrap">
        <!-- ══ LEFT ══ -->
        <div class="udash-sidebar">
            <!-- Welcome card -->
            <div class="welcome-card">
                <div class="welcome-card-inner">
                    <div class="hi">Welcome back</div>
                    <div class="name">{{ auth()->user()->name }}</div>
                    <a href="{{ url('/app/books') }}" class="browse-btn">
                        Browse All
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                </div>
            </div>

            <!-- Collections -->
            <div class="collections-panel">
                <h3>Collections</h3>

                <div class="col-section-label">By Category</div>
                <div class="col-item active" data-cat="all" onclick="uFilterCat('all',this)">
                    <span style="font-size:14px;">📚</span>
                    <span class="col-name">All Books</span>
                    <span class="col-count" id="u-count-all">—</span>
                </div>
                <div id="u-dynamic-cats"></div>

                <div class="col-section-label" style="margin-top:14px;">Availability</div>
                <label class="avail-row">
                    <input type="checkbox" id="u-chk-avail" onchange="uApplyFilters()">
                    Available Now
                </label>
                <label class="avail-row">
                    <input type="checkbox" id="u-chk-loan" onchange="uApplyFilters()">
                    On Loan
                </label>
            </div>
        </div>

        <!-- ══ MAIN ══ -->
        <div class="udash-main">
            <div class="udash-topbar">
                <div class="udash-heading">
                    <h2 id="u-heading">All Books</h2>
                    <p id="u-sub">Your complete library collection</p>
                </div>
                <div class="udash-search">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="var(--text-muted)" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" id="u-search" placeholder="Search by title, author..." oninput="uApplyFilters()">
                </div>
            </div>

            <!-- Grid -->
            <div id="user-books-grid">
                @foreach(range(1,8) as $i)
                <div class="ubook-card skel">
                    <div style="height:155px;background:var(--border);"></div>
                    <div style="padding:11px 13px 13px;">
                        <div style="height:7px;background:var(--border);border-radius:4px;margin-bottom:7px;width:50%;"></div>
                        <div style="height:11px;background:var(--border);border-radius:4px;margin-bottom:6px;"></div>
                        <div style="height:9px;background:var(--border);border-radius:4px;width:65%;"></div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Empty state -->
            <div id="u-empty" style="display:none;text-align:center;padding:52px 20px;">
                <div style="font-size:44px;margin-bottom:10px;">📭</div>
                <p style="font-size:15px;font-weight:600;color:var(--text-primary);margin-bottom:4px;">No books found</p>
                <p style="font-size:13px;color:var(--text-muted);">Try adjusting your search or filters</p>
            </div>

            <!-- Pagination -->
            <div class="u-pagination" id="u-pagination" style="display:none;">
                <span id="u-page-info">Showing — books</span>
                <div class="u-page-btns" id="u-page-btns"></div>
            </div>
        </div>
    </div>

    <!-- ══ DETAIL MODAL ══ -->
    <div class="u-modal-backdrop" id="u-detail-modal" onclick="if(event.target===this)uCloseModal()">
        <div class="u-modal-box">
            <div class="u-modal-cover" id="u-modal-cover">
                <span id="u-modal-emoji">📚</span>
                <button class="u-modal-close" onclick="uCloseModal()">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <span id="u-modal-badge" class="ubook-badge"></span>
            </div>
            <div class="u-modal-body">
                <div class="u-modal-cat" id="u-modal-cat"></div>
                <div class="u-modal-title" id="u-modal-title"></div>
                <div class="u-modal-author" id="u-modal-author"></div>
                <div class="u-modal-desc" id="u-modal-desc"></div>
                <div class="u-modal-grid">
                    <div class="u-modal-meta"><div class="u-modal-meta-label">Stock</div><div class="u-modal-meta-val" id="u-modal-stock">—</div></div>
                    <div class="u-modal-meta"><div class="u-modal-meta-label">Status</div><div class="u-modal-meta-val" id="u-modal-status">—</div></div>
                    <div class="u-modal-meta"><div class="u-modal-meta-label">ISBN</div><div class="u-modal-meta-val" id="u-modal-isbn">—</div></div>
                    <div class="u-modal-meta"><div class="u-modal-meta-label">Year</div><div class="u-modal-meta-val" id="u-modal-year">—</div></div>
                </div>
                <div id="u-modal-avail-msg" style="padding:12px 16px;border-radius:10px;font-size:13.5px;font-weight:500;text-align:center;"></div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const EMOJIS = ['📚','🔬','🧬','🌌','💻','🦋','🌿','🎭','📖','🔭','🎨','🏛️','🦀','🧠','🌊','⚡','🎵','🌍','🦁','🔮'];
        const COLORS = ['#dbeafe','#fce7f3','#dcfce7','#ede9fe','#fef3c7','#e0f2fe','#fef9c3','#ffedd5','#ecfdf5','#fef2f2'];
        const DESCS = [
            'A fascinating exploration of the subject, offering readers deep insights backed by years of research and study.',
            'This comprehensive volume covers all aspects with clarity and intellectual rigor.',
            'Groundbreaking in its approach, this book challenges conventional wisdom and offers fresh perspectives.',
            'An authoritative reference that has shaped thinking in its field, blending theory with real-world examples.',
        ];
        const CAT_ICONS = {'Science':'🔬','Biology':'🧬','Astrophysics':'🌌','Chemistry':'⚗️','Computer Science':'💻','Computing':'💻','History':'🏛️','Mathematics':'∑','Philosophy':'💡','Fiction':'🎭','Poetry':'✍️','Drama':'🎪','General':'📚','Arts':'🎨','Physics':'⚡','Astronomy':'🪐'};

        const PER_PAGE = 8;
        let allBooks = [], filteredBooks = [], currentCat = 'all', currentPage = 1, currentBook = null;

        async function uLoadBooks() {
            const res = await fetch('/api/books');
            const data = await res.json();
            allBooks = data.data || data;
            uBuildCats();
            uApplyFilters();
        }

        function uBuildCats() {
            const cats = {};
            allBooks.forEach(b => { const c = b.category||'General'; cats[c]=(cats[c]||0)+1; });
            document.getElementById('u-count-all').textContent = allBooks.length.toLocaleString();
            document.getElementById('u-dynamic-cats').innerHTML = Object.entries(cats).sort((a,b)=>b[1]-a[1]).map(([c,n])=>`
                <div class="col-item" data-cat="${c}" onclick="uFilterCat('${c}',this)">
                    <span style="font-size:13px;">${CAT_ICONS[c]||'📖'}</span>
                    <span class="col-name">${c}</span>
                    <span class="col-count">${n.toLocaleString()}</span>
                </div>`).join('');
        }

        function uFilterCat(cat, el) {
            currentCat = cat; currentPage = 1;
            document.querySelectorAll('.col-item').forEach(e=>e.classList.remove('active'));
            el.classList.add('active');
            document.getElementById('u-heading').textContent = cat==='all' ? 'All Books' : cat+' Collection';
            document.getElementById('u-sub').textContent = cat==='all' ? 'Your complete library collection' : `Exploring the ${cat} section`;
            uApplyFilters();
        }

        function uApplyFilters() {
            const q = (document.getElementById('u-search').value||'').toLowerCase();
            const wA = document.getElementById('u-chk-avail').checked;
            const wL = document.getElementById('u-chk-loan').checked;
            filteredBooks = allBooks.filter(b => {
                const mc = currentCat==='all' || (b.category||'General')===currentCat;
                const mq = !q || b.title?.toLowerCase().includes(q) || b.author?.toLowerCase().includes(q) || b.category?.toLowerCase().includes(q);
                const avail = (b.stock||0)>0;
                let ma = true;
                if (wA&&wL) ma=true; else if(wA) ma=avail; else if(wL) ma=!avail;
                return mc&&mq&&ma;
            });
            currentPage=1; uRenderPage();
        }

        function uRenderPage() {
            const total=filteredBooks.length, pages=Math.ceil(total/PER_PAGE);
            const start=(currentPage-1)*PER_PAGE, slice=filteredBooks.slice(start,start+PER_PAGE);
            const grid=document.getElementById('user-books-grid');
            const empty=document.getElementById('u-empty');
            const pag=document.getElementById('u-pagination');

            if(!total){ grid.innerHTML=''; empty.style.display='block'; pag.style.display='none'; return; }
            empty.style.display='none'; pag.style.display='flex';

            grid.innerHTML = slice.map(b=>{
                const idx=allBooks.indexOf(b), emoji=EMOJIS[idx%EMOJIS.length], bg=COLORS[idx%COLORS.length];
                const avail=(b.stock||0)>0;
                return `<div class="ubook-card" onclick="uOpenModal(${b.id})">
                    <div class="ubook-cover" style="background:${bg};">
                        <span>${emoji}</span>
                        <span class="ubook-badge" style="${avail?'background:#16a34a;color:#fff;':'background:#dc2626;color:#fff;'}">${avail?'AVAILABLE':'ON LOAN'}</span>
                    </div>
                    <div class="ubook-info">
                        <div class="ubook-cat">${b.category||'General'}</div>
                        <div class="ubook-title">${b.title}</div>
                        <div class="ubook-author">${b.author?'by '+b.author:'Unknown Author'}</div>
                        <div class="ubook-foot">
                            <span class="ubook-meta">${avail?b.stock+' in stock':'On loan'}</span>
                            <button class="ubook-bm" onclick="event.stopPropagation()">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>`;
            }).join('');

            document.getElementById('u-page-info').textContent=`Showing ${start+1}–${Math.min(start+PER_PAGE,total)} of ${total.toLocaleString()} books`;
            const btns=document.getElementById('u-page-btns');
            let html=`<button class="u-page-btn" onclick="uGoPage(${currentPage-1})" ${currentPage===1?'disabled':''}>
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </button>`;
            for(let p=1;p<=pages;p++){
                if(p===1||p===pages||(p>=currentPage-1&&p<=currentPage+1)) html+=`<button class="u-page-btn ${p===currentPage?'active':''}" onclick="uGoPage(${p})">${p}</button>`;
                else if(p===currentPage-2||p===currentPage+2) html+=`<button class="u-page-btn" disabled style="border:none;background:none;">…</button>`;
            }
            html+=`<button class="u-page-btn" onclick="uGoPage(${currentPage+1})" ${currentPage===pages?'disabled':''}>
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </button>`;
            btns.innerHTML=html;
        }

        function uGoPage(p){ const t=Math.ceil(filteredBooks.length/PER_PAGE); if(p<1||p>t)return; currentPage=p; uRenderPage(); window.scrollTo({top:0,behavior:'smooth'}); }

        function uOpenModal(id){
            const b=allBooks.find(x=>x.id===id); if(!b)return; currentBook=b;
            const idx=allBooks.indexOf(b), emoji=EMOJIS[idx%EMOJIS.length], bg=COLORS[idx%COLORS.length];
            const avail=(b.stock||0)>0;
            document.getElementById('u-modal-cover').style.background=bg;
            document.getElementById('u-modal-emoji').textContent=emoji;
            document.getElementById('u-modal-cat').textContent=b.category||'General';
            document.getElementById('u-modal-title').textContent=b.title;
            document.getElementById('u-modal-author').textContent=b.author?'by '+b.author:'Unknown Author';
            document.getElementById('u-modal-desc').textContent=b.description||DESCS[idx%DESCS.length];
            document.getElementById('u-modal-stock').textContent=(b.stock||0)+' copies';
            document.getElementById('u-modal-status').textContent=avail?'✅ Available':'🔴 On Loan';
            document.getElementById('u-modal-isbn').textContent=b.isbn||'—';
            document.getElementById('u-modal-year').textContent=b.year||b.published_year||'—';
            const badge=document.getElementById('u-modal-badge');
            badge.textContent=avail?'AVAILABLE':'ON LOAN';
            badge.style.cssText=avail?'background:#16a34a;color:#fff;top:12px;left:12px;':'background:#dc2626;color:#fff;top:12px;left:12px;';
            const msg=document.getElementById('u-modal-avail-msg');
            msg.style.cssText=avail?'background:#dcfce7;color:#166534;':'background:#fee2e2;color:#991b1b;';
            msg.textContent=avail?`📗 This book is available — visit the library desk to borrow it.`:`📕 This book is currently on loan. Check back later.`;
            document.getElementById('u-detail-modal').classList.add('open');
        }
        function uCloseModal(){ document.getElementById('u-detail-modal').classList.remove('open'); }
        document.addEventListener('keydown',e=>{ if(e.key==='Escape') uCloseModal(); });

        uLoadBooks();
    </script>
    @endpush
</x-app-layout>
