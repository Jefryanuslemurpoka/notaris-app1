@extends('staff.layout')

@section('content')
    <h2>Daftar Akta Notaris</h2>

    @if (session('success'))
        <div style="color: green; margin-bottom: 10px;">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('staff.akta-notaris.create') }}">Tambah Akta</a>

    <br><br>

    <input type="text" id="search" placeholder="Cari judul, nomor akta, penghadap, saksi..." style="padding:5px; width:300px; margin-bottom:10px;">

    <br>

    <div id="akta-table">
        @include('staff.akta_notaris.partials.tabel-akta', ['aktaList' => $aktaList])
    </div>

@endsection

<!-- ⚠️ SCRIPT DITARUH DI SINI (BUKAN DI SECTION) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
console.log('Script loaded!'); // TEST

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM ready!'); // TEST
    
    const searchInput = document.getElementById('search');
    const aktaTable = document.getElementById('akta-table');
    let timeout = null;

    console.log('Search input:', searchInput); // TEST

    searchInput.addEventListener('keyup', function() {
        console.log('Keyup detected! Value:', this.value); // TEST
        
        const query = this.value;
        
        clearTimeout(timeout);
        
        timeout = setTimeout(function() {
            console.log('Fetching data for:', query); // TEST
            
            fetch("{{ route('staff.akta-notaris.search') }}?query=" + encodeURIComponent(query), {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                console.log('Response status:', response.status); // TEST
                return response.text();
            })
            .then(data => {
                console.log('Data received! Length:', data.length); // TEST
                aktaTable.innerHTML = data;
            })
            .catch(error => {
                console.error('Error:', error); // TEST
                aktaTable.innerHTML = '<p style="color:red;">Terjadi kesalahan: ' + error.message + '</p>';
            });
        }, 500);
    });
});
</script>