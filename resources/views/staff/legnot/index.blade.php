@extends('staff.layout')

@section('content')
    <h2>Daftar Legnot</h2>

    @if(session('success'))
        <div style="color: green; margin-bottom: 10px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tombol Tambah Legnot --}}
    <a href="{{ route('staff.legnot.create') }}">Tambah Legnot</a>

    <br><br>

    {{-- Form Pencarian Live Search --}}
    <div>
        <input type="text" 
               id="searchInput" 
               placeholder="Cari nomor, judul, atau nama klien..." 
               value="{{ request('q') }}"
               style="width: 300px; padding: 5px;">
        <span id="loadingText" style="display: none; margin-left: 10px;">Mencari...</span>
    </div>

    <br>

    {{-- Info Total Data --}}
    <p id="infoText">Total: {{ $legnots->total() }} data | Halaman {{ $legnots->currentPage() }} dari {{ $legnots->lastPage() }}</p>

    {{-- Tabel daftar legnot --}}
    <div id="tableContainer">
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor Legalisasi</th>
                    <th>Judul</th>
                    <th>Nama Klien</th>
                    <th>Tanggal</th>
                    <th>File</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($legnots as $index => $legnot)
                    <tr>
                        <td>{{ $legnots->firstItem() + $index }}</td>
                        <td>{{ $legnot->nomor_legalisasi }}</td>
                        <td>{{ $legnot->judul }}</td>
                        <td>{{ $legnot->nama_klien }}</td>
                        <td>{{ \Carbon\Carbon::parse($legnot->tanggal)->format('d/m/Y') }}</td>
                        <td>
                            @if($legnot->file_legnot)
                                <a href="{{ asset('storage/' . $legnot->file_legnot) }}" target="_blank">Lihat File</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('staff.legnot.edit', $legnot->uuid) }}">Edit</a> | 
                            <form action="{{ route('staff.legnot.destroy', $legnot->uuid) }}" 
                                  method="POST" 
                                  style="display: inline;"
                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="border: none; background: none; color: blue; cursor: pointer; text-decoration: underline;">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">Belum ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <br>

        {{-- Pagination Links --}}
        <div id="paginationContainer">
            {{ $legnots->links() }}
        </div>
    </div>

    {{-- JavaScript Live Search --}}
    <script>
        let searchTimeout;
        const searchInput = document.getElementById('searchInput');
        const loadingText = document.getElementById('loadingText');
        const tableContainer = document.getElementById('tableContainer');
        const infoText = document.getElementById('infoText');

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            
            const query = this.value;
            
            // Tampilkan loading
            loadingText.style.display = 'inline';
            
            // Delay 500ms sebelum search (debouncing)
            searchTimeout = setTimeout(function() {
                performSearch(query);
            }, 500);
        });

        function performSearch(query) {
            const url = query ? '{{ route("staff.legnot.search") }}?q=' + encodeURIComponent(query) : '{{ route("staff.legnot.index") }}';
            
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                // Parse HTML response
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                // Update table container
                const newTableContainer = doc.getElementById('tableContainer');
                if (newTableContainer) {
                    tableContainer.innerHTML = newTableContainer.innerHTML;
                }
                
                // Update info text
                const newInfoText = doc.getElementById('infoText');
                if (newInfoText) {
                    infoText.innerHTML = newInfoText.innerHTML;
                }
                
                // Hide loading
                loadingText.style.display = 'none';
                
                // Re-attach pagination click events
                attachPaginationEvents();
            })
            .catch(error => {
                console.error('Error:', error);
                loadingText.style.display = 'none';
            });
        }

        // Handle pagination clicks without page reload
        function attachPaginationEvents() {
            const paginationLinks = document.querySelectorAll('#paginationContainer a');
            
            paginationLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const url = this.getAttribute('href');
                    loadingText.style.display = 'inline';
                    
                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        
                        const newTableContainer = doc.getElementById('tableContainer');
                        if (newTableContainer) {
                            tableContainer.innerHTML = newTableContainer.innerHTML;
                        }
                        
                        const newInfoText = doc.getElementById('infoText');
                        if (newInfoText) {
                            infoText.innerHTML = newInfoText.innerHTML;
                        }
                        
                        loadingText.style.display = 'none';
                        
                        // Re-attach events for new pagination links
                        attachPaginationEvents();
                        
                        // Scroll to top of table
                        tableContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        loadingText.style.display = 'none';
                    });
                });
            });
        }

        // Initial attachment of pagination events
        attachPaginationEvents();
    </script>
@endsection