<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
</head>
<body>
    <h1>Panel Admin</h1>
    <nav>
        <a href="/admin/dashboard">Dashboard</a> |
        <a href="/admin/akta-notaris">Akta Notaris</a> |
        <a href="/admin/akta-ppat">Akta PPAT</a> |
        <a href="/admin/legnot">Legnot</a> |
        <a href="/admin/sertifikat">Sertifikat</a>

        {{-- Tombol Logout --}}
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" style="background:none; border:none; color:red; cursor:pointer;">
                Logout
            </button>
        </form>
    </nav>
    <hr>

    <div>
        @yield('content')
    </div>
</body>
</html>
