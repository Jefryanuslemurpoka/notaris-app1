<table border="1" cellpadding="8" cellspacing="0" style="width:100%;">
    <thead>
        <tr>
            <th>No</th>
            <th>Judul Akta</th>
            <th>Nomor Akta</th>
            <th>Tanggal Akta</th>
            <th>Penghadap</th>
            <th>Saksi 1</th>
            <th>Saksi 2</th>
            <th>Status</th>
            <th>Catatan</th>
            <th>File Akta</th>
            <th>Foto TTD</th>
            <th>File SK</th>
            <th>File Warkah</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($aktaList as $index => $akta)
            <tr>
                <td>{{ $aktaList->firstItem() + $index }}</td>
                <td>{{ $akta->judul }}</td>
                <td>{{ $akta->nomor_akta }}</td>
                <td>{{ $akta->tanggal_akta }}</td>
                <td>
                    @php
                        $penghadapList = is_array($akta->penghadap) ? $akta->penghadap : (json_decode($akta->penghadap, true) ?? []);
                    @endphp
                    @foreach ($penghadapList as $p)
                        • {{ $p }}<br>
                    @endforeach
                </td>
                <td>{{ $akta->saksi1 ?? '-' }}</td>
                <td>{{ $akta->saksi2 ?? '-' }}</td>
                
                {{-- Status dengan dropdown --}}
                <td>
                    <select class="status-select" data-uuid="{{ $akta->uuid }}" style="padding:5px;">
                        <option value="pending" {{ ($akta->status ?? 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="selesai" {{ ($akta->status ?? 'pending') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </td>
                
                {{-- Catatan (muncul jika status pending) --}}
                <td>
                    <div class="catatan-wrapper-{{ $akta->uuid }}">
                        @if(($akta->status ?? 'pending') == 'pending')
                            <textarea 
                                class="catatan-input" 
                                data-uuid="{{ $akta->uuid }}" 
                                placeholder="Tulis catatan..."
                                style="width:100%; min-height:60px; padding:5px;"
                            >{{ $akta->catatan ?? '' }}</textarea>
                            <button 
                                class="btn-save-catatan" 
                                data-uuid="{{ $akta->uuid }}"
                                style="margin-top:5px; padding:5px 10px; cursor:pointer; background:#28a745; color:white; border:none; border-radius:3px;"
                            >
                                Simpan
                            </button>
                        @else
                            @if($akta->catatan)
                                <div style="padding:5px; background:#f8f9fa; border-radius:3px; font-size:12px;">
                                    {{ $akta->catatan }}
                                </div>
                            @else
                                <span style="color:#888;">-</span>
                            @endif
                        @endif
                    </div>
                </td>
                
                <td>
                    @if ($akta->file_akta)
                        <a href="{{ asset('storage/' . $akta->file_akta) }}" target="_blank">Lihat Akta</a>
                    @else - @endif
                </td>
                <td>
                    @if ($akta->foto_ttd)
                        <img src="{{ asset('storage/' . $akta->foto_ttd) }}" width="80" height="80" style="object-fit:cover;">
                    @else - @endif
                </td>
                <td>
                    @if ($akta->file_sk)
                        <a href="{{ asset('storage/' . $akta->file_sk) }}" target="_blank">Lihat SK</a>
                    @else - @endif
                </td>
                <td>
                    @if ($akta->file_warkah)
                        <a href="{{ asset('storage/' . $akta->file_warkah) }}" target="_blank">Lihat Warkah</a>
                    @else - @endif
                </td>
                <td>
                    <a href="{{ route('staff.akta-notaris.edit', $akta->uuid) }}">Edit</a> |
                    <form action="{{ route('staff.akta-notaris.destroy', $akta->uuid) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="color:red; background:none; border:none; cursor:pointer;">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="14" style="text-align:center;">Belum ada data akta notaris</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top:10px;">
    {{ $aktaList->links() }}
</div>

{{-- Script untuk handle status dan catatan --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle perubahan status
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', function() {
            const uuid = this.dataset.uuid;
            const status = this.value;
            const catatanWrapper = document.querySelector('.catatan-wrapper-' + uuid);
            
            // Update status via AJAX
            fetch("{{ url('/staff/akta-notaris') }}/" + uuid + "/update-status", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: status, catatan: '' })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update tampilan catatan
                    if (status === 'pending') {
                        catatanWrapper.innerHTML = `
                            <textarea 
                                class="catatan-input" 
                                data-uuid="${uuid}" 
                                placeholder="Tulis catatan..."
                                style="width:100%; min-height:60px; padding:5px;"
                            ></textarea>
                            <button 
                                class="btn-save-catatan" 
                                data-uuid="${uuid}"
                                style="margin-top:5px; padding:5px 10px; cursor:pointer; background:#28a745; color:white; border:none; border-radius:3px;"
                            >
                                Simpan
                            </button>
                        `;
                        attachCatatanHandler(uuid);
                    } else {
                        catatanWrapper.innerHTML = '<span style="color:#888;">-</span>';
                    }
                    alert('Status berhasil diubah!');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengubah status');
            });
        });
    });
    
    // Handle simpan catatan
    function attachCatatanHandler(uuid) {
        const btn = document.querySelector(`.btn-save-catatan[data-uuid="${uuid}"]`);
        if (btn) {
            btn.addEventListener('click', function() {
                saveCatatan(uuid);
            });
        }
    }
    
    // Attach handlers untuk semua tombol simpan yang sudah ada
    document.querySelectorAll('.btn-save-catatan').forEach(btn => {
        btn.addEventListener('click', function() {
            const uuid = this.dataset.uuid;
            saveCatatan(uuid);
        });
    });
    
    function saveCatatan(uuid) {
        const textarea = document.querySelector(`.catatan-input[data-uuid="${uuid}"]`);
        const catatan = textarea.value;
        
        fetch("{{ url('/staff/akta-notaris') }}/" + uuid + "/update-status", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ 
                status: 'pending',
                catatan: catatan 
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Catatan berhasil disimpan!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan catatan');
        });
    }
});
</script>