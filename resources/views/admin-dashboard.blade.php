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
        <li><a href="/books">Manage Books (API)</a></li>
        <li><a href="/loans">Manage Loans (API)</a></li>
    </ul>
</body>
</html>
