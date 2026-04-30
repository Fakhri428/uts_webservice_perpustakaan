<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Books</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="mb-4">
                    <a href="/dashboard" class="text-sm text-blue-600">Back</a>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-medium">Add Book</h3>
                    <form id="book-form" class="flex gap-2 mt-2">
                        <input name="title" placeholder="Title" required class="border rounded px-2 py-1 flex-1">
                        <input name="author" placeholder="Author" class="border rounded px-2 py-1">
                        <input name="category" placeholder="Category" class="border rounded px-2 py-1">
                        <input name="stock" type="number" placeholder="Stock" value="1" class="w-20 border rounded px-2 py-1">
                        <button type="submit" class="bg-blue-600 text-white rounded px-3">Create</button>
                    </form>
                </div>

                <div>
                    <h3 class="text-lg font-medium mb-2">Catalog</h3>
                    <div class="overflow-x-auto">
                        <table id="books-table" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50"><tr><th class="px-4 py-2">ID</th><th class="px-4 py-2">Title</th><th class="px-4 py-2">Author</th><th class="px-4 py-2">Category</th><th class="px-4 py-2">Stock</th><th class="px-4 py-2">Actions</th></tr></thead>
                            <tbody class="bg-white divide-y divide-gray-200"></tbody>
                        </table>
                    </div>
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
        (data.data || data).forEach(b=>{
            const tr = document.createElement('tr');
            tr.innerHTML = `<td class="px-4 py-2">${b.id}</td><td class="px-4 py-2">${b.title}</td><td class="px-4 py-2">${b.author||''}</td><td class="px-4 py-2">${b.category||''}</td><td class="px-4 py-2">${b.stock||0}</td><td class="px-4 py-2"><button data-id="${b.id}" class="del bg-red-500 text-white px-2 rounded">Delete</button></td>`;
            tbody.appendChild(tr);
        });
    }

    document.getElementById('book-form').addEventListener('submit', async (e)=>{
        e.preventDefault();
        const form = e.target;
        const payload = { title: form.title.value, author: form.author.value, category: form.category.value, stock: parseInt(form.stock.value||1) };
        await fetch('/api/books', { method: 'POST', headers: {'Content-Type':'application/json'}, body: JSON.stringify(payload)});
        form.reset();
        fetchBooks();
    });

    document.addEventListener('click', async (e)=>{
        if(e.target.matches('.del')){
            const id = e.target.dataset.id;
            await fetch('/api/books/'+id, { method: 'DELETE' });
            fetchBooks();
        }
    });

    fetchBooks();
    </script>
    @endpush
</x-app-layout>
