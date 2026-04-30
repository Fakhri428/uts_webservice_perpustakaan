<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin - Categories</h2>
    </x-slot>

    <style>
        .cat-shell { display: grid; grid-template-columns: 300px minmax(0, 1fr); gap: 24px; }
        .cat-panel, .cat-main { background: #fff; border: 1px solid #e5e7eb; border-radius: 20px; box-shadow: 0 10px 25px rgba(15, 23, 42, 0.04); }
        .cat-panel { padding: 20px; position: sticky; top: 92px; height: fit-content; }
        .cat-title { font-size: 11px; letter-spacing: 1.5px; text-transform: uppercase; color: #94a3b8; font-weight: 800; margin-bottom: 12px; }
        .cat-list { display: grid; gap: 10px; }
        .cat-item { padding: 12px 14px; border-radius: 14px; background: #f8fafc; border: 1px solid transparent; }
        .cat-item strong { display: block; color: #0f172a; font-size: 14px; }
        .cat-item span { color: #64748b; font-size: 12px; }
        .cat-main { padding: 24px; }
        .cat-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .cat-input { width: 100%; border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px 12px; font-size: 14px; }
        .cat-input:focus { outline: none; border-color: #93c5fd; box-shadow: 0 0 0 3px rgba(59,130,246,.12); }
        .cat-btn { background: #2563eb; color: #fff; border: 0; border-radius: 12px; padding: 10px 14px; font-size: 14px; font-weight: 700; cursor: pointer; }
        .cat-table { width: 100%; border-collapse: collapse; }
        .cat-table th, .cat-table td { padding: 12px 10px; border-bottom: 1px solid #eef2f7; text-align: left; font-size: 13px; vertical-align: top; }
        .cat-badge { display: inline-flex; align-items: center; gap: 6px; background: #eff6ff; color: #1d4ed8; border-radius: 999px; padding: 4px 10px; font-size: 11px; font-weight: 700; }
        .cat-actions { display: flex; gap: 8px; flex-wrap: wrap; }
        .cat-actions button { border: 0; border-radius: 10px; padding: 7px 10px; font-size: 12px; font-weight: 700; cursor: pointer; }
        .cat-actions .edit { background: #f59e0b; color: #fff; }
        .cat-actions .del { background: #dc2626; color: #fff; }
        @media (max-width: 960px) { .cat-shell { grid-template-columns: 1fr; } .cat-panel { position: static; } .cat-form-grid { grid-template-columns: 1fr; } }
    </style>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="cat-shell">
                <aside class="cat-panel">
                    <div class="cat-title">Category Summary</div>
                    <div class="cat-list" id="cat-summary">
                        <div class="cat-item">
                            <strong id="cat-total">0 categories</strong>
                            <span>Total master data kategori</span>
                        </div>
                        <div class="cat-item">
                            <strong>Admin only</strong>
                            <span>Create, edit, and delete categories</span>
                        </div>
                    </div>
                </aside>

                <section class="cat-main">
                    <div class="flex items-center justify-between mb-6">
                        <a href="{{ route('admin.dashboard') }}" class="text-sm text-blue-600">Back to dashboard</a>
                        <span class="text-sm text-gray-500">Manage category master data</span>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-lg font-medium mb-3">Add Category</h3>
                        <form id="category-form" class="space-y-3">
                            <div class="cat-form-grid">
                                <input name="name" placeholder="Category name *" required class="cat-input">
                                <input name="description" placeholder="Description" class="cat-input">
                            </div>
                            <button type="submit" class="cat-btn">Create Category</button>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table id="categories-table" class="cat-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    let categoryCount = 0;

    async function fetchCategories(){
        try {
            const res = await fetch('/api/categories', { credentials: 'include' });
            if (!res.ok) throw new Error(`HTTP ${res.status}: ${res.statusText}`);
            const data = await res.json();
            const categories = data.data || data;
            const tbody = document.querySelector('#categories-table tbody');
            tbody.innerHTML = '';

            if (!Array.isArray(categories)) {
                tbody.innerHTML = '<tr><td colspan="4" class="px-4 py-2 text-center text-red-600">Invalid data format</td></tr>';
                return;
            }

            categoryCount = categories.length;
            document.getElementById('cat-total').textContent = `${categoryCount} categories`;

            categories.forEach((c) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="px-4 py-2 text-sm">${c.id}</td>
                    <td class="px-4 py-2 text-sm font-medium">${c.name}</td>
                    <td class="px-4 py-2 text-sm">${c.description || '-'}</td>
                    <td class="px-4 py-2 space-x-2 text-xs">
                        <div class="cat-actions">
                            <button data-id="${c.id}" class="edit">Edit</button>
                            <button data-id="${c.id}" class="del">Delete</button>
                        </div>
                    </td>`;
                tbody.appendChild(tr);
            });
        } catch (error) {
            document.querySelector('#categories-table tbody').innerHTML = '<tr><td colspan="4" class="px-4 py-2 text-center text-red-600">Error: ' + error.message + '</td></tr>';
        }
    }

    const form = document.getElementById('category-form');
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        try {
            const payload = {
                name: form.name.value,
                description: form.description.value,
            };

            const res = await fetch('/api/categories', {
                method: 'POST',
                credentials: 'include',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            if (!res.ok) {
                const error = await res.json();
                throw new Error(error.message || 'Failed to create category');
            }

            form.reset();
            fetchCategories();
        } catch (error) {
            alert('Error creating category: ' + error.message);
        }
    });

    document.addEventListener('click', async (e) => {
        if (e.target.matches('.del')) {
            if (!confirm('Delete this category?')) return;
            const res = await fetch('/api/categories/' + e.target.dataset.id, {
                method: 'DELETE',
                credentials: 'include',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });
            if (!res.ok) {
                const error = await res.json();
                alert('Error deleting category: ' + (error.message || 'Failed'));
                return;
            }
            fetchCategories();
        }

        if (e.target.matches('.edit')) {
            const currentName = prompt('New category name:');
            if (!currentName) return;
            const currentDesc = prompt('New description:') || '';

            const res = await fetch('/api/categories/' + e.target.dataset.id, {
                method: 'PUT',
                credentials: 'include',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ name: currentName, description: currentDesc })
            });

            if (!res.ok) {
                const error = await res.json();
                alert('Error updating category: ' + (error.message || 'Failed'));
                return;
            }
            fetchCategories();
        }
    });

    fetchCategories();
    </script>
    @endpush
</x-app-layout>