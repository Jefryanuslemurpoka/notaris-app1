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

    {{-- Form Search --}}
    <div>
        <input type="text" id="searchInput" placeholder="Cari berdasarkan judul, nomor, pihak 1, pihak 2, atau status..." style="width: 400px; padding: 8px;">
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
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aktaPpat as $index => $item)
                    <tr data-uuid="{{ $item->uuid }}">
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
                            <select class="status-select" data-uuid="{{ $item->uuid }}" style="padding: 5px;">
                                <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="selesai" {{ $item->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            
                            {{-- Kolom Catatan (hanya muncul jika pending) --}}
                            <div class="catatan-wrapper" style="margin-top: 8px; {{ $item->status == 'selesai' ? 'display:none;' : '' }}">
                                <textarea class="catatan-input" data-uuid="{{ $item->uuid }}" placeholder="Catatan..." style="width: 100%; padding: 5px; min-height: 60px;">{{ $item->catatan }}</textarea>
                                <button class="btn-save-status" data-uuid="{{ $item->uuid }}" style="margin-top: 5px; padding: 5px 10px;">Simpan</button>
                            </div>
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
                        <td colspan="13" style="text-align: center;">Belum ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <br>
        {{ $aktaPpat->links() }}
    </div>

@endsection

{{-- Script ditaruh di luar section --}}
<script>
console.log('Script loaded!');

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM ready!');
    
    const searchInput = document.getElementById('searchInput');
    const tableContainer = document.getElementById('tableContainer');
    let searchTimeout = null;

    // ✅ LIVE SEARCH
    searchInput.addEventListener('keyup', function() {
        console.log('Keyup detected! Value:', this.value);
        
        const query = this.value;
        
        clearTimeout(searchTimeout);
        
        searchTimeout = setTimeout(function() {
            console.log('Fetching data for:', query);
            
            const url = query 
                ? "{{ route('staff.akta-ppat.search') }}?query=" + encodeURIComponent(query)
                : "{{ route('staff.akta-ppat.index') }}";
            
            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.text();
            })
            .then(data => {
                console.log('Data received! Length:', data.length);
                
                const parser = new DOMParser();
                const doc = parser.parseFromString(data, 'text/html');
                const newTableContainer = doc.getElementById('tableContainer');
                
                if (newTableContainer) {
                    tableContainer.innerHTML = newTableContainer.innerHTML;
                    initStatusHandlers(); // ✅ Re-init handlers setelah load data baru
                }
            })
            .catch(error => {
                console.error('Error:', error);
                tableContainer.innerHTML = '<p style="color:red;">Terjadi kesalahan: ' + error.message + '</p>';
            });
        }, 500);
    });

    // ✅ INIT STATUS HANDLERS
    initStatusHandlers();
});

// ✅ FUNCTION: Init handlers untuk dropdown status dan tombol simpan
function initStatusHandlers() {
    // ✅ Handle perubahan dropdown status
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', function() {
            const uuid = this.getAttribute('data-uuid');
            const row = document.querySelector(`tr[data-uuid="${uuid}"]`);
            const catatanWrapper = row.querySelector('.catatan-wrapper');
            const newStatus = this.value;
            
            // ✅ Jika diubah ke SELESAI, langsung simpan ke database
            if (newStatus === 'selesai') {
                if (confirm('Ubah status menjadi Selesai?')) {
                    // Kirim request update status
                    fetch("/staff/akta-ppat/" + uuid + "/update-status", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            status: 'selesai',
                            catatan: null
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Status berhasil diubah menjadi Selesai!');
                            catatanWrapper.style.display = 'none';
                        } else {
                            alert('Gagal update status: ' + data.message);
                            // Kembalikan dropdown ke pending jika gagal
                            this.value = 'pending';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan: ' + error.message);
                        // Kembalikan dropdown ke pending jika error
                        this.value = 'pending';
                    });
                } else {
                    // Jika user cancel, kembalikan dropdown ke pending
                    this.value = 'pending';
                }
            } else {
                // Jika diubah ke PENDING, tampilkan catatan
                catatanWrapper.style.display = 'block';
            }
        });
    });

    // ✅ Handle tombol simpan (untuk status PENDING + catatan)
    document.querySelectorAll('.btn-save-status').forEach(button => {
        button.addEventListener('click', function() {
            const uuid = this.getAttribute('data-uuid');
            const row = document.querySelector(`tr[data-uuid="${uuid}"]`);
            const statusSelect = row.querySelector('.status-select');
            const catatanInput = row.querySelector('.catatan-input');
            
            const status = statusSelect.value;
            const catatan = catatanInput ? catatanInput.value : '';

            // Kirim AJAX request
            fetch("/staff/akta-ppat/" + uuid + "/update-status", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    status: status,
                    catatan: catatan
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Catatan berhasil disimpan!');
                } else {
                    alert('Gagal menyimpan catatan: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan: ' + error.message);
            });
        });
    });
}
</script>