<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AktaNotaris;
use Illuminate\Support\Facades\Storage;

class AktaNotarisController extends Controller
{
    // 🔹 Menampilkan daftar akta
    public function index()
    {
        $aktaList = AktaNotaris::orderBy('tanggal_akta', 'desc')->paginate(50);
        return view('staff.akta_notaris.index', compact('aktaList'));
    }

    // 🔹 Tampilkan form tambah akta
    public function create()
    {
        return view('staff.akta_notaris.form');
    }

    // 🔹 Simpan data akta
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'nomor_akta' => 'required|string|max:50',
            'tanggal_akta' => 'required|date',
            'penghadap.*' => 'required|string|max:255',
            'saksi1' => 'nullable|string|max:255',
            'saksi2' => 'nullable|string|max:255',
            'file_akta' => 'required|file|mimes:pdf,doc,docx',
            'foto_ttd' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'file_sk' => 'nullable|file|mimes:pdf,doc,docx',
            'file_warkah' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        $akta = new AktaNotaris();

        $akta->judul = $request->judul;
        $akta->nomor_akta = $request->nomor_akta;
        $akta->tanggal_akta = $request->tanggal_akta;
        $akta->penghadap = json_encode($request->penghadap);
        $akta->saksi1 = $request->saksi1;
        $akta->saksi2 = $request->saksi2;

        $folder = 'akta_files';

        if ($request->hasFile('file_akta')) {
            $file = $request->file('file_akta');
            $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $akta->file_akta = $file->storeAs($folder, $filename, 'public');
        }

        if ($request->hasFile('foto_ttd')) {
            $file = $request->file('foto_ttd');
            $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $akta->foto_ttd = $file->storeAs($folder, $filename, 'public');
        }

        if ($request->hasFile('file_sk')) {
            $file = $request->file('file_sk');
            $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $akta->file_sk = $file->storeAs($folder, $filename, 'public');
        }

        if ($request->hasFile('file_warkah')) {
            $file = $request->file('file_warkah');
            $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $akta->file_warkah = $file->storeAs($folder, $filename, 'public');
        }

        $akta->save();

        return redirect()->route('staff.akta-notaris.index')->with('success', 'Data akta berhasil disimpan.');
    }

    // 🔹 Edit data akta berdasarkan UUID
    public function edit($uuid)
    {
        $akta = AktaNotaris::where('uuid', $uuid)->firstOrFail();
        $akta->penghadap = json_decode($akta->penghadap, true) ?? [];
        return view('staff.akta_notaris.edit', compact('akta'));
    }

    // 🔹 Update data akta berdasarkan UUID
    public function update(Request $request, $uuid)
    {
        $akta = AktaNotaris::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'judul' => 'required|string|max:255',
            'nomor_akta' => 'required|string|max:50',
            'tanggal_akta' => 'required|date',
            'penghadap.*' => 'required|string|max:255',
            'saksi1' => 'nullable|string|max:255',
            'saksi2' => 'nullable|string|max:255',
            'file_akta' => 'nullable|file|mimes:pdf,doc,docx',
            'foto_ttd' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file_sk' => 'nullable|file|mimes:pdf,doc,docx',
            'file_warkah' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        $akta->judul = $request->judul;
        $akta->nomor_akta = $request->nomor_akta;
        $akta->tanggal_akta = $request->tanggal_akta;
        $akta->penghadap = json_encode($request->penghadap);
        $akta->saksi1 = $request->saksi1;
        $akta->saksi2 = $request->saksi2;

        $folder = 'akta_files';

        if ($request->hasFile('file_akta')) {
            if ($akta->file_akta) Storage::disk('public')->delete($akta->file_akta);
            $filename = time().'_'.uniqid().'_'.$request->file('file_akta')->getClientOriginalName();
            $akta->file_akta = $request->file('file_akta')->storeAs($folder, $filename, 'public');
        }

        if ($request->hasFile('foto_ttd')) {
            if ($akta->foto_ttd) Storage::disk('public')->delete($akta->foto_ttd);
            $filename = time().'_'.uniqid().'_'.$request->file('foto_ttd')->getClientOriginalName();
            $akta->foto_ttd = $request->file('foto_ttd')->storeAs($folder, $filename, 'public');
        }

        if ($request->hasFile('file_sk')) {
            if ($akta->file_sk) Storage::disk('public')->delete($akta->file_sk);
            $filename = time().'_'.uniqid().'_'.$request->file('file_sk')->getClientOriginalName();
            $akta->file_sk = $request->file('file_sk')->storeAs($folder, $filename, 'public');
        }

        if ($request->hasFile('file_warkah')) {
            if ($akta->file_warkah) Storage::disk('public')->delete($akta->file_warkah);
            $filename = time().'_'.uniqid().'_'.$request->file('file_warkah')->getClientOriginalName();
            $akta->file_warkah = $request->file('file_warkah')->storeAs($folder, $filename, 'public');
        }

        $akta->save();

        return redirect()->route('staff.akta-notaris.index')->with('success', 'Data akta berhasil diperbarui.');
    }

    public function destroy($uuid)
    {
        $akta = AktaNotaris::where('uuid', $uuid)->firstOrFail();

        $files = ['file_akta', 'foto_ttd', 'file_sk', 'file_warkah'];
        foreach ($files as $file) {
            if ($akta->$file) {
                Storage::disk('public')->delete($akta->$file);
            }
        }

        $akta->delete();

        return redirect()->route('staff.akta-notaris.index')->with('success', 'Data akta berhasil dihapus.');
    }

    // 🔹 LIVE SEARCH
    public function search(Request $request)
    {
        $query = $request->get('query', '');
        
        $aktaList = AktaNotaris::query()
            ->where(function($q) use ($query) {
                $q->whereRaw('LOWER(judul) LIKE ?', ['%' . strtolower($query) . '%'])
                ->orWhereRaw('LOWER(nomor_akta) LIKE ?', ['%' . strtolower($query) . '%'])
                ->orWhereRaw('LOWER(penghadap) LIKE ?', ['%' . strtolower($query) . '%'])
                ->orWhereRaw('LOWER(saksi1) LIKE ?', ['%' . strtolower($query) . '%'])
                ->orWhereRaw('LOWER(saksi2) LIKE ?', ['%' . strtolower($query) . '%']);
            })
            ->orderBy('tanggal_akta', 'desc')
            ->paginate(50)
            ->appends(['query' => $query]);

        if ($request->ajax()) {
            return view('staff.akta_notaris.partials.tabel-akta', compact('aktaList'))->render();
        }

        return view('staff.akta_notaris.index', compact('aktaList'));
    }
}