<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Catalog</h2>
    </x-slot>

    <style>
        .catalog-shell { display: grid; grid-template-columns: 250px minmax(0, 1fr); gap: 24px; align-items: start; }
        .catalog-sidebar, .catalog-panel { background: #fff; border: 1px solid #e5e7eb; border-radius: 20px; box-shadow: 0 10px 25px rgba(15, 23, 42, 0.04); }
        .catalog-sidebar { padding: 20px; position: sticky; top: 92px; }
        .catalog-brand { display: flex; align-items: center; gap: 12px; margin-bottom: 22px; }
        .catalog-brand-mark { width: 42px; height: 42px; border-radius: 12px; background: linear-gradient(135deg, #1d4ed8, #60a5fa); display: grid; place-items: center; color: #fff; font-weight: 800; box-shadow: 0 12px 24px rgba(29, 78, 216, 0.25); }
        .catalog-brand-title { font-size: 15px; font-weight: 800; color: #0f172a; line-height: 1.1; }
        .catalog-brand-sub { font-size: 11px; color: #94a3b8; margin-top: 2px; }
        .catalog-nav { display: grid; gap: 8px; margin-bottom: 18px; }
        .catalog-nav a { display: flex; align-items: center; gap: 10px; width: 100%; padding: 11px 12px; border-radius: 12px; color: #64748b; text-decoration: none; font-size: 13px; font-weight: 600; transition: 0.15s ease; }
        .catalog-nav a:hover, .catalog-nav a.active { background: #eff6ff; color: #1d4ed8; }
        .catalog-section-title { margin: 18px 0 10px; font-size: 10px; letter-spacing: 1.6px; font-weight: 800; text-transform: uppercase; color: #94a3b8; }
        .catalog-category-list { display: grid; gap: 8px; max-height: 320px; overflow: auto; padding-right: 2px; }
        .catalog-category-item { display: flex; align-items: center; justify-content: space-between; gap: 10px; padding: 10px 12px; border-radius: 12px; background: #f8fafc; color: #0f172a; font-size: 13px; font-weight: 600; cursor: pointer; border: 1px solid transparent; transition: 0.15s ease; }
        .catalog-category-item:hover, .catalog-category-item.active { border-color: #bfdbfe; background: #eff6ff; }
        .catalog-count { min-width: 34px; text-align: center; padding: 4px 8px; border-radius: 999px; background: #e2e8f0; color: #475569; font-size: 11px; font-weight: 700; }
        .catalog-filters label { display: flex; align-items: center; gap: 10px; margin-top: 10px; color: #334155; font-size: 13px; font-weight: 500; cursor: pointer; }
        .catalog-filters input { accent-color: #2563eb; }
        .quick-stat { margin-top: 18px; padding: 14px; border-radius: 16px; background: linear-gradient(135deg, #eff6ff, #f8fafc); border: 1px solid #dbeafe; }
        .quick-stat-label { font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 1.2px; }
        .quick-stat-value { margin-top: 6px; font-size: 26px; font-weight: 800; color: #1d4ed8; line-height: 1; }
        .quick-stat-note { margin-top: 4px; font-size: 12px; color: #64748b; }
        .catalog-panel { padding: 24px; min-width: 0; }
        .catalog-top { display: flex; align-items: start; justify-content: space-between; gap: 16px; margin-bottom: 18px; flex-wrap: wrap; }
        .catalog-heading h1 { font-size: 30px; line-height: 1.05; font-weight: 800; color: #0f172a; letter-spacing: -0.03em; }
        .catalog-heading p { margin-top: 6px; color: #64748b; font-size: 14px; }
        .catalog-toolbar { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        .search-wrap { position: relative; }
        .search-wrap input, .sort-select { height: 42px; border: 1px solid #e2e8f0; background: #fff; border-radius: 12px; padding: 0 14px 0 42px; font-size: 13px; color: #0f172a; outline: none; transition: 0.15s ease; }
        .search-wrap input { width: min(320px, 72vw); }
        .sort-select { padding-left: 14px; }
        .search-wrap input:focus, .sort-select:focus { border-color: #93c5fd; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12); }
        .search-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #94a3b8; pointer-events: none; }
        .catalog-tabs { display: flex; align-items: center; gap: 8px; margin-bottom: 16px; flex-wrap: wrap; }
        .tab-chip { border: 1px solid #e2e8f0; background: #fff; color: #475569; font-size: 12px; font-weight: 700; border-radius: 999px; padding: 8px 12px; cursor: pointer; transition: 0.15s ease; }
        .tab-chip:hover, .tab-chip.active { border-color: #bfdbfe; background: #eff6ff; color: #1d4ed8; }
        .book-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; }
        .book-card { border: 1px solid #e5e7eb; background: #fff; border-radius: 18px; overflow: hidden; box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04); transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease; cursor: pointer; }
        .book-card:hover { transform: translateY(-4px); border-color: #bfdbfe; box-shadow: 0 18px 32px rgba(15, 23, 42, 0.10); }
        .book-cover { position: relative; height: 230px; overflow: hidden; background: linear-gradient(135deg, #0f172a, #1d4ed8); }
        .book-cover img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .cover-fallback { width: 100%; height: 100%; display: grid; place-items: center; color: #fff; text-align: center; padding: 20px; background: radial-gradient(circle at top right, rgba(255,255,255,.18), transparent 35%), linear-gradient(135deg, #0f172a, #1d4ed8 65%, #60a5fa); }
        .cover-fallback span { font-size: 54px; filter: drop-shadow(0 10px 16px rgba(0,0,0,.22)); }
        .book-badge { position: absolute; top: 12px; left: 12px; padding: 6px 10px; border-radius: 999px; font-size: 10px; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase; color: #fff; backdrop-filter: blur(8px); background: rgba(59, 130, 246, 0.85); }
        .book-badge.loan { background: rgba(220, 38, 38, 0.85); }
        .book-body { padding: 14px 14px 15px; }
        .book-category { font-size: 10px; font-weight: 800; letter-spacing: 1.3px; text-transform: uppercase; color: #3b82f6; margin-bottom: 8px; }
        .book-title { font-size: 17px; line-height: 1.25; font-weight: 800; color: #0f172a; margin-bottom: 6px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .book-author { font-size: 13px; color: #64748b; margin-bottom: 10px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .book-meta { display: flex; align-items: center; justify-content: space-between; gap: 8px; padding-top: 10px; border-top: 1px solid #eef2f7; font-size: 12px; color: #64748b; }
        .book-meta strong { color: #0f172a; }
        .empty-state { padding: 48px 20px; text-align: center; color: #64748b; }
        .pagination-row { margin-top: 20px; padding-top: 16px; border-top: 1px solid #eef2f7; display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; color: #64748b; font-size: 13px; }
        .pagination-btns { display: flex; gap: 6px; flex-wrap: wrap; }
        .page-btn { min-width: 34px; height: 34px; padding: 0 11px; border-radius: 10px; border: 1px solid #e2e8f0; background: #fff; color: #0f172a; font-size: 13px; font-weight: 700; cursor: pointer; }
        .page-btn.active { background: #1d4ed8; border-color: #1d4ed8; color: #fff; }
        .book-modal { display: none; position: fixed; inset: 0; z-index: 60; align-items: center; justify-content: center; padding: 18px; background: rgba(15, 23, 42, 0.62); backdrop-filter: blur(6px); }
        .book-modal.open { display: flex; }
        .book-modal-box { width: min(760px, 100%); background: #fff; border-radius: 24px; overflow: hidden; box-shadow: 0 24px 80px rgba(0, 0, 0, 0.28); }
        .book-modal-cover { height: 220px; position: relative; background: linear-gradient(135deg, #0f172a, #1d4ed8); }
        .book-modal-cover img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .book-modal-body { padding: 22px; }
        .book-modal-grid { display: grid; grid-template-columns: 1.3fr 0.7fr; gap: 18px; }
        .book-modal-title { font-size: 28px; font-weight: 800; line-height: 1.1; color: #0f172a; margin-bottom: 8px; }
        .book-modal-meta { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 14px; }
        .book-pill { display: inline-flex; align-items: center; gap: 6px; border-radius: 999px; padding: 6px 10px; background: #eff6ff; color: #1d4ed8; font-size: 12px; font-weight: 700; }
        .book-desc { color: #334155; line-height: 1.75; font-size: 14px; white-space: pre-line; }
        .book-side { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 18px; padding: 16px; }
        .book-side-item { margin-bottom: 12px; }
        .book-side-item .label { font-size: 11px; letter-spacing: 1.2px; text-transform: uppercase; color: #94a3b8; font-weight: 800; margin-bottom: 4px; }
        .book-side-item .value { font-size: 14px; font-weight: 700; color: #0f172a; }
        .book-modal-actions { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 16px; }
        .book-modal-actions a, .book-modal-actions button { border: 0; border-radius: 12px; padding: 10px 14px; font-size: 14px; font-weight: 700; cursor: pointer; text-decoration: none; }
        .btn-circ { background: #2563eb; color: #fff; }
        .btn-close { background: #e2e8f0; color: #0f172a; }
        @media (max-width: 1200px) { .book-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
        @media (max-width: 960px) { .catalog-shell { grid-template-columns: 1fr; } .catalog-sidebar { position: static; } }
        @media (max-width: 700px) { .catalog-panel { padding: 18px; } .catalog-heading h1 { font-size: 24px; } .book-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } .search-wrap input { width: 100%; } }
        @media (max-width: 440px) { .book-grid { grid-template-columns: 1fr; } }
        @media (max-width: 760px) { .book-modal-grid { grid-template-columns: 1fr; } .book-modal-title { font-size: 22px; } }
    </style>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="catalog-shell">
                <aside class="catalog-sidebar">
                    <div class="catalog-section-title">Collections</div>
                    <div class="catalog-category-list" id="category-list">
                        <div class="catalog-category-item active" data-category="all">
                            <span>All Books</span>
                            <span class="catalog-count" id="count-all">0</span>
                        </div>
                    </div>

                    <div class="catalog-section-title">Availability</div>
                    <div class="catalog-filters">
                        <label><input type="checkbox" id="filter-available"> Available Now</label>
                        <label><input type="checkbox" id="filter-onloan"> On Loan</label>
                    </div>

                    <div class="quick-stat">
                        <div class="quick-stat-label">Quick Stats</div>
                        <div class="quick-stat-value" id="quick-total">0</div>
                        <div class="quick-stat-note">Books catalogued</div>
                    </div>
                </aside>

                <section class="catalog-panel">
                    <div class="catalog-top">
                        <div class="catalog-heading">
                            <h1 id="catalog-title">Science Collection</h1>
                            <p id="catalog-subtitle">Explore the collections, filter by category, and browse the library catalog.</p>
                        </div>

                        <div class="catalog-toolbar">
                            <div class="search-wrap">
                                <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.2-5.2m2.2-5.3a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                <input id="search-input" type="text" placeholder="Search by title, author or ISBN...">
                            </div>
                            <select id="sort-select" class="sort-select">
                                <option value="latest">Newest Arrival</option>
                                <option value="title">Title A-Z</option>
                                <option value="author">Author A-Z</option>
                                <option value="stock">Stock High-Low</option>
                            </select>
                        </div>
                    </div>

                    <div class="catalog-tabs">
                        <button class="tab-chip active" data-sortquick="all">All</button>
                        <button class="tab-chip" data-sortquick="available">Available</button>
                        <button class="tab-chip" data-sortquick="onloan">On Loan</button>
                    </div>

                    <div class="book-grid" id="book-grid">
                        <div class="empty-state" style="grid-column: 1 / -1;">Loading catalog...</div>
                    </div>

                    <div class="empty-state" id="empty-state" style="display:none;">
                        <div style="font-size:46px;margin-bottom:10px;">📭</div>
                        <div style="font-size:16px;font-weight:700;color:#0f172a;margin-bottom:4px;">No books found</div>
                        <div style="font-size:13px;">Try adjusting search or filters.</div>
                    </div>

                    <div class="pagination-row" id="pagination-row" style="display:none;">
                        <span id="page-info">Showing books</span>
                        <div class="pagination-btns" id="pagination-btns"></div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <div class="book-modal" id="book-modal" onclick="if(event.target === this) closeBookModal()">
        <div class="book-modal-box">
            <div class="book-modal-cover" id="book-modal-cover"></div>
            <div class="book-modal-body">
                <div class="book-modal-grid">
                    <div>
                        <div class="book-modal-meta" id="book-modal-meta"></div>
                        <div class="book-modal-title" id="book-modal-title"></div>
                        <div class="book-desc" id="book-modal-desc"></div>
                        <div class="book-modal-actions">
                            <a href="{{ route('user.loans') }}" class="btn-circ">Go to Circulation</a>
                            <button type="button" class="btn-close" onclick="closeBookModal()">Close</button>
                        </div>
                    </div>
                    <div class="book-side">
                        <div class="book-side-item">
                            <div class="label">Author</div>
                            <div class="value" id="book-modal-author"></div>
                        </div>
                        <div class="book-side-item">
                            <div class="label">Category</div>
                            <div class="value" id="book-modal-category"></div>
                        </div>
                        <div class="book-side-item">
                            <div class="label">ISBN</div>
                            <div class="value" id="book-modal-isbn"></div>
                        </div>
                        <div class="book-side-item">
                            <div class="label">Year</div>
                            <div class="value" id="book-modal-year"></div>
                        </div>
                        <div class="book-side-item" style="margin-bottom:0;">
                            <div class="label">Stock</div>
                            <div class="value" id="book-modal-stock"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const INITIAL_BOOKS = @json($books);
        const EMOJIS = ['📚','🔬','🧬','🌌','💻','🧠','🎭','⚗️','🪐','✍️','🎨','🏛️'];

        let allBooks = Array.isArray(INITIAL_BOOKS) ? INITIAL_BOOKS : [];
        let filteredBooks = [];
        let activeCategory = 'all';
        let activeQuick = 'all';
        let currentPage = 1;
        const perPage = 8;

        function escapeHtml(value) {
            return String(value ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
        }

        function normalize(v) {
            return String(v ?? '').trim().toLowerCase();
        }

        function getStatus(book) {
            return Number(book.stock || 0) > 0 ? 'AVAILABLE' : 'ON LOAN';
        }

        function coverMarkup(book, idx) {
            if (book.image) {
                return `<img src="/storage/${escapeHtml(book.image)}" alt="${escapeHtml(book.title)}">`;
            }

            const palette = [
                'linear-gradient(135deg, #0f172a, #1d4ed8 65%, #60a5fa)',
                'linear-gradient(135deg, #111827, #7c3aed 65%, #c084fc)',
                'linear-gradient(135deg, #082f49, #0284c7 65%, #38bdf8)',
                'linear-gradient(135deg, #1f2937, #059669 65%, #34d399)'
            ];
            return `<div class="cover-fallback" style="background:${palette[idx % palette.length]}"><span>${EMOJIS[idx % EMOJIS.length]}</span></div>`;
        }

        function openBookModal(book, idx) {
            const modal = document.getElementById('book-modal');
            const cover = document.getElementById('book-modal-cover');
            const meta = document.getElementById('book-modal-meta');

            cover.innerHTML = book.image
                ? `<img src="/storage/${escapeHtml(book.image)}" alt="${escapeHtml(book.title)}">`
                : `<div class="cover-fallback" style="height:220px;background:linear-gradient(135deg, #0f172a, #1d4ed8 65%, #60a5fa)"><span>${EMOJIS[idx % EMOJIS.length]}</span></div>`;

            document.getElementById('book-modal-title').textContent = book.title || 'Untitled';
            document.getElementById('book-modal-desc').textContent = book.description || 'No description available.';
            document.getElementById('book-modal-author').textContent = book.author || '-';
            document.getElementById('book-modal-category').textContent = book.category || 'Uncategorized';
            document.getElementById('book-modal-isbn').textContent = book.isbn || '-';
            document.getElementById('book-modal-year').textContent = book.published_year || '-';
            document.getElementById('book-modal-stock').textContent = Number(book.stock || 0);
            meta.innerHTML = `
                <span class="book-pill">${getStatus(book)}</span>
                <span class="book-pill">${escapeHtml(book.category || 'Uncategorized')}</span>
            `;

            modal.classList.add('open');
        }

        function closeBookModal() {
            document.getElementById('book-modal').classList.remove('open');
        }

        window.closeBookModal = closeBookModal;

        function updateHeading(categoryName) {
            const title = document.getElementById('catalog-title');
            const subtitle = document.getElementById('catalog-subtitle');
            if (activeCategory === 'all') {
                title.textContent = 'Science Collection';
                subtitle.textContent = 'Explore the collections, filter by category, and browse the library catalog.';
                return;
            }
            title.textContent = `${categoryName} Collection`;
            subtitle.textContent = `Browsing the ${categoryName.toLowerCase()} section of the catalog.`;
        }

        function renderCategories() {
            const list = document.getElementById('category-list');
            const categoryCounts = {};
            allBooks.forEach(book => {
                const cat = (book.category || 'Uncategorized').trim();
                categoryCounts[cat] = (categoryCounts[cat] || 0) + 1;
            });

            const sorted = Object.keys(categoryCounts).sort((a, b) => a.localeCompare(b));
            list.innerHTML = `
                <div class="catalog-category-item ${activeCategory === 'all' ? 'active' : ''}" data-category="all">
                    <span>All Books</span>
                    <span class="catalog-count" id="count-all">${allBooks.length}</span>
                </div>
                ${sorted.map(cat => `
                    <div class="catalog-category-item ${activeCategory === cat ? 'active' : ''}" data-category="${escapeHtml(cat)}">
                        <span>${escapeHtml(cat)}</span>
                        <span class="catalog-count">${categoryCounts[cat]}</span>
                    </div>
                `).join('')}
            `;

            document.querySelectorAll('.catalog-category-item').forEach(el => {
                el.addEventListener('click', () => {
                    activeCategory = el.dataset.category;
                    currentPage = 1;
                    renderCategories();
                    applyFilters();
                });
            });

            document.getElementById('quick-total').textContent = allBooks.length.toLocaleString();
        }

        function sortBooks(list) {
            const sorted = [...list];
            const mode = document.getElementById('sort-select').value;
            if (mode === 'title') sorted.sort((a, b) => String(a.title || '').localeCompare(String(b.title || '')));
            else if (mode === 'author') sorted.sort((a, b) => String(a.author || '').localeCompare(String(b.author || '')));
            else if (mode === 'stock') sorted.sort((a, b) => Number(b.stock || 0) - Number(a.stock || 0));
            else sorted.sort((a, b) => Number(b.id || 0) - Number(a.id || 0));
            return sorted;
        }

        function applyFilters() {
            const q = normalize(document.getElementById('search-input').value);
            const onlyAvailable = document.getElementById('filter-available').checked;
            const onlyOnLoan = document.getElementById('filter-onloan').checked;

            filteredBooks = allBooks.filter(book => {
                const category = (book.category || 'Uncategorized').trim();
                const status = getStatus(book);
                const haystack = [book.title, book.author, book.isbn, book.category, book.description].map(normalize).join(' ');
                const matchesCategory = activeCategory === 'all' || category === activeCategory;
                const matchesSearch = !q || haystack.includes(q);
                const matchesAvail = (!onlyAvailable && !onlyOnLoan)
                    || (onlyAvailable && status === 'AVAILABLE')
                    || (onlyOnLoan && status === 'ON LOAN');
                return matchesCategory && matchesSearch && matchesAvail;
            });

            if (activeQuick === 'available') filteredBooks = filteredBooks.filter(book => getStatus(book) === 'AVAILABLE');
            if (activeQuick === 'onloan') filteredBooks = filteredBooks.filter(book => getStatus(book) === 'ON LOAN');

            filteredBooks = sortBooks(filteredBooks);
            renderBooks();
            updateHeading(activeCategory === 'all' ? 'All Books' : activeCategory);
        }

        function renderBooks() {
            const grid = document.getElementById('book-grid');
            const empty = document.getElementById('empty-state');
            const pagination = document.getElementById('pagination-row');
            const total = filteredBooks.length;
            const totalPages = Math.max(1, Math.ceil(total / perPage));
            if (currentPage > totalPages) currentPage = totalPages;

            const start = (currentPage - 1) * perPage;
            const pageBooks = filteredBooks.slice(start, start + perPage);

            if (!pageBooks.length) {
                grid.innerHTML = '';
                empty.style.display = 'block';
                pagination.style.display = 'none';
                return;
            }

            empty.style.display = 'none';
            pagination.style.display = total > perPage ? 'flex' : 'none';
            grid.innerHTML = pageBooks.map((book, idx) => {
                const globalIndex = start + idx;
                const status = getStatus(book);
                const badgeClass = status === 'AVAILABLE' ? '' : 'loan';
                return `
                    <article class="book-card" data-index="${globalIndex}">
                        <div class="book-cover">
                            <div class="book-badge ${badgeClass}">${status}</div>
                            ${coverMarkup(book, globalIndex)}
                        </div>
                        <div class="book-body">
                            <div class="book-category">${escapeHtml(book.category || 'Uncategorized')}</div>
                            <div class="book-title">${escapeHtml(book.title || 'Untitled')}</div>
                            <div class="book-author">${escapeHtml(book.author || '-')}</div>
                            <div class="book-meta">
                                <span>Year: <strong>${escapeHtml(book.published_year || '-')}</strong></span>
                                <span>Stock: <strong>${Number(book.stock || 0)}</strong></span>
                            </div>
                        </div>
                    </article>
                `;
            }).join('');

            document.getElementById('page-info').textContent = total
                ? `Showing ${start + 1} to ${Math.min(start + perPage, total)} of ${total.toLocaleString()} books`
                : 'Showing 0 books';

            document.querySelectorAll('.book-card').forEach(card => {
                card.addEventListener('click', () => {
                    const index = Number(card.dataset.index);
                    const book = filteredBooks[index];
                    if (book) openBookModal(book, index);
                });
            });

            const btns = [];
            if (totalPages > 1) {
                for (let i = 1; i <= totalPages; i++) btns.push(`<button class="page-btn ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`);
            }
            document.getElementById('pagination-btns').innerHTML = btns.join('');
            document.querySelectorAll('.page-btn').forEach(btn => btn.addEventListener('click', () => {
                currentPage = Number(btn.dataset.page);
                renderBooks();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }));
        }

        document.getElementById('search-input').addEventListener('input', () => { currentPage = 1; applyFilters(); });
        document.getElementById('sort-select').addEventListener('change', () => { currentPage = 1; applyFilters(); });
        document.getElementById('filter-available').addEventListener('change', () => {
            currentPage = 1;
            document.getElementById('filter-onloan').checked = false;
            activeQuick = 'all';
            document.querySelectorAll('.tab-chip').forEach(chip => chip.classList.remove('active'));
            document.querySelector('.tab-chip[data-sortquick="all"]').classList.add('active');
            applyFilters();
        });
        document.getElementById('filter-onloan').addEventListener('change', () => {
            currentPage = 1;
            document.getElementById('filter-available').checked = false;
            activeQuick = 'all';
            document.querySelectorAll('.tab-chip').forEach(chip => chip.classList.remove('active'));
            document.querySelector('.tab-chip[data-sortquick="all"]').classList.add('active');
            applyFilters();
        });
        document.querySelectorAll('.tab-chip').forEach(chip => chip.addEventListener('click', () => {
            document.querySelectorAll('.tab-chip').forEach(btn => btn.classList.remove('active'));
            chip.classList.add('active');
            activeQuick = chip.dataset.sortquick;
            currentPage = 1;
            document.getElementById('filter-available').checked = false;
            document.getElementById('filter-onloan').checked = false;
            applyFilters();
        }));

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeBookModal();
        });

        renderCategories();
        applyFilters();
    </script>
    @endpush
</x-app-layout>
