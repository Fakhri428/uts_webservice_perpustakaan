<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Browse Books</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <a href="{{ route('user.dashboard') }}" class="text-sm text-blue-600">Back to dashboard</a>
                    <span class="text-sm text-gray-500">User can only view books</span>
                </div>

                <div class="overflow-x-auto">
                    <table id="books-table" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-semibold">ID</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold">Cover</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold">Title</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold">Author</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold">Category</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold">Year</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold">ISBN</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold">Stock</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold">Desc</th>
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
        try {
            console.log('🔄 Fetching books from {{ url('/api/books') }}...');
            const apiUrl = '{{ url('/api/books') }}';
            console.log('📍 API URL:', apiUrl);
            const res = await fetch(apiUrl, {
                credentials: 'include',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });
            if (!res.ok) throw new Error(`HTTP ${res.status}: ${res.statusText}`);
            const data = await res.json();
            const books = data.data || data;
            const tbody = document.querySelector('#books-table tbody');
            tbody.innerHTML = '';

            if (!Array.isArray(books)) {
                console.error('❌ Books is not array:', typeof books);
                tbody.innerHTML = '<tr><td colspan="9" class="px-4 py-2 text-center text-red-600">Invalid data format</td></tr>';
                return;
            }

            console.log('✓ Books fetched:', books.length, 'items');
            books.forEach((b, idx) => {
                const tr = document.createElement('tr');
                const imageUrl = b.image ? `/storage/${b.image}` : 'https://via.placeholder.com/60x80?text=No+Cover';
                const descShort = b.description ? b.description.substring(0, 50) + '...' : '-';
                tr.innerHTML = `
                    <td class="px-4 py-2 text-sm">${b.id}</td>
                    <td class="px-4 py-2"><img src="${imageUrl}" alt="${b.title}" class="w-14 h-20 object-cover rounded border"></td>
                    <td class="px-4 py-2 font-medium">${b.title}</td>
                    <td class="px-4 py-2 text-sm">${b.author || '-'}</td>
                    <td class="px-4 py-2 text-sm"><span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">${b.category || '-'}</span></td>
                    <td class="px-4 py-2 text-sm">${b.published_year || '-'}</td>
                    <td class="px-4 py-2 text-sm font-mono text-xs text-gray-600">${b.isbn || '-'}</td>
                    <td class="px-4 py-2 text-sm"><span class="font-semibold ${b.stock > 0 ? 'text-green-600' : 'text-red-600'}">${b.stock || 0}</span></td>
                    <td class="px-4 py-2 text-xs text-gray-600 truncate" title="${b.description || '-'}">${descShort}</td>`;
                tbody.appendChild(tr);
                if (idx === 0) console.log('✓ Row created:', b.title);
            });
            console.log('✓ All rows added to table');
        } catch (error) {
            console.error('❌ Error fetching books:', error);
            document.querySelector('#books-table tbody').innerHTML = '<tr><td colspan="9" class="px-4 py-2 text-center text-red-600">Error: ' + error.message + '</td></tr>';
        }
    }

    fetchBooks();
    </script>
    @endpush
</x-app-layout>
