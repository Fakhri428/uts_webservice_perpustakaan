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
                    <form id="book-form" class="space-y-3">
                        <div class="grid grid-cols-1 md:grid-cols-7 gap-2">
                            <input name="title" placeholder="Title *" required class="border rounded px-3 py-2 text-sm">
                            <input name="author" placeholder="Author" class="border rounded px-3 py-2 text-sm">
                            <input name="category" placeholder="Category" class="border rounded px-3 py-2 text-sm">
                            <input name="published_year" type="number" placeholder="Year" class="border rounded px-3 py-2 text-sm">
                            <input name="isbn" placeholder="ISBN" class="border rounded px-3 py-2 text-sm">
                            <input name="stock" type="number" placeholder="Stock" value="1" class="border rounded px-3 py-2 text-sm">
                            <input name="image" type="file" accept="image/*" class="border rounded px-3 py-2 bg-white text-sm">
                        </div>
                        <textarea name="description" placeholder="Description" class="w-full border rounded px-3 py-2 text-sm h-20"></textarea>
                        <button type="submit" class="bg-blue-600 text-white rounded px-4 py-2 text-sm">Create Book</button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table id="books-table" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs">ID</th>
                                <th class="px-4 py-2 text-left text-xs">Cover</th>
                                <th class="px-4 py-2 text-left text-xs">Title</th>
                                <th class="px-4 py-2 text-left text-xs">Author</th>
                                <th class="px-4 py-2 text-left text-xs">Category</th>
                                <th class="px-4 py-2 text-left text-xs">Year</th>
                                <th class="px-4 py-2 text-left text-xs">ISBN</th>
                                <th class="px-4 py-2 text-left text-xs">Stock</th>
                                <th class="px-4 py-2 text-left text-xs">Desc</th>
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
    // Get CSRF token from meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    async function fetchBooks(){
        try {
            console.log('🔄 Fetching books...');
            const res = await fetch('/api/books', {
                credentials: 'include'
            });
            if (!res.ok) throw new Error(`HTTP ${res.status}: ${res.statusText}`);
            const data = await res.json();
            const books = data.data || data;
            console.log('✓ Books fetched:', books.length, 'items');
            
            const tbody = document.querySelector('#books-table tbody');
            tbody.innerHTML = '';
            
            if (!Array.isArray(books)) {
                console.error('❌ Books is not array:', typeof books);
                tbody.innerHTML = '<tr><td colspan="10" class="px-4 py-2 text-center text-red-600">Invalid data format</td></tr>';
                return;
            }
            
            console.log('📊 Creating rows for', books.length, 'books');
            books.forEach((b, idx) => {
                const tr = document.createElement('tr');
                const imageUrl = b.image ? `/storage/${b.image}` : 'https://via.placeholder.com/60x80?text=No+Cover';
                const descShort = b.description ? b.description.substring(0, 50) + '...' : '-';
                tr.innerHTML = `
                    <td class="px-4 py-2 text-sm">${b.id}</td>
                    <td class="px-4 py-2"><img src="${imageUrl}" alt="${b.title}" class="w-12 h-16 object-cover rounded border"></td>
                    <td class="px-4 py-2 text-sm font-medium">${b.title}</td>
                    <td class="px-4 py-2 text-sm">${b.author || '-'}</td>
                    <td class="px-4 py-2 text-sm"><span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">${b.category || '-'}</span></td>
                    <td class="px-4 py-2 text-sm">${b.published_year || '-'}</td>
                    <td class="px-4 py-2 text-sm font-mono text-xs text-gray-600">${b.isbn || '-'}</td>
                    <td class="px-4 py-2 text-sm" data-stock="${b.stock}"><span class="font-semibold ${b.stock > 0 ? 'text-green-600' : 'text-red-600'}">${b.stock || 0}</span></td>
                    <td class="px-4 py-2 text-xs text-gray-600 truncate" title="${b.description || '-'}">${descShort}</td>
                    <td class="px-4 py-2 space-x-2 text-xs">
                        <button data-id="${b.id}" class="inc bg-green-600 text-white px-2 py-1 rounded text-xs">+1</button>
                        <button data-id="${b.id}" class="del bg-red-600 text-white px-2 py-1 rounded text-xs">Del</button>
                    </td>`;
                tbody.appendChild(tr);
                if (idx === 0) console.log('✓ Row created:', b.title);
            });
            console.log('✓ All rows added to table');
        } catch (error) {
            console.error('❌ Error fetching books:', error);
            document.querySelector('#books-table tbody').innerHTML = '<tr><td colspan="10" class="px-4 py-2 text-center text-red-600">Error: ' + error.message + '</td></tr>';
        }
    }

    const form = document.getElementById('book-form');
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        try {
            const payload = new FormData();
            payload.append('title', form.title.value);
            payload.append('author', form.author.value);
            payload.append('category', form.category.value);
            payload.append('description', form.description.value);
            payload.append('published_year', form.published_year.value || null);
            payload.append('isbn', form.isbn.value || null);
            payload.append('stock', parseInt(form.stock.value || '1'));
            if (form.image.files[0]) {
                payload.append('image', form.image.files[0]);
            }

            const res = await fetch('/api/books', {
                method: 'POST',
                credentials: 'include',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: payload
            });
            
            if (!res.ok) {
                const error = await res.json();
                throw new Error(error.message || 'Failed to create book');
            }

            form.reset();
            fetchBooks();
        } catch (error) {
            console.error('Error creating book:', error);
            alert('Error creating book: ' + error.message);
        }
    });

    document.addEventListener('click', async (e) => {
        if (e.target.matches('.del')) {
            if (!confirm('Delete this book?')) return;
            try {
                const res = await fetch('/api/books/' + e.target.dataset.id, {
                    method: 'DELETE',
                    credentials: 'include',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                if (!res.ok) throw new Error('Failed to delete');
                fetchBooks();
            } catch (error) {
                console.error('Error deleting book:', error);
                alert('Error deleting book: ' + error.message);
            }
        }

        if (e.target.matches('.inc')) {
            try {
                const row = e.target.closest('tr');
                const stockCell = row.querySelector('[data-stock]');
                const next = parseInt(stockCell.textContent || '0') + 1;
                const res = await fetch('/api/books/' + e.target.dataset.id, {
                    method: 'PUT',
                    credentials: 'include',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ stock: next })
                });
                if (!res.ok) throw new Error('Failed to update stock');
                fetchBooks();
            } catch (error) {
                console.error('Error updating stock:', error);
                alert('Error updating stock: ' + error.message);
            }
        }
    });

    fetchBooks();
    </script>
    @endpush
</x-app-layout>
