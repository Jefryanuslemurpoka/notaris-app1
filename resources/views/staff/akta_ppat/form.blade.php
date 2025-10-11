@extends('staff.layout')

@section('content')
    <h2>Form {{ isset($akta) ? 'Edit' : 'Tambah' }} Akta PPAT</h2>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($akta) ? route('staff.akta-ppat.update', $akta) : route('staff.akta-ppat.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        
        {{-- Judul Akta --}}
        <div>
            <label for="judul_akta">Judul Akta</label><br>
            <input type="text" id="judul_akta" name="judul_akta" placeholder="Masukkan judul akta" value="{{ old('judul_akta', $akta->judul_akta ?? '') }}" required>
        </div>
        <br>

        {{-- Nomor Akta --}}
        <div>
            <label for="nomor_akta">Nomor Akta</label><br>
            <input type="text" id="nomor_akta" name="nomor_akta" placeholder="Masukkan nomor akta" value="{{ old('nomor_akta', $akta->nomor_akta ?? '') }}" required>
        </div>
        <br>

        {{-- Tanggal Akta --}}
        <div>
            <label for="tanggal_akta">Tanggal Akta</label><br>
            <input type="date" id="tanggal_akta" name="tanggal_akta" value="{{ old('tanggal_akta', isset($akta) ? $akta->tanggal_akta->format('Y-m-d') : '') }}" required>
        </div>
        <br>

        {{-- Pihak 1 --}}
        <div>
            <label for="pihak_1">Pihak 1</label><br>
            <input type="text" id="pihak_1" name="pihak_1" placeholder="Nama pihak 1" value="{{ old('pihak_1', $akta->pihak_1 ?? '') }}" required>
        </div>
        <br>

        {{-- Pihak 2 --}}
        <div>
            <label for="pihak_2">Pihak 2</label><br>
            <input type="text" id="pihak_2" name="pihak_2" placeholder="Nama pihak 2" value="{{ old('pihak_2', $akta->pihak_2 ?? '') }}" required>
        </div>
        <br>

        {{-- Saksi 1 --}}
        <div>
            <label for="saksi_1">Saksi 1 (Opsional)</label><br>
            <input type="text" id="saksi_1" name="saksi_1" placeholder="Nama saksi 1" value="{{ old('saksi_1', $akta->saksi_1 ?? '') }}">
        </div>
        <br>

        {{-- Saksi 2 --}}
        <div>
            <label for="saksi_2">Saksi 2 (Opsional)</label><br>
            <input type="text" id="saksi_2" name="saksi_2" placeholder="Nama saksi 2" value="{{ old('saksi_2', $akta->saksi_2 ?? '') }}">
        </div>
        <br>

        {{-- Upload file akta --}}
        <div>
            <label for="file_akta">Upload File Akta (PDF) {{ isset($akta) ? '(Kosongkan jika tidak ingin mengubah)' : '' }}</label><br>
            <input type="file" id="file_akta" name="file_akta" {{ isset($akta) ? '' : 'required' }}>
            @if(isset($akta) && $akta->file_akta)
                <br><small>File saat ini: {{ basename($akta->file_akta) }}</small>
            @endif
        </div>
        <br>

        {{-- Upload foto ttd para pihak --}}
        <div>
            <label for="foto_ttd_para_pihak">Upload Foto TTD Para Pihak (Opsional)</label><br>
            <input type="file" id="foto_ttd_para_pihak" name="foto_ttd_para_pihak">
            @if(isset($akta) && $akta->foto_ttd_para_pihak)
                <br><small>File saat ini: {{ basename($akta->foto_ttd_para_pihak) }}</small>
            @endif
        </div>
        <br>

        {{-- Upload dokumen pendukung / warkah --}}
        <div>
            <label for="warkah">Upload Warkah / Dokumen Pendukung (Opsional)</label><br>
            <input type="file" id="warkah" name="warkah">
            @if(isset($akta) && $akta->warkah)
                <br><small>File saat ini: {{ basename($akta->warkah) }}</small>
            @endif
        </div>
        <br>
        <label>Status:</label>
        
        <select name="status" required>
            <option value="pending">Pending</option>
            <option value="selesai">Selesai</option>
        </select>
        <br><br>

        {{-- Tombol simpan --}}
        <button type="submit">{{ isset($akta) ? 'Update' : 'Simpan' }}</button>
        <a href="{{ route('staff.akta-ppat.index') }}"><button type="button">Batal</button></a>
    </form>
@endsection