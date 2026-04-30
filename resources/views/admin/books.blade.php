<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin - Books</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-6">
                <div class="flex items-center justify-between">
                    <a href="{{ route('admin.dashboard') }}" class="text-sm text-blue-600">Back to dashboard</a>
                    <span class="text-sm text-gray-500">Admin can add, update, and delete books</span>
                </div>

                <div>
                    <h3 class="text-lg font-medium mb-2">Add Book</h3>
                    <form id="book-form" class="grid grid-cols-1 md:grid-cols-6 gap-2">
                        <input name="title" placeholder="Title" required class="border rounded px-3 py-2">
                        <input name="author" placeholder="Author" class="border rounded px-3 py-2">
                        <input name="category" placeholder="Category" class="border rounded px-3 py-2">
                        <input name="stock" type="number" placeholder="Stock" value="1" class="border rounded px-3 py-2">
                        <input name="image" type="file" accept="image/*" class="border rounded px-3 py-2 bg-white">
                        <button type="submit" class="bg-blue-600 text-white rounded px-4 py-2">Create</button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table id="books-table" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">ID</th>
                                <th class="px-4 py-2 text-left">Cover</th>
                                <th class="px-4 py-2 text-left">Title</th>
                                <th class="px-4 py-2 text-left">Author</th>
                                <th class="px-4 py-2 text-left">Category</th>
                                <th class="px-4 py-2 text-left">Stock</th>
                                <th class="px-4 py-2 text-left">Actions</th>
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
    async function fetchBooks(){
        const res = await fetch('/api/books');
        const data = await res.json();
        const tbody = document.querySelector('#books-table tbody');
        tbody.innerHTML = '';
        (data.data || data).forEach(b => {
            const tr = document.createElement('tr');
            const imageUrl = b.image ? `/storage/${b.image}` : 'https://via.placeholder.com/60x80?text=No+Cover';
            tr.innerHTML = `
                <td class="px-4 py-2">${b.id}</td>
                <td class="px-4 py-2"><img src="${imageUrl}" alt="${b.title}" class="w-14 h-20 object-cover rounded border"></td>
                <td class="px-4 py-2">${b.title}</td>
                <td class="px-4 py-2">${b.author || ''}</td>
                <td class="px-4 py-2">${b.category || ''}</td>
                <td class="px-4 py-2" data-stock>${b.stock || 0}</td>
                <td class="px-4 py-2 space-x-2">
                    <button data-id="${b.id}" class="inc bg-green-600 text-white px-3 py-1 rounded">+1 stock</button>
                    <button data-id="${b.id}" class="del bg-red-600 text-white px-3 py-1 rounded">Delete</button>
                </td>`;
            tbody.appendChild(tr);
        });
    }

    const form = document.getElementById('book-form');
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const payload = new FormData();
        payload.append('title', form.title.value);
        payload.append('author', form.author.value);
        payload.append('category', form.category.value);
        payload.append('stock', parseInt(form.stock.value || '1'));
        if (form.image.files[0]) {
            payload.append('image', form.image.files[0]);
        }

        await fetch('/api/books', {
            method: 'POST',
            body: payload
        });

        form.reset();
        fetchBooks();
    });

    document.addEventListener('click', async (e) => {
        if (e.target.matches('.del')) {
            await fetch('/api/books/' + e.target.dataset.id, { method: 'DELETE' });
            fetchBooks();
        }

        if (e.target.matches('.inc')) {
            const row = e.target.closest('tr');
            const stockCell = row.querySelector('[data-stock]');
            const next = parseInt(stockCell.textContent || '0') + 1;
            await fetch('/api/books/' + e.target.dataset.id, {
                method: 'PUT',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ stock: next })
            });
            fetchBooks();
        }
    });

    fetchBooks();
    </script>
    @endpush
</x-app-layout>
