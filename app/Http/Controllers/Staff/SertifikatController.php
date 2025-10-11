<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SertifikatController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q');
        
        $sertifikats = Sertifikat::query()
            ->when($query, function($q) use ($query) {
                $q->where('nomor_sertifikat', 'like', "%{$query}%")
                  ->orWhere('nama_pemilik', 'like', "%{$query}%")
                  ->orWhere('judul_dokumen', 'like', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(50)
            ->appends(['q' => $query]);

        // Jika request AJAX, kembalikan JSON
        if ($request->ajax()) {
            $html = '';
            
            foreach ($sertifikats as $index => $item) {
                $no = ($sertifikats->currentPage() - 1) * $sertifikats->perPage() + $index + 1;
                $tanggal = $item->tanggal_terbit->format('d-m-Y');
                
                $fileLinks = '';
                if ($item->file_sertifikat) {
                    $fileLinks .= '<a href="' . asset('storage/' . $item->file_sertifikat) . '" target="_blank">Sertifikat</a>';
                }
                if ($item->file_warkah) {
                    $fileLinks .= ($fileLinks ? ' | ' : '') . '<a href="' . asset('storage/' . $item->file_warkah) . '" target="_blank">Warkah</a>';
                }
                if (!$item->file_sertifikat && !$item->file_warkah) {
                    $fileLinks = '-';
                }
                
                $fotoTtd = $item->foto_ttd 
                    ? '<a href="' . asset('storage/' . $item->foto_ttd) . '" target="_blank">Lihat</a>'
                    : '-';
                
                $statusBadge = $item->status === 'selesai' 
                    ? '<span style="color: green; font-weight: bold;">●</span>' 
                    : '<span style="color: orange; font-weight: bold;">●</span>';
                
                $catatanDisplay = $item->status === 'pending' ? 'block' : 'none';
                $catatanValue = htmlspecialchars($item->catatan ?? '');
                
                $statusHtml = '<div style="display: flex; align-items: center; gap: 5px;">
                    ' . $statusBadge . '
                    <select class="status-dropdown" data-uuid="' . $item->uuid . '" data-current-status="' . $item->status . '" style="padding: 4px;">
                        <option value="pending" ' . ($item->status === 'pending' ? 'selected' : '') . '>Pending</option>
                        <option value="selesai" ' . ($item->status === 'selesai' ? 'selected' : '') . '>Selesai</option>
                    </select>
                </div>
                <div class="catatan-field" id="catatan-' . $item->uuid . '" style="display: ' . $catatanDisplay . '; margin-top: 8px;">
                    <input type="text" 
                           class="catatan-input" 
                           data-uuid="' . $item->uuid . '" 
                           placeholder="Masukkan catatan..." 
                           value="' . $catatanValue . '"
                           style="width: 100%; padding: 4px; box-sizing: border-box;">
                    <button class="simpan-catatan" 
                            data-uuid="' . $item->uuid . '" 
                            style="margin-top: 4px; padding: 4px 8px; background: #4CAF50; color: white; border: none; cursor: pointer; border-radius: 3px;">
                        Simpan
                    </button>
                </div>';
                
                $catatanText = $item->catatan 
                    ? '<span style="color: #666;">' . htmlspecialchars($item->catatan) . '</span>'
                    : '<span style="color: #ccc;">-</span>';
                
                $editUrl = route('staff.sertifikat.edit', $item);
                $deleteUrl = route('staff.sertifikat.destroy', $item);
                $csrfToken = csrf_token();
                
                $html .= "<tr>
                    <td>{$no}</td>
                    <td>{$item->nomor_sertifikat}</td>
                    <td>{$item->nama_pemilik}</td>
                    <td>{$tanggal}</td>
                    <td>{$fileLinks}</td>
                    <td>{$fotoTtd}</td>
                    <td>{$statusHtml}</td>
                    <td>{$catatanText}</td>
                    <td>
                        <a href=\"{$editUrl}\">Edit</a> | 
                        <form action=\"{$deleteUrl}\" method=\"POST\" style=\"display: inline;\" onsubmit=\"return confirm('Yakin ingin menghapus?')\">
                            <input type=\"hidden\" name=\"_token\" value=\"{$csrfToken}\">
                            <input type=\"hidden\" name=\"_method\" value=\"DELETE\">
                            <button type=\"submit\">Hapus</button>
                        </form>
                    </td>
                </tr>";
            }
            
            if ($sertifikats->isEmpty()) {
                $html = '<tr><td colspan="9">Belum ada data sertifikat</td></tr>';
            }
            
            $pagination = $sertifikats->links()->render();
            
            return response()->json([
                'html' => $html,
                'pagination' => $pagination
            ]);
        }

        return view('staff.sertifikat.index', compact('sertifikats', 'query'));
    }

    public function updateStatus(Request $request, $uuid)
    {
        $sertifikat = Sertifikat::where('uuid', $uuid)->firstOrFail();
        
        $request->validate([
            'status' => 'required|in:pending,selesai',
            'catatan' => 'nullable|string'
        ]);

        $sertifikat->status = $request->status;
        
        // Jika status pending, simpan catatan
        if ($request->status === 'pending') {
            $sertifikat->catatan = $request->catatan;
        } else {
            // Jika selesai, hapus catatan
            $sertifikat->catatan = null;
        }
        
        $sertifikat->save();

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diupdate'
        ]);
    }

    public function create()
    {
        return view('staff.sertifikat.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_sertifikat' => 'required|unique:sertifikats,nomor_sertifikat',
            'nama_pemilik' => 'required',
            'tanggal_terbit' => 'required|date',
            'judul_dokumen' => 'required',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'file_warkah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'foto_ttd' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'status' => 'required|in:pending,selesai',
            'catatan' => 'nullable|string'
        ]);

        $data = $request->only(['nomor_sertifikat', 'nama_pemilik', 'tanggal_terbit', 'judul_dokumen', 'status', 'catatan']);

        if ($request->hasFile('file_sertifikat')) {
            $data['file_sertifikat'] = $request->file('file_sertifikat')->store('sertifikat/files', 'public');
        }

        if ($request->hasFile('file_warkah')) {
            $data['file_warkah'] = $request->file('file_warkah')->store('sertifikat/warkah', 'public');
        }

        if ($request->hasFile('foto_ttd')) {
            $data['foto_ttd'] = $request->file('foto_ttd')->store('sertifikat/ttd', 'public');
        }

        Sertifikat::create($data);

        return redirect()->route('staff.sertifikat.index')->with('success', 'Sertifikat berhasil ditambahkan');
    }

    public function edit(Sertifikat $sertifikat)
    {
        return view('staff.sertifikat.form', compact('sertifikat'));
    }

    public function update(Request $request, Sertifikat $sertifikat)
    {
        $request->validate([
            'nomor_sertifikat' => 'required|unique:sertifikats,nomor_sertifikat,' . $sertifikat->id,
            'nama_pemilik' => 'required',
            'tanggal_terbit' => 'required|date',
            'judul_dokumen' => 'required',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'file_warkah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'foto_ttd' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'status' => 'required|in:pending,selesai',
            'catatan' => 'nullable|string'
        ]);

        $data = $request->only(['nomor_sertifikat', 'nama_pemilik', 'tanggal_terbit', 'judul_dokumen', 'status', 'catatan']);

        if ($request->hasFile('file_sertifikat')) {
            if ($sertifikat->file_sertifikat) {
                Storage::disk('public')->delete($sertifikat->file_sertifikat);
            }
            $data['file_sertifikat'] = $request->file('file_sertifikat')->store('sertifikat/files', 'public');
        }

        if ($request->hasFile('file_warkah')) {
            if ($sertifikat->file_warkah) {
                Storage::disk('public')->delete($sertifikat->file_warkah);
            }
            $data['file_warkah'] = $request->file('file_warkah')->store('sertifikat/warkah', 'public');
        }

        if ($request->hasFile('foto_ttd')) {
            if ($sertifikat->foto_ttd) {
                Storage::disk('public')->delete($sertifikat->foto_ttd);
            }
            $data['foto_ttd'] = $request->file('foto_ttd')->store('sertifikat/ttd', 'public');
        }

        $sertifikat->update($data);

        return redirect()->route('staff.sertifikat.index')->with('success', 'Sertifikat berhasil diupdate');
    }

    public function destroy(Sertifikat $sertifikat)
    {
        if ($sertifikat->file_sertifikat) {
            Storage::disk('public')->delete($sertifikat->file_sertifikat);
        }
        if ($sertifikat->file_warkah) {
            Storage::disk('public')->delete($sertifikat->file_warkah);
        }
        if ($sertifikat->foto_ttd) {
            Storage::disk('public')->delete($sertifikat->foto_ttd);
        }

        $sertifikat->delete();

        return redirect()->route('staff.sertifikat.index')->with('success', 'Sertifikat berhasil dihapus');
    }
}