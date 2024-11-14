<!-- admin/dashboard.blade.php -->
<h1>Welcome, Admin</h1>
<!-- admin/dashboard.blade.php -->
<h1>Welcome, Admin</h1>

<!-- Logout Form -->
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
