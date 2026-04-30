<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>User Dashboard</title>
</head>
<body>
    <h1>User Dashboard</h1>
    <p>Welcome, {{ auth()->user()->name }}. This is your dashboard.</p>
    <ul>
        <li><a href="/app/books">Browse Books</a></li>
        <li><a href="/app/ai">Ask for Recommendations</a></li>
    </ul>
</body>
</html>
