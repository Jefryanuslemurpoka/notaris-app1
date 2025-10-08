<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\AktaPpat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AktaPpatController extends Controller
{
    public function create()
    {
        return view('staff.akta_ppat.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_akta' => 'required|string|max:255',
            'nomor_akta' => 'required|string|max:255',
            'tanggal_akta' => 'required|date',
            'pihak_1' => 'required|string|max:255',
            'pihak_2' => 'required|string|max:255',
            'saksi_1' => 'nullable|string|max:255',
            'saksi_2' => 'nullable|string|max:255',
            'file_akta' => 'required|file|mimes:pdf|max:10240',
            'foto_ttd_para_pihak' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'warkah' => 'nullable|file|mimes:pdf|max:10240'
        ]);

        $fileAktaPath = $request->file('file_akta')->store('akta_ppat', 'public');
        
        $fotoTtdPath = null;
        if ($request->hasFile('foto_ttd_para_pihak')) {
            $fotoTtdPath = $request->file('foto_ttd_para_pihak')->store('foto_ttd', 'public');
        }

        $warkahPath = null;
        if ($request->hasFile('warkah')) {
            $warkahPath = $request->file('warkah')->store('warkah', 'public');
        }

        AktaPpat::create([
            'judul_akta' => $request->judul_akta,
            'nomor_akta' => $request->nomor_akta,
            'tanggal_akta' => $request->tanggal_akta,
            'pihak_1' => $request->pihak_1,
            'pihak_2' => $request->pihak_2,
            'saksi_1' => $request->saksi_1,
            'saksi_2' => $request->saksi_2,
            'file_akta' => $fileAktaPath,
            'foto_ttd_para_pihak' => $fotoTtdPath,
            'warkah' => $warkahPath
        ]);

        return redirect()->route('staff.akta-ppat.index')->with('success', 'Akta PPAT berhasil disimpan');
    }

    public function index()
    {
        $aktaPpat = AktaPpat::latest()->paginate(50); // ✅ ubah dari get() jadi paginate(50)
        return view('staff.akta_ppat.index', compact('aktaPpat'));
    }

    // ✅ UBAH: gunakan type-hinted model binding
    public function edit(AktaPpat $aktaPpat)
    {
        return view('staff.akta_ppat.form', ['akta' => $aktaPpat]);
    }

    // ✅ UBAH: gunakan type-hinted model binding
    public function update(Request $request, AktaPpat $aktaPpat)
    {
        $request->validate([
            'judul_akta' => 'required|string|max:255',
            'nomor_akta' => 'required|string|max:255',
            'tanggal_akta' => 'required|date',
            'pihak_1' => 'required|string|max:255',
            'pihak_2' => 'required|string|max:255',
            'saksi_1' => 'nullable|string|max:255',
            'saksi_2' => 'nullable|string|max:255',
            'file_akta' => 'nullable|file|mimes:pdf|max:10240',
            'foto_ttd_para_pihak' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'warkah' => 'nullable|file|mimes:pdf|max:10240'
        ]);

        $data = [
            'judul_akta' => $request->judul_akta,
            'nomor_akta' => $request->nomor_akta,
            'tanggal_akta' => $request->tanggal_akta,
            'pihak_1' => $request->pihak_1,
            'pihak_2' => $request->pihak_2,
            'saksi_1' => $request->saksi_1,
            'saksi_2' => $request->saksi_2,
        ];

        if ($request->hasFile('file_akta')) {
            Storage::disk('public')->delete($aktaPpat->file_akta);
            $data['file_akta'] = $request->file('file_akta')->store('akta_ppat', 'public');
        }

        if ($request->hasFile('foto_ttd_para_pihak')) {
            if ($aktaPpat->foto_ttd_para_pihak) {
                Storage::disk('public')->delete($aktaPpat->foto_ttd_para_pihak);
            }
            $data['foto_ttd_para_pihak'] = $request->file('foto_ttd_para_pihak')->store('foto_ttd', 'public');
        }

        if ($request->hasFile('warkah')) {
            if ($aktaPpat->warkah) {
                Storage::disk('public')->delete($aktaPpat->warkah);
            }
            $data['warkah'] = $request->file('warkah')->store('warkah', 'public');
        }

        $aktaPpat->update($data);

        return redirect()->route('staff.akta-ppat.index')->with('success', 'Akta PPAT berhasil diupdate');
    }

    // ✅ UBAH: gunakan type-hinted model binding
    public function destroy(AktaPpat $aktaPpat)
    {
        Storage::disk('public')->delete($aktaPpat->file_akta);
        if ($aktaPpat->foto_ttd_para_pihak) {
            Storage::disk('public')->delete($aktaPpat->foto_ttd_para_pihak);
        }
        if ($aktaPpat->warkah) {
            Storage::disk('public')->delete($aktaPpat->warkah);
        }
        
        $aktaPpat->delete();

        return redirect()->route('staff.akta-ppat.index')->with('success', 'Akta PPAT berhasil dihapus');
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        
        $aktaPpat = AktaPpat::where('judul_akta', 'LIKE', "%{$query}%")
            ->orWhere('nomor_akta', 'LIKE', "%{$query}%")
            ->orWhere('pihak_1', 'LIKE', "%{$query}%")
            ->orWhere('pihak_2', 'LIKE', "%{$query}%")
            ->latest()
            ->paginate(50);
        
        return view('staff.akta_ppat.index', compact('aktaPpat'));
    }
}