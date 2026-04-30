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
                                <th class="px-4 py-2 text-left">ID</th>
                                <th class="px-4 py-2 text-left">Cover</th>
                                <th class="px-4 py-2 text-left">Title</th>
                                <th class="px-4 py-2 text-left">Author</th>
                                <th class="px-4 py-2 text-left">Category</th>
                                <th class="px-4 py-2 text-left">Stock</th>
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
                <td class="px-4 py-2">${b.stock || 0}</td>`;
            tbody.appendChild(tr);
        });
    }

    fetchBooks();
    </script>
    @endpush
</x-app-layout>
