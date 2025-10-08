@extends('admin.layout')

@section('content')
    <h2>Form Tambah/Edit Legnot</h2>

    <form action="#" method="post" enctype="multipart/form-data">
        @csrf

        {{-- Input Judul Dokumen --}}
        <div>
            <label for="judul">Judul Dokumen</label><br>
            <input type="text" name="judul" id="judul" required>
        </div>

        <br>

        {{-- Upload Dokumen Legalisasi --}}
        <div>
            <label for="file_legnot">Upload Dokumen Legalisasi</label><br>
            <input type="file" name="file_legnot" id="file_legnot" required>
        </div>

        <br>

        {{-- Tombol Simpan --}}
        <button type="submit">Simpan</button>
    </form>
@endsection
