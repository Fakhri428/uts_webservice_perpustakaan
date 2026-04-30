<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin - Categories</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-6">
                <div class="flex items-center justify-between">
                    <a href="{{ route('admin.dashboard') }}" class="text-sm text-blue-600">Back to dashboard</a>
                    <span class="text-sm text-gray-500">Manage category master data</span>
                </div>

                <div>
                    <h3 class="text-lg font-medium mb-2">Add Category</h3>
                    <form id="category-form" class="space-y-3">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            <input name="name" placeholder="Category name *" required class="border rounded px-3 py-2 text-sm">
                            <input name="description" placeholder="Description" class="border rounded px-3 py-2 text-sm">
                        </div>
                        <button type="submit" class="bg-blue-600 text-white rounded px-4 py-2 text-sm">Create Category</button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table id="categories-table" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs">ID</th>
                                <th class="px-4 py-2 text-left text-xs">Name</th>
                                <th class="px-4 py-2 text-left text-xs">Description</th>
                                <th class="px-4 py-2 text-left text-xs">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

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

            categories.forEach((c) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="px-4 py-2 text-sm">${c.id}</td>
                    <td class="px-4 py-2 text-sm font-medium">${c.name}</td>
                    <td class="px-4 py-2 text-sm">${c.description || '-'}</td>
                    <td class="px-4 py-2 space-x-2 text-xs">
                        <button data-id="${c.id}" class="edit bg-yellow-500 text-white px-2 py-1 rounded text-xs">Edit</button>
                        <button data-id="${c.id}" class="del bg-red-600 text-white px-2 py-1 rounded text-xs">Delete</button>
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