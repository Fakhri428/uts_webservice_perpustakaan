<x-app-layout>
    <x-slot name="header">Catalog</x-slot>

    <style>
        /* ── Book Catalog Layout ── */
        .catalog-wrap {
            display: flex;
            gap: 24px;
            align-items: flex-start;
        }

        /* LEFT SIDEBAR */
        .cat-sidebar {
            flex: 0 0 260px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            position: sticky;
            top: 24px;
        }
        .cat-sidebar h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 20px;
        }
        .cat-section-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--text-muted);
            margin: 16px 0 8px;
        }
        .cat-section-label:first-of-type { margin-top: 0; }
        .cat-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            border-radius: 9px;
            cursor: pointer;
            transition: all 0.15s;
            margin-bottom: 2px;
            text-decoration: none;
        }
        .cat-item:hover { background: var(--accent-light); }
        .cat-item.active {
            background: var(--accent-light);
            color: var(--accent);
            font-weight: 600;
        }
        .cat-item .cat-name {
            flex: 1;
            font-size: 13.5px;
            color: var(--text-primary);
        }
        .cat-item.active .cat-name { color: var(--accent); }
        .cat-item .cat-count {
            font-size: 12px;
            color: var(--text-muted);
            background: var(--bg-primary);
            padding: 2px 8px;
            border-radius: 10px;
            font-weight: 500;
        }
        .cat-item.active .cat-count { background: rgba(37,99,235,0.15); color: var(--accent); }

        .avail-checkbox {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 10px;
            cursor: pointer;
            font-size: 13.5px;
            color: var(--text-primary);
            margin-bottom: 4px;
            border-radius: 9px;
        }
        .avail-checkbox:hover { background: var(--accent-light); }
        .avail-checkbox input {
            width: 16px; height: 16px;
            accent-color: var(--accent);
            cursor: pointer;
        }

        /* MAIN CONTENT */
        .cat-main { flex: 1; min-width: 0; }
        .cat-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 6px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .cat-title-area h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 26px;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.2;
        }
        .cat-title-area p {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 3px;
        }
        .cat-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .cat-search {
            position: relative;
        }
        .cat-search svg {
            position: absolute; left: 11px; top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
        }
        .cat-search input {
            padding: 8px 14px 8px 36px;
            background: var(--bg-card);
            border: 1.5px solid var(--border);
            border-radius: 9px;
            font-size: 13px;
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            outline: none;
            width: 220px;
            transition: border-color 0.15s;
        }
        .cat-search input::placeholder { color: var(--text-muted); }
        .cat-search input:focus { border-color: var(--accent); }
        html.dark .cat-search input { background: #1e2533; color: #f1f5f9; border-color: #374151; }
        html.dark .cat-search input::placeholder { color: #64748b; }

        /* book grid */
        #books-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-top: 20px;
        }

        .book-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.2s;
        }
        .book-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 36px rgba(0,0,0,0.15);
            border-color: var(--accent);
        }
        .book-cover {
            height: 160px;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 52px;
        }
        .book-badge {
            position: absolute;
            top: 9px; right: 9px;
            padding: 3px 9px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }
        .badge-avail { background: #16a34a; color: #fff; }
        .badge-loan  { background: #dc2626; color: #fff; }
        .badge-reserved { background: #7c3aed; color: #fff; }
        .book-info { padding: 12px 14px 14px; }
        .book-category {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 5px;
        }
        .book-title {
            font-family: 'Outfit', sans-serif;
            font-size: 14.5px;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.3;
            margin-bottom: 4px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .book-author {
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 10px;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .book-foot {
            display: flex; align-items: center; justify-content: space-between;
            padding-top: 9px;
            border-top: 1px solid var(--border);
        }
        .book-meta { font-size: 11px; color: var(--text-muted); }
        .book-bookmark {
            background: none; border: none; cursor: pointer; padding: 2px;
            color: var(--text-muted); transition: color 0.15s;
        }
        .book-bookmark:hover { color: var(--accent); }

        /* pagination */
        .pagination {
            display: flex; align-items: center; justify-content: space-between;
            margin-top: 24px; padding-top: 16px;
            border-top: 1px solid var(--border);
            font-size: 13px; color: var(--text-muted);
        }
        .page-btns { display: flex; gap: 6px; }
        .page-btn {
            width: 34px; height: 34px;
            border-radius: 8px; border: 1px solid var(--border);
            background: var(--bg-card); color: var(--text-primary);
            font-size: 13px; font-weight: 500;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            transition: all 0.15s; font-family: 'Inter', sans-serif;
        }
        .page-btn:hover { border-color: var(--accent); color: var(--accent); background: var(--accent-light); }
        .page-btn.active { background: var(--accent); color: #fff; border-color: var(--accent); }
        .page-btn:disabled { opacity: 0.4; cursor: not-allowed; }

        /* FAB add button */
        .fab-add {
            position: fixed; bottom: 32px; right: 32px;
            width: 52px; height: 52px;
            background: var(--accent);
            color: white; border: none; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; z-index: 50;
            box-shadow: 0 4px 20px rgba(37,99,235,0.45);
            transition: all 0.2s;
        }
        .fab-add:hover { transform: scale(1.1); background: var(--accent-hover); }

        /* ── BOOK DETAIL MODAL ── */
        .modal-backdrop {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.55);
            z-index: 100;
            align-items: center; justify-content: center;
            backdrop-filter: blur(4px);
        }
        .modal-backdrop.open { display: flex; }
        .modal-box {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 20px;
            width: 100%; max-width: 560px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 24px 64px rgba(0,0,0,0.3);
            animation: slideUp 0.2s ease;
        }
        @keyframes slideUp { from { opacity:0; transform: translateY(16px); } to { opacity:1; transform: translateY(0); } }
        .modal-cover {
            height: 200px; display: flex; align-items: center; justify-content: center;
            font-size: 72px; position: relative; border-radius: 20px 20px 0 0; overflow: hidden;
        }
        .modal-body { padding: 24px; }
        .modal-category { font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--accent); margin-bottom: 6px; }
        .modal-title { font-family: 'Outfit', sans-serif; font-size: 22px; font-weight: 700; color: var(--text-primary); margin-bottom: 4px; }
        .modal-author { font-size: 14px; color: var(--text-muted); margin-bottom: 16px; }
        .modal-desc { font-size: 14px; color: var(--text-secondary); line-height: 1.7; margin-bottom: 20px; }
        .modal-meta-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px; }
        .modal-meta-item { background: var(--bg-primary); border-radius: 10px; padding: 12px; }
        .modal-meta-label { font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--text-muted); margin-bottom: 3px; }
        .modal-meta-value { font-size: 14px; font-weight: 600; color: var(--text-primary); }
        .modal-close {
            position: absolute; top: 14px; right: 14px;
            background: rgba(0,0,0,0.35); color: white;
            border: none; border-radius: 50%; width: 34px; height: 34px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: background 0.15s;
        }
        .modal-close:hover { background: rgba(0,0,0,0.6); }

        /* Add book modal */
        .add-modal-backdrop {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.55); z-index: 150;
            align-items: center; justify-content: center;
            backdrop-filter: blur(4px);
        }
        .add-modal-backdrop.open { display: flex; }

        /* skeleton */
        @keyframes pulse { 0%,100%{opacity:1}50%{opacity:.5} }
        .skel { animation: pulse 1.4s infinite; }
    </style>

    <div class="catalog-wrap">
        <!-- ══ LEFT: Categories ══ -->
        <aside class="cat-sidebar">
            <h2>Collections</h2>

            <div class="cat-section-label">By Category</div>
            <div id="cat-list">
                <div class="cat-item active" data-cat="all" onclick="filterCat('all', this)">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:var(--accent)"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                    <span class="cat-name">All Books</span>
                    <span class="cat-count" id="count-all">—</span>
                </div>
                <!-- Dynamic category items will be injected here by JS -->
                <div id="dynamic-cats"></div>
            </div>

            <div class="cat-section-label" style="margin-top:20px;">Availability</div>
            <label class="avail-checkbox">
                <input type="checkbox" id="chk-avail" onchange="applyFilters()">
                Available Now
            </label>
            <label class="avail-checkbox">
                <input type="checkbox" id="chk-loan" onchange="applyFilters()">
                On Loan
            </label>
        </aside>

        <!-- ══ MAIN: Book Grid ══ -->
        <div class="cat-main">
            <!-- Topbar -->
            <div class="cat-topbar">
                <div class="cat-title-area">
                    <h1 id="cat-heading">All Books</h1>
                    <p id="cat-sub">Your complete library collection</p>
                </div>
                <div class="cat-controls">
                    <div class="cat-search">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="var(--text-muted)" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input id="search-input" type="text" placeholder="Search by title, author, or ISBN..." oninput="applyFilters()">
                    </div>
                    <div style="display:flex; gap:6px;">
                        <button style="width:34px;height:34px;border-radius:8px;border:1.5px solid var(--accent);background:var(--accent);display:flex;align-items:center;justify-content:center;cursor:pointer;">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        </button>
                    </div>
                    @if(auth()->check() && auth()->user()->role === 'admin')
                    <button onclick="toggleAddModal(true)" style="display:flex;align-items:center;gap:6px;padding:8px 16px;background:var(--accent);color:white;border:none;border-radius:9px;font-size:13px;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Add Book
                    </button>
                    @endif
                </div>
            </div>

            <!-- Grid -->
            <div id="books-grid">
                @foreach(range(1,8) as $i)
                <div class="book-card skel">
                    <div style="height:160px;background:var(--border);"></div>
                    <div style="padding:12px 14px 14px;">
                        <div style="height:8px;background:var(--border);border-radius:4px;margin-bottom:8px;width:50%;"></div>
                        <div style="height:12px;background:var(--border);border-radius:4px;margin-bottom:6px;"></div>
                        <div style="height:10px;background:var(--border);border-radius:4px;width:70%;"></div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Empty state -->
            <div id="empty-state" style="display:none;text-align:center;padding:60px 20px;">
                <div style="font-size:48px;margin-bottom:12px;">📭</div>
                <p style="font-size:16px;font-weight:600;color:var(--text-primary);margin-bottom:4px;">No books found</p>
                <p style="font-size:13px;color:var(--text-muted);">Try adjusting your search or filters</p>
            </div>

            <!-- Pagination -->
            <div class="pagination" id="pagination" style="display:none;">
                <span id="page-info">Showing — books</span>
                <div class="page-btns" id="page-btns"></div>
            </div>
        </div>
    </div>

    <!-- ══ BOOK DETAIL MODAL ══ -->
    <div class="modal-backdrop" id="detail-modal" onclick="if(event.target===this)closeDetailModal()">
        <div class="modal-box">
            <div class="modal-cover" id="modal-cover" style="background:#dbeafe;">
                <span id="modal-emoji">📚</span>
                <button class="modal-close" onclick="closeDetailModal()">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <span id="modal-badge" class="book-badge" style="top:12px;left:12px;right:auto;"></span>
            </div>
            <div class="modal-body">
                <div class="modal-category" id="modal-category">Category</div>
                <div class="modal-title" id="modal-title">Book Title</div>
                <div class="modal-author" id="modal-author">Author</div>
                <div class="modal-desc" id="modal-desc">Description not available.</div>
                <div class="modal-meta-grid">
                    <div class="modal-meta-item">
                        <div class="modal-meta-label">Stock</div>
                        <div class="modal-meta-value" id="modal-stock">—</div>
                    </div>
                    <div class="modal-meta-item">
                        <div class="modal-meta-label">Status</div>
                        <div class="modal-meta-value" id="modal-status">—</div>
                    </div>
                    <div class="modal-meta-item">
                        <div class="modal-meta-label">ISBN</div>
                        <div class="modal-meta-value" id="modal-isbn">—</div>
                    </div>
                    <div class="modal-meta-item">
                        <div class="modal-meta-label">Year</div>
                        <div class="modal-meta-value" id="modal-year">—</div>
                    </div>
                </div>
                @if(auth()->check() && auth()->user()->role === 'admin')
                <div style="display:flex;gap:10px;" id="modal-admin-btns">
                    <button id="modal-del-btn" onclick="deleteCurrentBook()" style="flex:1;padding:10px;background:#fee2e2;color:#991b1b;border:none;border-radius:9px;font-size:13px;font-weight:600;cursor:pointer;">Delete Book</button>
                    <button id="modal-inc-btn" onclick="incrementCurrentStock()" style="flex:1;padding:10px;background:#dcfce7;color:#166534;border:none;border-radius:9px;font-size:13px;font-weight:600;cursor:pointer;">+1 Stock</button>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- ══ ADD BOOK MODAL (admin) ══ -->
    @if(auth()->check() && auth()->user()->role === 'admin')
    <div class="add-modal-backdrop" id="add-modal" onclick="if(event.target===this)toggleAddModal(false)">
        <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:20px;padding:28px;width:100%;max-width:480px;box-shadow:0 24px 64px rgba(0,0,0,0.3);">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                <h3 style="font-family:'Outfit',sans-serif;font-size:19px;font-weight:700;color:var(--text-primary);">Add New Book</h3>
                <button onclick="toggleAddModal(false)" style="background:none;border:none;cursor:pointer;color:var(--text-muted);">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form id="book-form" onsubmit="submitAddBook(event)">
                <div style="margin-bottom:14px;">
                    <label class="form-label">Title *</label>
                    <input name="title" class="form-input" placeholder="Book title" required>
                </div>
                <div style="margin-bottom:14px;">
                    <label class="form-label">Author</label>
                    <input name="author" class="form-input" placeholder="Author name">
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px;">
                    <div>
                        <label class="form-label">Category</label>
                        <input name="category" class="form-input" placeholder="e.g. Science">
                    </div>
                    <div>
                        <label class="form-label">Stock</label>
                        <input name="stock" type="number" class="form-input" value="1" min="0">
                    </div>
                </div>
                <div style="margin-bottom:20px;">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-input" rows="3" placeholder="Short description..."></textarea>
                </div>
                <div style="display:flex;gap:10px;justify-content:flex-end;">
                    <button type="button" onclick="toggleAddModal(false)" style="padding:10px 18px;background:transparent;border:1.5px solid var(--border);color:var(--text-secondary);border-radius:9px;font-size:13px;font-weight:600;cursor:pointer;">Cancel</button>
                    <button type="submit" class="btn-primary" style="padding:10px 22px;">Add Book</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    @push('scripts')
    <script>
        const EMOJIS = ['📚','🔬','🧬','🌌','💻','🦋','🌿','🎭','📖','🔭','🎨','🏛️','🦀','🧠','🌊','⚡','🎵','🌍','🦁','🔮'];
        const COLORS = ['#dbeafe','#fce7f3','#dcfce7','#ede9fe','#fef3c7','#e0f2fe','#fef9c3','#ffedd5','#ecfdf5','#fef2f2'];
        const PER_PAGE = 8;
        const userRole = "{{ auth()->check() ? auth()->user()->role : 'guest' }}";

        let allBooks = [];
        let filteredBooks = [];
        let currentCat = 'all';
        let currentPage = 1;
        let currentBook = null;

        // ── DATA ──
        async function fetchBooks() {
            try {
                const res = await fetch('/api/books');
                const data = await res.json();
                allBooks = data.data || data;
                buildCategories();
                applyFilters();
            } catch(e) { console.error(e); }
        }

        function buildCategories() {
            const cats = {};
            allBooks.forEach(b => {
                const c = b.category || 'General';
                cats[c] = (cats[c] || 0) + 1;
            });
            document.getElementById('count-all').textContent = allBooks.length.toLocaleString();

            const catIcons = {
                'Science':'🔬','Biology':'🧬','Astrophysics':'🌌','Chemistry':'⚗️',
                'Computer Science':'💻','Computing':'💻','History':'🏛️','Mathematics':'∑',
                'Philosophy':'💡','Fiction':'🎭','Poetry':'✍️','Drama':'🎪',
                'General':'📚','Arts':'🎨','Physics':'⚡','Astronomy':'🪐',
            };
            const container = document.getElementById('dynamic-cats');
            container.innerHTML = Object.entries(cats).sort((a,b) => b[1]-a[1]).map(([c, n]) => `
                <div class="cat-item" data-cat="${c}" onclick="filterCat('${c}', this)">
                    <span style="font-size:14px;">${catIcons[c] || '📖'}</span>
                    <span class="cat-name">${c}</span>
                    <span class="cat-count">${n.toLocaleString()}</span>
                </div>
            `).join('');
        }

        function filterCat(cat, el) {
            currentCat = cat;
            currentPage = 1;
            document.querySelectorAll('.cat-item').forEach(e => e.classList.remove('active'));
            el.classList.add('active');
            const heading = cat === 'all' ? 'All Books' : cat + ' Collection';
            const sub = cat === 'all' ? 'Your complete library collection' : `Exploring the ${cat} section`;
            document.getElementById('cat-heading').textContent = heading;
            document.getElementById('cat-sub').textContent = sub;
            applyFilters();
        }

        function applyFilters() {
            const q = (document.getElementById('search-input').value || '').toLowerCase();
            const wantAvail = document.getElementById('chk-avail').checked;
            const wantLoan = document.getElementById('chk-loan').checked;

            filteredBooks = allBooks.filter(b => {
                const matchCat = currentCat === 'all' || (b.category || 'General') === currentCat;
                const matchQ = !q || b.title?.toLowerCase().includes(q) || b.author?.toLowerCase().includes(q) || b.category?.toLowerCase().includes(q);
                const avail = (b.stock || 0) > 0;
                let matchAvail = true;
                if (wantAvail && wantLoan) matchAvail = true;
                else if (wantAvail) matchAvail = avail;
                else if (wantLoan) matchAvail = !avail;
                return matchCat && matchQ && matchAvail;
            });
            currentPage = 1;
            renderPage();
        }

        function renderPage() {
            const total = filteredBooks.length;
            const totalPages = Math.ceil(total / PER_PAGE);
            const start = (currentPage - 1) * PER_PAGE;
            const pageBooks = filteredBooks.slice(start, start + PER_PAGE);

            const grid = document.getElementById('books-grid');
            const empty = document.getElementById('empty-state');
            const pag = document.getElementById('pagination');

            if (!total) {
                grid.innerHTML = '';
                empty.style.display = 'block';
                pag.style.display = 'none';
                return;
            }
            empty.style.display = 'none';
            pag.style.display = 'flex';

            grid.innerHTML = pageBooks.map((b, i) => {
                const idx = allBooks.indexOf(b);
                const emoji = EMOJIS[idx % EMOJIS.length];
                const bgColor = COLORS[idx % COLORS.length];
                const avail = (b.stock || 0) > 0;
                const status = avail ? 'available' : 'loan';
                const badgeClass = avail ? 'badge-avail' : 'badge-loan';
                const badgeText = avail ? 'AVAILABLE' : 'ON LOAN';
                return `
                <div class="book-card" onclick="openBookDetail(${b.id})">
                    <div class="book-cover" style="background:${bgColor};">
                        <span>${emoji}</span>
                        <span class="book-badge ${badgeClass}">${badgeText}</span>
                    </div>
                    <div class="book-info">
                        <div class="book-category">${b.category || 'General'}</div>
                        <div class="book-title">${b.title}</div>
                        <div class="book-author">${b.author ? 'by ' + b.author : 'Unknown Author'}</div>
                        <div class="book-foot">
                            <span class="book-meta">${avail ? b.stock + ' in stock' : 'Currently on loan'}</span>
                            <button class="book-bookmark" onclick="event.stopPropagation()">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>`;
            }).join('');

            // Pagination info
            document.getElementById('page-info').textContent = `Showing ${start+1} to ${Math.min(start+PER_PAGE, total)} of ${total.toLocaleString()} books`;

            // Page buttons
            const btns = document.getElementById('page-btns');
            let pages = [];
            pages.push(`<button class="page-btn" onclick="goPage(${currentPage-1})" ${currentPage===1?'disabled':''}>
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </button>`);
            for (let p = 1; p <= totalPages; p++) {
                if (p === 1 || p === totalPages || (p >= currentPage - 1 && p <= currentPage + 1)) {
                    pages.push(`<button class="page-btn ${p===currentPage?'active':''}" onclick="goPage(${p})">${p}</button>`);
                } else if (p === currentPage - 2 || p === currentPage + 2) {
                    pages.push(`<button class="page-btn" disabled style="border:none;background:none;">…</button>`);
                }
            }
            pages.push(`<button class="page-btn" onclick="goPage(${currentPage+1})" ${currentPage===totalPages?'disabled':''}>
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </button>`);
            btns.innerHTML = pages.join('');
        }

        function goPage(p) {
            const total = Math.ceil(filteredBooks.length / PER_PAGE);
            if (p < 1 || p > total) return;
            currentPage = p;
            renderPage();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // ── DETAIL MODAL ──
        const BOOK_DESCRIPTIONS = [
            'A fascinating exploration of the subject matter, offering readers deep insights backed by years of research and study.',
            'This comprehensive volume covers all aspects of its topic, blending theory with real-world examples for an engaging read.',
            'An authoritative reference that has shaped thinking in its field, written with clarity and intellectual rigor.',
            'Groundbreaking in its approach, this book challenges conventional wisdom and offers fresh perspectives on complex ideas.',
        ];

        function openBookDetail(bookId) {
            const book = allBooks.find(b => b.id === bookId);
            if (!book) return;
            currentBook = book;

            const idx = allBooks.indexOf(book);
            const emoji = EMOJIS[idx % EMOJIS.length];
            const bgColor = COLORS[idx % COLORS.length];
            const avail = (book.stock || 0) > 0;

            document.getElementById('modal-cover').style.background = bgColor;
            document.getElementById('modal-emoji').textContent = emoji;
            document.getElementById('modal-category').textContent = book.category || 'General';
            document.getElementById('modal-title').textContent = book.title;
            document.getElementById('modal-author').textContent = book.author ? 'by ' + book.author : 'Unknown Author';
            document.getElementById('modal-desc').textContent = book.description || BOOK_DESCRIPTIONS[idx % BOOK_DESCRIPTIONS.length];
            document.getElementById('modal-stock').textContent = (book.stock || 0) + ' copies';
            document.getElementById('modal-status').textContent = avail ? '✅ Available' : '🔴 On Loan';
            document.getElementById('modal-isbn').textContent = book.isbn || '—';
            document.getElementById('modal-year').textContent = book.year || book.published_year || '—';

            const badge = document.getElementById('modal-badge');
            badge.textContent = avail ? 'AVAILABLE' : 'ON LOAN';
            badge.className = 'book-badge ' + (avail ? 'badge-avail' : 'badge-loan');

            document.getElementById('detail-modal').classList.add('open');
        }

        function closeDetailModal() {
            document.getElementById('detail-modal').classList.remove('open');
            currentBook = null;
        }

        // Admin: delete / increment from modal
        async function deleteCurrentBook() {
            if (!currentBook || !confirm('Delete "' + currentBook.title + '"?')) return;
            await fetch('/api/books/' + currentBook.id, { method: 'DELETE', headers: {'X-Requested-With':'XMLHttpRequest'} });
            closeDetailModal();
            fetchBooks();
        }
        async function incrementCurrentStock() {
            if (!currentBook) return;
            const newStock = (currentBook.stock || 0) + 1;
            await fetch('/api/books/' + currentBook.id, {
                method: 'PUT',
                headers: {'Content-Type':'application/json','X-Requested-With':'XMLHttpRequest'},
                body: JSON.stringify({ stock: newStock })
            });
            closeDetailModal();
            fetchBooks();
        }

        // ── ADD MODAL ──
        function toggleAddModal(open) {
            document.getElementById('add-modal')?.classList.toggle('open', open);
        }
        async function submitAddBook(e) {
            e.preventDefault();
            const f = e.target;
            const payload = {
                title: f.title.value,
                author: f.author.value,
                category: f.category.value,
                stock: parseInt(f.stock.value || 1),
                description: f.description?.value || '',
            };
            try {
                await fetch('/api/books', {
                    method: 'POST',
                    headers: {'Content-Type':'application/json','X-Requested-With':'XMLHttpRequest'},
                    body: JSON.stringify(payload)
                });
                f.reset();
                toggleAddModal(false);
                fetchBooks();
            } catch(err) { alert('Failed to add book'); }
        }

        // Close detail with Escape
        document.addEventListener('keydown', e => { if (e.key === 'Escape') { closeDetailModal(); toggleAddModal(false); } });

        fetchBooks();
    </script>
    @endpush
</x-app-layout>
