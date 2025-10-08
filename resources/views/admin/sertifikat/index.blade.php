@extends('admin.layout')

@section('content')
    <h2>Daftar Sertifikat</h2>

    {{-- Tombol Tambah Sertifikat --}}
    <a href="/admin/sertifikat/form">Tambah Sertifikat</a>

    <br><br>

    {{-- Tabel daftar sertifikat (dummy dulu) --}}
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Sertifikat</th>
                <th>Nama Pemilik</th>
                <th>Tanggal Terbit</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            {{-- Data dummy --}}
            <tr>
                <td>1</td>
                <td>SRT-001/2025</td>
                <td>Contoh Pemilik</td>
                <td>2025-10-02</td>
                <td>
                    <a href="/admin/sertifikat/form">Edit</a> | 
                    <a href="#">Hapus</a>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
