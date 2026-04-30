<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin - Loans</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <a href="{{ route('admin.dashboard') }}" class="text-sm text-blue-600">Back to dashboard</a>
                    <span class="text-sm text-gray-500">Admin can monitor all loans and mark returns</span>
                </div>

                <div class="overflow-x-auto">
                    <table id="loans-table" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">ID</th>
                                <th class="px-4 py-2 text-left">Book</th>
                                <th class="px-4 py-2 text-left">User</th>
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
                <td class="px-4 py-2">${l.user ? l.user.name : '-'}</td>
                <td class="px-4 py-2">${l.borrowed_at || ''}</td>
                <td class="px-4 py-2">${l.due_at || ''}</td>
                <td class="px-4 py-2">
                    <button data-id="${l.id}" class="ret bg-green-600 text-white px-3 py-1 rounded">Mark Returned</button>
                </td>`;
            tbody.appendChild(tr);
        });
    }

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
