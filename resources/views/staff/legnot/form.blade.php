@extends('staff.layout')

@section('content')
    <h2>{{ $isEdit ? 'Edit' : 'Tambah' }} Legnot</h2>

    @if(session('success'))
        <div style="color: green; margin-bottom: 10px;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="color: red; margin-bottom: 10px;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $isEdit ? route('staff.legnot.update', $legnot->uuid) : route('staff.legnot.store') }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf

        {{-- Input Nomor Legalisasi --}}
        <div>
            <label for="nomor_legalisasi">Nomor Legalisasi</label><br>
            <input type="text" 
                   name="nomor_legalisasi" 
                   id="nomor_legalisasi" 
                   value="{{ old('nomor_legalisasi', $legnot->nomor_legalisasi ?? '') }}" 
                   required>
        </div>

        <br>

        {{-- Input Judul Dokumen --}}
        <div>
            <label for="judul">Judul Dokumen</label><br>
            <input type="text" 
                   name="judul" 
                   id="judul" 
                   value="{{ old('judul', $legnot->judul ?? '') }}" 
                   required>
        </div>

        <br>

        {{-- Input Nama Klien --}}
        <div>
            <label for="nama_klien">Nama Klien</label><br>
            <input type="text" 
                   name="nama_klien" 
                   id="nama_klien" 
                   value="{{ old('nama_klien', $legnot->nama_klien ?? '') }}" 
                   required>
        </div>

        <br>

        {{-- Input Tanggal --}}
        <div>
            <label for="tanggal">Tanggal</label><br>
            <input type="date" 
                   name="tanggal" 
                   id="tanggal" 
                   value="{{ old('tanggal', $legnot->tanggal ?? '') }}" 
                   required>
        </div>

        <br>

        {{-- Upload Dokumen Legalisasi --}}
        <div>
            <label for="file_legnot">Upload Dokumen Legalisasi</label><br>
            <input type="file" 
                   name="file_legnot" 
                   id="file_legnot" 
                   {{ $isEdit ? '' : 'required' }}>
            
            @if($isEdit && $legnot->file_legnot)
                <br>
                <small>File saat ini: {{ basename($legnot->file_legnot) }}</small>
            @endif
        </div>

        <br>

        {{-- Tombol Simpan --}}
        <button type="submit">{{ $isEdit ? 'Update' : 'Simpan' }}</button>
        <a href="{{ route('staff.legnot.index') }}">Batal</a>
    </form>
@endsection