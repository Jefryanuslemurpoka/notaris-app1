@extends('admin.layout')

@section('content')
    <h2>Form Tambah/Edit Akta PPAT</h2>

    <form action="#" method="post" enctype="multipart/form-data">
        @csrf
        
        {{-- Input judul dokumen --}}
        <div>
            <label for="judul">Judul Dokumen</label><br>
            <input type="text" id="judul" name="judul" placeholder="Masukkan judul dokumen">
        </div>
        <br>

        {{-- Upload file akta --}}
        <div>
            <label for="akta_file">Upload Akta PPAT</label><br>
            <input type="file" id="akta_file" name="akta_file">
        </div>
        <br>

        {{-- Upload dokumen pendukung / warkah --}}
        <div>
            <label for="warkah">Upload Warkah / Dokumen Pendukung</label><br>
            <input type="file" id="warkah" name="warkah">
        </div>
        <br>

        {{-- Tombol simpan --}}
        <button type="submit">Simpan</button>
    </form>
@endsection
