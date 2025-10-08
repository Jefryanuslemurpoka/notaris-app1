<table border="1" cellpadding="8" cellspacing="0" style="width:100%;">
    <thead>
        <tr>
            <th>No</th>
            <th>Judul Akta</th>
            <th>Nomor Akta</th>
            <th>Tanggal Akta</th>
            <th>Penghadap</th>
            <th>Saksi 1</th>
            <th>Saksi 2</th>
            <th>File Akta</th>
            <th>Foto TTD</th>
            <th>File SK</th>
            <th>File Warkah</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($aktaList as $index => $akta)
            <tr>
                <td>{{ $aktaList->firstItem() + $index }}</td>
                <td>{{ $akta->judul }}</td>
                <td>{{ $akta->nomor_akta }}</td>
                <td>{{ $akta->tanggal_akta }}</td>
                <td>
                    @php
                        $penghadapList = is_array($akta->penghadap) ? $akta->penghadap : (json_decode($akta->penghadap, true) ?? []);
                    @endphp
                    @foreach ($penghadapList as $p)
                        • {{ $p }}<br>
                    @endforeach
                </td>
                <td>{{ $akta->saksi1 ?? '-' }}</td>
                <td>{{ $akta->saksi2 ?? '-' }}</td>
                <td>
                    @if ($akta->file_akta)
                        <a href="{{ asset('storage/' . $akta->file_akta) }}" target="_blank">Lihat Akta</a>
                    @else - @endif
                </td>
                <td>
                    @if ($akta->foto_ttd)
                        <img src="{{ asset('storage/' . $akta->foto_ttd) }}" width="80" height="80" style="object-fit:cover;">
                    @else - @endif
                </td>
                <td>
                    @if ($akta->file_sk)
                        <a href="{{ asset('storage/' . $akta->file_sk) }}" target="_blank">Lihat SK</a>
                    @else - @endif
                </td>
                <td>
                    @if ($akta->file_warkah)
                        <a href="{{ asset('storage/' . $akta->file_warkah) }}" target="_blank">Lihat Warkah</a>
                    @else - @endif
                </td>
                <td>
                    <a href="{{ route('staff.akta-notaris.edit', $akta->uuid) }}">Edit</a> |
                    <form action="{{ route('staff.akta-notaris.destroy', $akta->uuid) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="color:red; background:none; border:none; cursor:pointer;">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="12" style="text-align:center;">Belum ada data akta notaris</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top:10px;">
    {{ $aktaList->links() }}
</div>