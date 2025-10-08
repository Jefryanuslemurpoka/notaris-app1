@extends('admin.layout')

@section('content')
    <h2>Daftar Akta PPAT</h2>

    {{-- Tombol Tambah Akta PPAT --}}
    <a href="/admin/akta-ppat/form">Tambah Akta PPAT</a>

    <br><br>

    {{-- Tabel daftar akta PPAT (kosong dulu) --}}
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
            {{-- Data dummy sementara --}}
            <tr>
                <td>1</td>
                <td>001/PPAT/2025</td>
                <td>Contoh Klien PPAT</td>
                <td>2025-10-02</td>
                <td>
                    <a href="/admin/akta-ppat/form">Edit</a> | 
                    <a href="#">Hapus</a>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
