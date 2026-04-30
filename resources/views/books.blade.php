<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Books</title>
    <style>body{font-family:Arial,Helvetica,sans-serif;margin:20px;}table{border-collapse:collapse;width:100%}td,th{border:1px solid #ddd;padding:8px}</style>
</head>
<body>
    <h1>Books</h1>
    <p><a href="/dashboard">Back</a></p>

    <h2>Add Book</h2>
    <form id="book-form">
        <input name="title" placeholder="Title" required>
        <input name="author" placeholder="Author">
        <input name="category" placeholder="Category">
        <input name="stock" type="number" placeholder="Stock" value="1">
        <button type="submit">Create</button>
    </form>

    <h2>Catalog</h2>
    <table id="books-table">
        <thead><tr><th>ID</th><th>Title</th><th>Author</th><th>Category</th><th>Stock</th><th>Actions</th></tr></thead>
        <tbody></tbody>
    </table>

    <script>
    async function fetchBooks(){
        const res = await fetch('/api/books');
        const data = await res.json();
        const tbody = document.querySelector('#books-table tbody');
        tbody.innerHTML = '';
        (data.data || data).forEach(b=>{
            const tr = document.createElement('tr');
            tr.innerHTML = `<td>${b.id}</td><td>${b.title}</td><td>${b.author||''}</td><td>${b.category||''}</td><td>${b.stock||0}</td><td><button data-id="${b.id}" class="del">Delete</button></td>`;
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
</body>
</html>
