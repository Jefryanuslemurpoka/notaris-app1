<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Legnot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LegnotController extends Controller
{
    public function index()
    {
        $legnots = Legnot::orderBy('tanggal', 'desc')->paginate(50);
        return view('staff.legnot.index', compact('legnots'));
    }

    public function create()
    {
        return view('staff.legnot.form', [
            'legnot' => null,
            'isEdit' => false
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_legalisasi' => 'required|string|unique:legnots,nomor_legalisasi',
            'judul' => 'required|string',
            'nama_klien' => 'required|string',
            'tanggal' => 'required|date',
            'file_legnot' => 'nullable|file|mimes:pdf,doc,docx|max:10240'
        ]);

        if ($request->hasFile('file_legnot')) {
            $file = $request->file('file_legnot');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('legnot', $filename, 'public');
            $validated['file_legnot'] = $path;
        }

        Legnot::create($validated);

        return redirect()->route('staff.legnot.index')
            ->with('success', 'Data Legnot berhasil ditambahkan!');
    }

    public function edit(Legnot $legnot)
    {
        return view('staff.legnot.form', [
            'legnot' => $legnot,
            'isEdit' => true
        ]);
    }

    public function update(Request $request, Legnot $legnot)
    {
        $validated = $request->validate([
            'nomor_legalisasi' => 'required|string|unique:legnots,nomor_legalisasi,' . $legnot->id,
            'judul' => 'required|string',
            'nama_klien' => 'required|string',
            'tanggal' => 'required|date',
            'file_legnot' => 'nullable|file|mimes:pdf,doc,docx|max:10240'
        ]);

        if ($request->hasFile('file_legnot')) {
            // Hapus file lama jika ada
            if ($legnot->file_legnot && Storage::disk('public')->exists($legnot->file_legnot)) {
                Storage::disk('public')->delete($legnot->file_legnot);
            }

            $file = $request->file('file_legnot');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('legnot', $filename, 'public');
            $validated['file_legnot'] = $path;
        }

        $legnot->update($validated);

        return redirect()->route('staff.legnot.index')
            ->with('success', 'Data Legnot berhasil diupdate!');
    }

    public function destroy(Legnot $legnot)
    {
        // Hapus file jika ada
        if ($legnot->file_legnot && Storage::disk('public')->exists($legnot->file_legnot)) {
            Storage::disk('public')->delete($legnot->file_legnot);
        }

        $legnot->delete();

        return redirect()->route('staff.legnot.index')
            ->with('success', 'Data Legnot berhasil dihapus!');
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        
        $legnots = Legnot::where('nomor_legalisasi', 'like', "%{$query}%")
            ->orWhere('judul', 'like', "%{$query}%")
            ->orWhere('nama_klien', 'like', "%{$query}%")
            ->orderBy('tanggal', 'desc')
            ->paginate(50)
            ->appends(['q' => $query]);

        return view('staff.legnot.index', compact('legnots'));
    }
}