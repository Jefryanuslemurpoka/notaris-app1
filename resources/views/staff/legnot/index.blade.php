@extends('staff.layout')

@section('content')
    <h2>Daftar Legnot</h2>

    {{-- Tombol Tambah Legnot --}}
    <a href="/staff/legnot/form">Tambah Legnot</a>

    <br><br>

    {{-- Tabel daftar legnot (kosong dulu) --}}
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Legalisasi</th>
                <th>Nama Klien</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            {{-- Data dummy dulu --}}
            <tr>
                <td>1</td>
                <td>001/LEG/2025</td>
                <td>Contoh Klien</td>
                <td>2025-10-02</td>
                <td>
                    <a href="/staff/legnot/form">Edit</a> | 
                    <a href="#">Hapus</a>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
