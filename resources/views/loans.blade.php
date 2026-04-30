<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Loans</title>
    <style>body{font-family:Arial,Helvetica,sans-serif;margin:20px;}table{border-collapse:collapse;width:100%}td,th{border:1px solid #ddd;padding:8px}</style>
</head>
<body>
    <h1>Loans</h1>
    <p><a href="/dashboard">Back</a></p>

    <h2>Create Loan</h2>
    <form id="loan-form">
        <input name="book_id" placeholder="Book ID" required>
        <input name="user_id" placeholder="User ID (optional)">
        <input name="due_at" type="date" placeholder="Due date">
        <button type="submit">Borrow</button>
    </form>

    <h2>Active Loans</h2>
    <table id="loans-table">
        <thead><tr><th>ID</th><th>Book</th><th>User</th><th>Borrowed At</th><th>Due At</th><th>Actions</th></tr></thead>
        <tbody></tbody>
    </table>

    <script>
    async function fetchLoans(){
        const res = await fetch('/api/loans');
        const data = await res.json();
        const tbody = document.querySelector('#loans-table tbody');
        tbody.innerHTML = '';
        (data.data || data).forEach(l=>{
            const tr = document.createElement('tr');
            tr.innerHTML = `<td>${l.id}</td><td>${l.book?l.book.title:'-'}</td><td>${l.user?l.user.name:'-'}</td><td>${l.borrowed_at||''}</td><td>${l.due_at||''}</td><td><button data-id="${l.id}" class="ret">Mark Returned</button></td>`;
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
</body>
</html>
