<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Loans</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <a href="{{ route('user.dashboard') }}" class="text-sm text-blue-600">Back to dashboard</a>
                    <span class="text-sm text-gray-500">User can borrow and return own books</span>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium mb-2">Borrow a Book</h3>
                <form id="loan-form" class="grid grid-cols-1 md:grid-cols-4 gap-2">
                    <input name="book_id" placeholder="Book ID" required class="border rounded px-3 py-2">
                    <input name="due_at" type="date" class="border rounded px-3 py-2">
                    <button type="submit" class="bg-blue-600 text-white rounded px-4 py-2 md:col-span-2">Borrow</button>
                </form>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium mb-2">My Active Loans</h3>
                <div class="overflow-x-auto">
                    <table id="loans-table" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">ID</th>
                                <th class="px-4 py-2 text-left">Book</th>
                                <th class="px-4 py-2 text-left">Borrowed At</th>
                                <th class="px-4 py-2 text-left">Due At</th>
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
    async function fetchLoans(){
        const res = await fetch('/api/loans');
        const data = await res.json();
        const tbody = document.querySelector('#loans-table tbody');
        tbody.innerHTML = '';

        (data.data || data).forEach(l => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="px-4 py-2">${l.id}</td>
                <td class="px-4 py-2">${l.book ? l.book.title : '-'}</td>
                <td class="px-4 py-2">${l.borrowed_at || ''}</td>
                <td class="px-4 py-2">${l.due_at || ''}</td>
                <td class="px-4 py-2"><button data-id="${l.id}" class="ret bg-green-600 text-white px-3 py-1 rounded">Return</button></td>`;
            tbody.appendChild(tr);
        });
    }

    document.getElementById('loan-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const form = e.target;
        await fetch('/api/loans', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                book_id: parseInt(form.book_id.value),
                due_at: form.due_at.value || null
            })
        });
        form.reset();
        fetchLoans();
    });

    document.addEventListener('click', async (e) => {
        if (e.target.matches('.ret')) {
            await fetch('/api/loans/' + e.target.dataset.id, {
                method: 'PUT',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ returned_at: new Date().toISOString(), status: 'returned' })
            });
            fetchLoans();
        }
    });

    fetchLoans();
    </script>
    @endpush
</x-app-layout>
