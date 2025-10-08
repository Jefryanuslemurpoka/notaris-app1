@extends('admin.layout')

@section('content')
    <h2>Daftar Akta Notaris</h2>

    {{-- Tombol Tambah Akta --}}
    <a href="/admin/akta-notaris/form">Tambah Akta</a>

    <br><br>

    {{-- Tabel daftar akta --}}
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Akta</th>
                <th>Nama Klien</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            {{-- Data dummy dulu --}}
            <tr>
                <td>1</td>
                <td>001/NOT/2025</td>
                <td>Contoh Klien</td>
                <td>2025-10-02</td>
                <td>
                    <a href="/admin/akta-notaris/form">Edit</a> | 
                    <a href="#">Hapus</a>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
