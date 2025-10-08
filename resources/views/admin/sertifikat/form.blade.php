@extends('admin.layout')

@section('content')
    <h2>Tambah / Edit Sertifikat</h2>

    <form action="#" method="post" enctype="multipart/form-data">
        @csrf

        {{-- Input judul dokumen --}}
        <label>Judul Dokumen</label><br>
        <input type="text" name="judul" placeholder="Masukkan judul dokumen"><br><br>

        {{-- Upload sertifikat --}}
        <label>Upload Sertifikat</label><br>
        <input type="file" name="file_sertifikat"><br><br>

        {{-- Upload warkah/dokumen pendukung --}}
        <label>Upload Warkah / Dokumen Pendukung</label><br>
        <input type="file" name="file_warkah"><br><br>

        {{-- Tombol Simpan --}}
        <button type="submit">Simpan</button>
    </form>
@endsection
