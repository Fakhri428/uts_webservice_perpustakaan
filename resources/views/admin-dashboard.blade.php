<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <p>Welcome, {{ auth()->user()->name }}. This is the admin dashboard.</p>
    <ul>
        <li><a href="/app/books">Manage Books</a></li>
        <li><a href="/app/categories">Manage Categories</a></li>
        <li><a href="/app/loans">Manage Loans</a></li>
        <li><a href="/app/ai">AI Tools</a></li>
    </ul>
</body>
</html>
