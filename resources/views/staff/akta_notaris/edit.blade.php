@extends('staff.layout')

@section('content')
<div class="container mt-4">
    <h2>Edit Akta Notaris</h2>

    {{-- Pesan sukses atau error --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Update --}}
    <form action="{{ route('staff.akta-notaris.update', $akta->uuid) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Judul Akta</label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul', $akta->judul) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nomor Akta</label>
            <input type="text" name="nomor_akta" class="form-control" value="{{ old('nomor_akta', $akta->nomor_akta) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Akta</label>
            <input type="date" name="tanggal_akta" class="form-control" value="{{ old('tanggal_akta', $akta->tanggal_akta) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Penghadap</label>
            @php
                $penghadapRaw = $akta->penghadap;
                if (is_string($penghadapRaw)) {
                    $penghadapList = json_decode($penghadapRaw, true) ?? [];
                } elseif (is_array($penghadapRaw)) {
                    $penghadapList = $penghadapRaw;
                } else {
                    $penghadapList = [];
                }
            @endphp
            <div id="penghadap-container">
                @forelse ($penghadapList as $peng)
                    <input type="text" name="penghadap[]" class="form-control mb-2" value="{{ $peng }}" required>
                @empty
                    <input type="text" name="penghadap[]" class="form-control mb-2" placeholder="Nama Penghadap" required>
                @endforelse
            </div>
            <button type="button" id="add-penghadap" class="btn btn-sm btn-secondary">+ Tambah Penghadap</button>
        </div>

        <div class="mb-3">
            <label class="form-label">Saksi 1</label>
            <input type="text" name="saksi1" class="form-control" value="{{ old('saksi1', $akta->saksi1) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Saksi 2</label>
            <input type="text" name="saksi2" class="form-control" value="{{ old('saksi2', $akta->saksi2) }}">
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" id="status-select" class="form-control">
                <option value="pending" {{ old('status', $akta->status ?? 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="selesai" {{ old('status', $akta->status ?? 'pending') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>

        @php
            $showCatatan = old('status', $akta->status ?? 'pending') == 'pending';
        @endphp

        {{-- Catatan --}}
        <div class="mb-3 {{ $showCatatan ? '' : 'd-none' }}" id="catatan-field">
            <label class="form-label">Catatan (jika pending)</label>
            <textarea name="catatan" class="form-control" rows="3">{{ old('catatan', $akta->catatan ?? '') }}</textarea>
        </div>

        {{-- File Upload (optional) --}}
        <div class="mb-3">
            <label class="form-label">File Akta (PDF/DOC)</label>
            <input type="file" name="file_akta" class="form-control">
            @if($akta->file_akta)
                <small class="text-muted">
                    File saat ini: <a href="{{ asset('storage/'.$akta->file_akta) }}" target="_blank">Lihat File</a>
                </small>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Foto Tanda Tangan (JPEG/PNG)</label>
            <input type="file" name="foto_ttd" class="form-control">
            @if($akta->foto_ttd)
                <div class="mt-2">
                    <img src="{{ asset('storage/'.$akta->foto_ttd) }}" alt="Tanda Tangan" width="120">
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">File SK (Opsional)</label>
            <input type="file" name="file_sk" class="form-control">
            @if($akta->file_sk)
                <small class="text-muted">
                    <a href="{{ asset('storage/'.$akta->file_sk) }}" target="_blank">Lihat File SK</a>
                </small>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">File Warkah (Opsional)</label>
            <input type="file" name="file_warkah" class="form-control">
            @if($akta->file_warkah)
                <small class="text-muted">
                    <a href="{{ asset('storage/'.$akta->file_warkah) }}" target="_blank">Lihat File Warkah</a>
                </small>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('staff.akta-notaris.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<style>
.d-none {
    display: none !important;
}
</style>

{{-- Script Tambah Input Penghadap & Toggle Catatan --}}
<script>
    // Tambah Penghadap
    document.getElementById('add-penghadap').addEventListener('click', function() {
        const container = document.getElementById('penghadap-container');
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'penghadap[]';
        input.classList.add('form-control', 'mb-2');
        input.required = true;
        input.placeholder = 'Nama Penghadap';
        container.appendChild(input);
    });

    // Show/Hide Catatan based on Status
    document.getElementById('status-select').addEventListener('change', function() {
        const catatanField = document.getElementById('catatan-field');
        if (this.value === 'pending') {
            catatanField.classList.remove('d-none');
        } else {
            catatanField.classList.add('d-none');
        }
    });
</script>
@endsection