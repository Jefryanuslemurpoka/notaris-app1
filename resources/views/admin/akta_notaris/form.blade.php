@extends('admin.layout')

@section('content')
    <h2>Form Tambah/Edit Akta Notaris</h2>

    {{-- Form upload akta --}}
    <form action="/admin/akta-notaris/save" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="judul">Judul Dokumen</label><br>
            <input type="text" id="judul" name="judul" placeholder="Masukkan judul dokumen" required>
        </div>

        <br>

        <div>
            <label for="file_akta">Upload Akta (File)</label><br>
            <input type="file" id="file_akta" name="file_akta" required>
        </div>

        <br>

        <div>
            <label for="foto_ttd">Foto TTD Minuta Akta</label><br>
            <input type="file" id="foto_ttd" name="foto_ttd" required>
        </div>

        <br>

        <button type="submit">Simpan</button>
    </form>
@endsection
