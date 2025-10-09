@extends('staff.layout')

@section('content')
    <h2>Daftar Sertifikat</h2>

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <a href="{{ route('staff.sertifikat.create') }}">Tambah Sertifikat</a>

    <br><br>

    <input type="text" id="searchInput" placeholder="Cari nomor sertifikat, nama pemilik, judul..." value="{{ $query ?? '' }}">

    <br><br>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Sertifikat</th>
                <th>Nama Pemilik</th>
                <th>Tanggal Terbit</th>
                <th>Lihat File</th>
                <th>Lihat Foto TTD</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @forelse($sertifikats as $index => $item)
            <tr>
                <td>{{ ($sertifikats->currentPage() - 1) * $sertifikats->perPage() + $index + 1 }}</td>
                <td>{{ $item->nomor_sertifikat }}</td>
                <td>{{ $item->nama_pemilik }}</td>
                <td>{{ $item->tanggal_terbit->format('d-m-Y') }}</td>
                <td>
                    @if($item->file_sertifikat)
                        <a href="{{ asset('storage/' . $item->file_sertifikat) }}" target="_blank">Sertifikat</a>
                    @endif
                    @if($item->file_warkah)
                        | <a href="{{ asset('storage/' . $item->file_warkah) }}" target="_blank">Warkah</a>
                    @endif
                    @if(!$item->file_sertifikat && !$item->file_warkah)
                        -
                    @endif
                </td>
                <td>
                    @if($item->foto_ttd)
                        <a href="{{ asset('storage/' . $item->foto_ttd) }}" target="_blank">Lihat</a>
                    @else
                        -
                    @endif
                </td>
                <td>
                    <a href="{{ route('staff.sertifikat.edit', $item) }}">Edit</a> | 
                    <form action="{{ route('staff.sertifikat.destroy', $item) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">Belum ada data sertifikat</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <br>

    <div id="paginationContainer">
        {{ $sertifikats->links() }}
    </div>

    <script>
        let searchTimeout;
        const searchInput = document.getElementById('searchInput');
        const tableBody = document.getElementById('tableBody');
        const paginationContainer = document.getElementById('paginationContainer');

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            
            searchTimeout = setTimeout(() => {
                const query = this.value;
                const url = query ? '{{ route("staff.sertifikat.index") }}?q=' + encodeURIComponent(query) : '{{ route("staff.sertifikat.index") }}';
                
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    tableBody.innerHTML = data.html;
                    paginationContainer.innerHTML = data.pagination;
                })
                .catch(error => console.error('Error:', error));
            }, 500);
        });

        // Handle pagination clicks
        document.addEventListener('click', function(e) {
            if (e.target.matches('.pagination a')) {
                e.preventDefault();
                const url = e.target.href;
                
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    tableBody.innerHTML = data.html;
                    paginationContainer.innerHTML = data.pagination;
                })
                .catch(error => console.error('Error:', error));
            }
        });
    </script>
@endsection