<!DOCTYPE html>
<html>
<head>
    <title>Staff Panel</title>
</head>
<body>
    <h1>Panel Staff</h1>
    <nav>
        <a href="/staff/dashboard">Dashboard</a> |
        <a href="/staff/akta-notaris">Akta Notaris</a> |
        <a href="/staff/akta-ppat">Akta PPAT</a> |
        <a href="/staff/legnot">Legnot</a> |
        <a href="/staff/sertifikat">Sertifikat</a>

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
