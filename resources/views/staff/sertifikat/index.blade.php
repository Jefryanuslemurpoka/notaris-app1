@extends('staff.layout')

@section('content')
    <h2>Daftar Sertifikat</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <a href="{{ route('staff.sertifikat.create') }}">Tambah Sertifikat</a>

    <br><br>

    <input type="text" id="searchInput" placeholder="Cari nomor sertifikat, nama pemilik, judul..." value="{{ $query ?? '' }}">

    <br><br>

    <table border="1" cellpadding="8" cellspacing="0" style="width: 100%;">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Sertifikat</th>
                <th>Nama Pemilik</th>
                <th>Tanggal Terbit</th>
                <th>Lihat File</th>
                <th>Lihat Foto TTD</th>
                <th style="width: 250px;">Status</th>
                <th>Catatan</th>
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
                    <div style="display: flex; align-items: center; gap: 5px;">
                        @if($item->status === 'selesai')
                            <span style="color: green; font-weight: bold;">●</span>
                        @else
                            <span style="color: orange; font-weight: bold;">●</span>
                        @endif
                        <select class="status-dropdown" data-uuid="{{ $item->uuid }}" data-current-status="{{ $item->status }}" style="padding: 4px;">
                            <option value="pending" {{ $item->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="selesai" {{ $item->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="catatan-field" id="catatan-{{ $item->uuid }}" style="display: {{ $item->status === 'pending' ? 'block' : 'none' }}; margin-top: 8px;">
                        <input type="text" 
                               class="catatan-input" 
                               data-uuid="{{ $item->uuid }}" 
                               placeholder="Masukkan catatan..." 
                               value="{{ $item->catatan }}"
                               style="width: 100%; padding: 4px; box-sizing: border-box;">
                        <button class="simpan-catatan" 
                                data-uuid="{{ $item->uuid }}" 
                                style="margin-top: 4px; padding: 4px 8px; background: #4CAF50; color: white; border: none; cursor: pointer; border-radius: 3px;">
                            Simpan
                        </button>
                    </div>
                </td>
                <td>
                    @if($item->catatan)
                        <span style="color: #666;">{{ $item->catatan }}</span>
                    @else
                        <span style="color: #ccc;">-</span>
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
                <td colspan="9">Belum ada data sertifikat</td>
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

        // Search functionality
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

        // Handle status change
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('status-dropdown')) {
                const uuid = e.target.dataset.uuid;
                const currentStatus = e.target.dataset.currentStatus;
                const newStatus = e.target.value;
                const catatanField = document.getElementById('catatan-' + uuid);

                // Jika ubah ke pending, tampilkan field catatan
                if (newStatus === 'pending') {
                    catatanField.style.display = 'block';
                } else {
                    // Jika ubah ke selesai, langsung update dan sembunyikan field catatan
                    catatanField.style.display = 'none';
                    updateStatus(uuid, newStatus, null);
                }
            }
        });

        // Handle simpan catatan
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('simpan-catatan')) {
                const uuid = e.target.dataset.uuid;
                const catatanInput = document.querySelector(`.catatan-input[data-uuid="${uuid}"]`);
                const catatan = catatanInput.value.trim();
                
                if (!catatan) {
                    alert('Catatan harus diisi untuk status pending!');
                    return;
                }
                
                updateStatus(uuid, 'pending', catatan);
            }
        });

        // Fungsi update status
        function updateStatus(uuid, status, catatan) {
            fetch(`/staff/sertifikat/${uuid}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    status: status,
                    catatan: catatan
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Status berhasil diupdate!');
                    // Update current status di dropdown
                    const dropdown = document.querySelector(`[data-uuid="${uuid}"]`);
                    if (dropdown) {
                        dropdown.dataset.currentStatus = status;
                    }
                    // Reload halaman untuk update tampilan
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal mengupdate status!');
            });
        }
    </script>
@endsection