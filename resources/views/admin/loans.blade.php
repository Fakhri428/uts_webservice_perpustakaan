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
                                <th class="px-4 py-2 text-left text-xs">ID</th>
                                <th class="px-4 py-2 text-left text-xs">Book</th>
                                <th class="px-4 py-2 text-left text-xs">User</th>
                                <th class="px-4 py-2 text-left text-xs">Borrowed At</th>
                                <th class="px-4 py-2 text-left text-xs">Due At</th>
                                <th class="px-4 py-2 text-left text-xs">Returned At</th>
                                <th class="px-4 py-2 text-left text-xs">Status</th>
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

    async function fetchLoans(){
        try {
            console.log('🔄 Fetching loans...');
            const res = await fetch('/api/loans', {
                credentials: 'include'
            });
            if (!res.ok) throw new Error(`HTTP ${res.status}: ${res.statusText}`);
            const data = await res.json();
            const loans = data.data || data;
            const tbody = document.querySelector('#loans-table tbody');
            tbody.innerHTML = '';

            if (!Array.isArray(loans)) {
                console.error('❌ Loans is not array:', typeof loans);
                tbody.innerHTML = '<tr><td colspan="8" class="px-4 py-2 text-center text-red-600">Invalid data format</td></tr>';
                return;
            }

            console.log('✓ Loans fetched:', loans.length, 'items');
            loans.forEach((l, idx) => {
                const tr = document.createElement('tr');
                const statusBadge = l.status === 'returned' ? '<span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Returned</span>' : 
                                   l.status === 'overdue' ? '<span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Overdue</span>' :
                                   '<span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">Borrowed</span>';
                
                tr.innerHTML = `
                    <td class="px-4 py-2 text-sm">${l.id}</td>
                    <td class="px-4 py-2 text-sm">${l.book ? l.book.title : '-'}</td>
                    <td class="px-4 py-2 text-sm">${l.user ? l.user.name : '-'}</td>
                    <td class="px-4 py-2 text-sm">${l.borrowed_at ? new Date(l.borrowed_at).toLocaleDateString() : '-'}</td>
                    <td class="px-4 py-2 text-sm">${l.due_at ? new Date(l.due_at).toLocaleDateString() : '-'}</td>
                    <td class="px-4 py-2 text-sm">${l.returned_at ? new Date(l.returned_at).toLocaleDateString() : '-'}</td>
                    <td class="px-4 py-2 text-sm">${statusBadge}</td>
                    <td class="px-4 py-2 space-x-2 text-xs">
                        ${l.status !== 'returned' ? `<button data-id="${l.id}" class="ret bg-green-600 text-white px-2 py-1 rounded text-xs">Mark Returned</button>` : ''}
                    </td>`;
                tbody.appendChild(tr);
                if (idx === 0) console.log('✓ Loan row created:', l.id);
            });
            console.log('✓ All loan rows added to table');
        } catch (error) {
            console.error('❌ Error fetching loans:', error);
            document.querySelector('#loans-table tbody').innerHTML = '<tr><td colspan="8" class="px-4 py-2 text-center text-red-600">Error: ' + error.message + '</td></tr>';
        }
    }

    document.addEventListener('click', async (e) => {
        if (e.target.matches('.ret')) {
            try {
                const res = await fetch('/api/loans/' + e.target.dataset.id, {
                    method: 'PUT',
                    credentials: 'include',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ returned_at: new Date().toISOString(), status: 'returned' })
                });
                if (!res.ok) throw new Error('Failed to mark return');
                fetchLoans();
            } catch (error) {
                console.error('Error marking return:', error);
                alert('Error marking return: ' + error.message);
            }
        }
    });

    fetchLoans();
    </script>
    @endpush
</x-app-layout>
