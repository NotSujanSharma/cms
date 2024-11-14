<!-- admin/dashboard.blade.php -->
<h1>Welcome, subadmin</h1>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
