@extends('staff.layout')

@section('content')
    <h2>Daftar Akta PPAT</h2>

    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
        <br>
    @endif

    <a href="{{ route('staff.akta-ppat.create') }}"><button>Tambah Akta PPAT</button></a>
    <br><br>

    {{-- ✅ TAMBAH: Form Search --}}
    <div>
        <input type="text" id="searchInput" placeholder="Cari berdasarkan judul, nomor, pihak 1, atau pihak 2..." style="width: 400px; padding: 8px;">
    </div>
    <br>

    <div id="tableContainer">
        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Akta</th>
                    <th>Nomor Akta</th>
                    <th>Tanggal Akta</th>
                    <th>Pihak 1</th>
                    <th>Pihak 2</th>
                    <th>Saksi 1</th>
                    <th>Saksi 2</th>
                    <th>File Akta</th>
                    <th>Foto TTD</th>
                    <th>Warkah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aktaPpat as $index => $item)
                    <tr>
                        <td>{{ ($aktaPpat->currentPage() - 1) * $aktaPpat->perPage() + $index + 1 }}</td>
                        <td>{{ $item->judul_akta }}</td>
                        <td>{{ $item->nomor_akta }}</td>
                        <td>{{ $item->tanggal_akta->format('d/m/Y') }}</td>
                        <td>{{ $item->pihak_1 }}</td>
                        <td>{{ $item->pihak_2 }}</td>
                        <td>{{ $item->saksi_1 ?? '-' }}</td>
                        <td>{{ $item->saksi_2 ?? '-' }}</td>
                        <td><a href="{{ Storage::url($item->file_akta) }}" target="_blank">Lihat File</a></td>
                        <td>
                            @if($item->foto_ttd_para_pihak)
                                <a href="{{ Storage::url($item->foto_ttd_para_pihak) }}" target="_blank">Lihat Foto</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($item->warkah)
                                <a href="{{ Storage::url($item->warkah) }}" target="_blank">Lihat File</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('staff.akta-ppat.edit', $item->uuid) }}"><button>Edit</button></a>
                            <form action="{{ route('staff.akta-ppat.destroy', $item->uuid) }}" method="post" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" style="text-align: center;">Belum ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <br>
        {{ $aktaPpat->links() }}
    </div>

    {{-- ✅ TAMBAH: JavaScript Live Search --}}
    <script>
        let searchTimeout;
        const searchInput = document.getElementById('searchInput');
        const tableContainer = document.getElementById('tableContainer');

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            
            searchTimeout = setTimeout(() => {
                const query = this.value;
                const url = query ? '{{ route("staff.akta-ppat.search") }}?query=' + encodeURIComponent(query) : '{{ route("staff.akta-ppat.index") }}';
                
                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newTableContainer = doc.getElementById('tableContainer');
                        
                        if (newTableContainer) {
                            tableContainer.innerHTML = newTableContainer.innerHTML;
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }, 72); // delay
        });
    </script>
@endsection