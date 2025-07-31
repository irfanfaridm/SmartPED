<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndihomeDocumentController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $lokasiList = \App\Models\IndihomeDocument::select('lokasi')->distinct()->pluck('lokasi');
        $query = \App\Models\IndihomeDocument::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama_dokumen', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('lokasi', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('keterangan', 'LIKE', '%' . $searchTerm . '%');
            });
        }
        
        // Filter berdasarkan lokasi
        if ($request->filled('lokasi')) {
            $query->where('lokasi', $request->lokasi);
        }
        
        // Filter berdasarkan tanggal
        if ($request->filled('tanggal')) {
            $now = now();
            switch ($request->tanggal) {
                case 'hari_ini':
                    $query->whereDate('created_at', $now->toDateString());
                    break;
                case 'minggu_ini':
                    $query->whereBetween('created_at', [$now->startOfWeek(), $now->endOfWeek()]);
                    break;
                case 'bulan_ini':
                    $query->whereMonth('created_at', $now->month)
                          ->whereYear('created_at', $now->year);
                    break;
                case 'tahun_ini':
                    $query->whereYear('created_at', $now->year);
                    break;
            }
        }
        
        $documents = $query->orderBy('created_at', 'desc')->get();
        return view('indihome.index', compact('documents', 'lokasiList'));
    }

    public function create()
    {
        // Ambil lokasi unik dari dokumen yang sudah ada untuk dropdown
        $lokasiList = \App\Models\IndihomeDocument::select('lokasi')->distinct()->pluck('lokasi');
        return view('indihome.create', compact('lokasiList'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        // Tentukan lokasi yang akan digunakan
        $lokasi = $request->lokasi ?: $request->lokasi_new;
        
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'file' => 'required|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:10240',
            'keterangan' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'selected_date' => 'nullable|date',
        ]);

        // Validasi lokasi
        if (empty($lokasi)) {
            return back()->withErrors(['lokasi' => 'Lokasi harus diisi. Pilih dari dropdown atau ketik lokasi baru.'])->withInput();
        }

        $filePath = $request->file('file')->store('indihome_documents', 'public');

        $doc = new \App\Models\IndihomeDocument();
        $doc->nama_dokumen = $request->nama_dokumen;
        $doc->lokasi = $lokasi;
        $doc->latitude = $request->latitude;
        $doc->longitude = $request->longitude;
        $doc->file_path = $filePath;
        $doc->keterangan = $request->keterangan;
        $doc->user_id = auth()->id();
        
        // Set custom date if provided
        if ($request->filled('selected_date')) {
            $doc->created_at = $request->selected_date . ' ' . now()->format('H:i:s');
            $doc->updated_at = $request->selected_date . ' ' . now()->format('H:i:s');
        }
        
        $doc->save();

        return redirect()->route('indihome.index')->with('success', 'Dokumen berhasil diupload!');
    }

    public function edit($id)
    {
        $document = \App\Models\IndihomeDocument::findOrFail($id);
        $lokasiList = \App\Models\IndihomeDocument::select('lokasi')->distinct()->pluck('lokasi');
        return view('indihome.edit', compact('document', 'lokasiList'));
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $document = \App\Models\IndihomeDocument::findOrFail($id);
        
        // Tentukan lokasi yang akan digunakan
        $lokasi = $request->lokasi ?: $request->lokasi_new;
        
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'file' => 'nullable|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:10240',
            'keterangan' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'selected_date' => 'nullable|date',
        ]);

        // Validasi lokasi
        if (empty($lokasi)) {
            return back()->withErrors(['lokasi' => 'Lokasi harus diisi. Pilih dari dropdown atau ketik lokasi baru.'])->withInput();
        }

        $document->nama_dokumen = $request->nama_dokumen;
        $document->lokasi = $lokasi;
        $document->latitude = $request->latitude;
        $document->longitude = $request->longitude;
        $document->keterangan = $request->keterangan;

        // Update file jika ada
        if ($request->hasFile('file')) {
            // Hapus file lama
            if ($document->file_path && \Storage::disk('public')->exists($document->file_path)) {
                \Storage::disk('public')->delete($document->file_path);
            }
            
            $filePath = $request->file('file')->store('indihome_documents', 'public');
            $document->file_path = $filePath;
        }

        // Set custom date if provided
        if ($request->filled('selected_date')) {
            $document->created_at = $request->selected_date . ' ' . now()->format('H:i:s');
            $document->updated_at = $request->selected_date . ' ' . now()->format('H:i:s');
        }

        $document->save();

        return redirect()->route('indihome.index')->with('success', 'Dokumen berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $document = \App\Models\IndihomeDocument::findOrFail($id);
        
        // Hapus file dari storage
        if ($document->file_path && \Storage::disk('public')->exists($document->file_path)) {
            \Storage::disk('public')->delete($document->file_path);
        }
        
        $document->delete();

        return redirect()->route('indihome.index')->with('success', 'Dokumen berhasil dihapus!');
    }
} 