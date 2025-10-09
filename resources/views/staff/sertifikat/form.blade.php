@extends('staff.layout')

@section('content')
    <h2>{{ isset($sertifikat) ? 'Edit' : 'Tambah' }} Sertifikat</h2>

    @if($errors->any())
        <div>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($sertifikat) ? route('staff.sertifikat.update', $sertifikat) : route('staff.sertifikat.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>Nomor Sertifikat *</label><br>
        <input type="text" name="nomor_sertifikat" placeholder="Contoh: SRT-001/2025" value="{{ old('nomor_sertifikat', $sertifikat->nomor_sertifikat ?? '') }}" required><br><br>

        <label>Nama Pemilik *</label><br>
        <input type="text" name="nama_pemilik" placeholder="Nama pemilik sertifikat" value="{{ old('nama_pemilik', $sertifikat->nama_pemilik ?? '') }}" required><br><br>

        <label>Tanggal Terbit *</label><br>
        <input type="date" name="tanggal_terbit" value="{{ old('tanggal_terbit', isset($sertifikat) ? $sertifikat->tanggal_terbit->format('Y-m-d') : '') }}" required><br><br>

        <label>Judul Dokumen *</label><br>
        <input type="text" name="judul_dokumen" placeholder="Masukkan judul dokumen" value="{{ old('judul_dokumen', $sertifikat->judul_dokumen ?? '') }}" required><br><br>

        <label>Upload Sertifikat (PDF/JPG/PNG, max 10MB)</label><br>
        @if(isset($sertifikat) && $sertifikat->file_sertifikat)
            <p>File saat ini: <a href="{{ asset('storage/' . $sertifikat->file_sertifikat) }}" target="_blank">Lihat File</a></p>
        @endif
        <input type="file" name="file_sertifikat" accept=".pdf,.jpg,.jpeg,.png"><br><br>

        <label>Upload Warkah / Dokumen Pendukung (PDF/JPG/PNG, max 10MB)</label><br>
        @if(isset($sertifikat) && $sertifikat->file_warkah)
            <p>File saat ini: <a href="{{ asset('storage/' . $sertifikat->file_warkah) }}" target="_blank">Lihat File</a></p>
        @endif
        <input type="file" name="file_warkah" accept=".pdf,.jpg,.jpeg,.png"><br><br>

        <label>Upload Foto Tanda Tangan (JPG/PNG, max 5MB)</label><br>
        @if(isset($sertifikat) && $sertifikat->foto_ttd)
            <p>Foto saat ini: <a href="{{ asset('storage/' . $sertifikat->foto_ttd) }}" target="_blank">Lihat Foto</a></p>
        @endif
        <input type="file" name="foto_ttd" accept=".jpg,.jpeg,.png"><br><br>

        <button type="submit">{{ isset($sertifikat) ? 'Update' : 'Simpan' }}</button>
        <a href="{{ route('staff.sertifikat.index') }}">Batal</a>
    </form>
@endsection