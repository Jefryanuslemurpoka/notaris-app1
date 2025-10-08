@extends('admin.layout')

@section('content')
    <h2>Detail Dokumen</h2>

    {{-- Nama Dokumen --}}
    <p><strong>Nama Dokumen:</strong> Contoh Dokumen</p>

    {{-- Dokumen Pendukung --}}
    <p><strong>Dokumen Pendukung:</strong> (belum ada)</p>

    {{-- QR Code Placeholder --}}
    <p><strong>QR Code:</strong></p>
    <div style="width:150px; height:150px; border:1px solid #000; display:flex; align-items:center; justify-content:center;">
        QR Code
    </div>
@endsection
