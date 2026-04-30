<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Loans</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="mb-4">
                    <a href="/dashboard" class="text-sm text-blue-600">Back</a>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-medium">Create Loan</h3>
                    <form id="loan-form" class="flex gap-2 mt-2">
                        <input name="book_id" placeholder="Book ID" required class="border rounded px-2 py-1 w-32">
                        <input name="user_id" placeholder="User ID (optional)" class="border rounded px-2 py-1">
                        <input name="due_at" type="date" placeholder="Due date" class="border rounded px-2 py-1">
                        <button type="submit" class="bg-blue-600 text-white rounded px-3">Borrow</button>
                    </form>
                </div>

                <div>
                    <h3 class="text-lg font-medium mb-2">Active Loans</h3>
                    <div class="overflow-x-auto">
                        <table id="loans-table" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50"><tr><th class="px-4 py-2">ID</th><th class="px-4 py-2">Book</th><th class="px-4 py-2">User</th><th class="px-4 py-2">Borrowed At</th><th class="px-4 py-2">Due At</th><th class="px-4 py-2">Actions</th></tr></thead>
                            <tbody class="bg-white divide-y divide-gray-200"></tbody>
                        </table>
                    </div>
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
        (data.data || data).forEach(l=>{
            const tr = document.createElement('tr');
            tr.innerHTML = `<td class="px-4 py-2">${l.id}</td><td class="px-4 py-2">${l.book?l.book.title:'-'}</td><td class="px-4 py-2">${l.user?l.user.name:'-'}</td><td class="px-4 py-2">${l.borrowed_at||''}</td><td class="px-4 py-2">${l.due_at||''}</td><td class="px-4 py-2"><button data-id="${l.id}" class="ret bg-green-600 text-white px-2 rounded">Mark Returned</button></td>`;
            tbody.appendChild(tr);
        });
    }

    document.getElementById('loan-form').addEventListener('submit', async (e)=>{
        e.preventDefault();
        const form = e.target;
        const payload = { book_id: parseInt(form.book_id.value), user_id: form.user_id.value || null, due_at: form.due_at.value || null };
        await fetch('/api/loans', { method: 'POST', headers: {'Content-Type':'application/json'}, body: JSON.stringify(payload)});
        form.reset();
        fetchLoans();
    });

    document.addEventListener('click', async (e)=>{
        if(e.target.matches('.ret')){
            const id = e.target.dataset.id;
            await fetch('/api/loans/'+id, { method: 'PUT', headers: {'Content-Type':'application/json'}, body: JSON.stringify({ returned_at: new Date().toISOString(), status: 'returned' }) });
            fetchLoans();
        }
    });

    fetchLoans();
    </script>
    @endpush
</x-app-layout>
