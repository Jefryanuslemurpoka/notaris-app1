@extends('staff.layout')

@section('content')
<h2>Form Tambah Akta Notaris</h2>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('staff.akta-notaris.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
        <label>Judul Akta</label><br>
        <input type="text" name="judul" value="{{ old('judul') }}" required>
    </div>

    <div>
        <label>Nomor Akta</label><br>
        <input type="text" name="nomor_akta" value="{{ old('nomor_akta') }}" required>
    </div>

    <div>
        <label>Tanggal Akta</label><br>
        <input type="date" name="tanggal_akta" value="{{ old('tanggal_akta') }}" required>
    </div>

    <div id="penghadap-wrapper">
        <label>Nama Penghadap</label><br>
        <div class="penghadap-item">
            <input type="text" name="penghadap[]" required>
            <button type="button" onclick="removePenghadap(this)">Hapus</button>
        </div>
    </div>
    <button type="button" onclick="addPenghadap()">Tambah Penghadap</button>

    <div>
        <label>Saksi 1</label><br>
        <input type="text" name="saksi1" value="{{ old('saksi1') }}">
    </div>

    <div>
        <label>Saksi 2</label><br>
        <input type="text" name="saksi2" value="{{ old('saksi2') }}">
    </div>

    <div>
        <label>Status</label><br>
        <select name="status" id="status-select">
            <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
    </div>

    @php
        $showCatatan = old('status', 'pending') == 'pending';
    @endphp

    <div id="catatan-field" class="{{ $showCatatan ? '' : 'd-none' }}">
        <label>Catatan (jika pending)</label><br>
        <textarea name="catatan" rows="3" style="width:300px;">{{ old('catatan') }}</textarea>
    </div>

    <div>
        <label>Upload Akta</label><br>
        <input type="file" name="file_akta" required>
    </div>

    <div>
        <label>Foto TTD Penghadap</label><br>
        <input type="file" name="foto_ttd" required>
    </div>

    <div>
        <label>Upload SK</label><br>
        <input type="file" name="file_sk">
    </div>

    <div>
        <label>Upload Warkah Akta Notaris</label><br>
        <input type="file" name="file_warkah">
    </div>

    <br>
    <button type="submit">Simpan</button>
</form>

<style>
.d-none {
    display: none !important;
}
</style>

<script>
function addPenghadap() {
    const wrapper = document.getElementById('penghadap-wrapper');
    const div = document.createElement('div');
    div.className = 'penghadap-item';

    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'penghadap[]';
    input.required = true;

    const btn = document.createElement('button');
    btn.type = 'button';
    btn.textContent = 'Hapus';
    btn.onclick = function() { removePenghadap(btn); };

    div.appendChild(input);
    div.appendChild(btn);
    wrapper.appendChild(div);
}

function removePenghadap(button) {
    const div = button.parentNode;
    div.remove();
}

// Show/hide catatan field based on status
document.getElementById('status-select').addEventListener('change', function() {
    const catatanField = document.getElementById('catatan-field');
    if (this.value === 'pending') {
        catatanField.classList.remove('d-none');
    } else {
        catatanField.classList.add('d-none');
    }
});
</script>
@endsection