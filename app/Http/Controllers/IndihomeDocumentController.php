<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\DocumentUploaded;

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
                  ->orWhere('keterangan', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('site_code', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('order_reference', 'LIKE', '%' . $searchTerm . '%');
            });
        }
        
        // Filter berdasarkan lokasi
        if ($request->filled('lokasi')) {
            $query->where('lokasi', $request->lokasi);
        }
        
        // Filter berdasarkan project type
        if ($request->filled('project_type')) {
            $query->where('project_type', $request->project_type);
        }
        
        // Filter berdasarkan implementation status
        if ($request->filled('implementation_status')) {
            $query->where('implementation_status', $request->implementation_status);
        }
        
        // Filter berdasarkan document category
        if ($request->filled('document_category')) {
            $query->where('document_category', $request->document_category);
        }
        
        // Filter berdasarkan site code
        if ($request->filled('site_code')) {
            $query->bySiteCode($request->site_code);
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
        
        $documents = $query->with('user')->orderBy('created_at', 'desc')->get();
        
        // Filter documents with coordinates for map display
        $documentsWithCoords = $documents->where('latitude', '!=', null)->where('longitude', '!=', null);
        
        // Get filter options for view
        $projectTypes = \App\Models\IndihomeDocument::PROJECT_TYPES;
        $implementationStatuses = \App\Models\IndihomeDocument::IMPLEMENTATION_STATUSES;
        $documentCategories = \App\Models\IndihomeDocument::DOCUMENT_CATEGORIES;
        
        return view('indihome.index', compact(
            'documents', 
            'lokasiList', 
            'documentsWithCoords',
            'projectTypes',
            'implementationStatuses',
            'documentCategories'
        ));
    }

    public function create()
    {
        // Ambil daftar kabupaten/kota dari file data
        $lokasiList = include(app_path('Data/KabupatenKotaList.php'));
        // Ambil data koordinat
        $koordinatData = include(app_path('Data/KoordinatLokasi.php'));
        
        // Data untuk dropdown studi kasus
        $projectTypes = \App\Models\IndihomeDocument::PROJECT_TYPES;
        $implementationStatuses = \App\Models\IndihomeDocument::IMPLEMENTATION_STATUSES;
        $documentCategories = \App\Models\IndihomeDocument::DOCUMENT_CATEGORIES;
        
        return view('indihome.create', compact(
            'lokasiList', 
            'koordinatData',
            'projectTypes',
            'implementationStatuses',
            'documentCategories'
        ));
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
            // Validasi field baru
            'site_code' => 'nullable|string|max:100',
            'project_type' => 'nullable|in:edge_otn,mini_olt,ftth,bts_upgrade,other',
            'implementation_status' => 'nullable|in:planning,implementation,testing,completed,on_hold,cancelled',
            'equipment_specs' => 'nullable|string',
            'capacity_info' => 'nullable|string',
            'order_reference' => 'nullable|string|max:255',
            'document_category' => 'nullable|in:technical_spec,progress_report,testing_result,completion_report,maintenance_log,other',
            'technical_details' => 'nullable|string',
            'completion_date' => 'nullable|date',
            'remarks' => 'nullable|string',
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
        
        // Set field baru untuk studi kasus
        $doc->site_code = $request->site_code;
        $doc->project_type = $request->project_type;
        $doc->implementation_status = $request->implementation_status;
        $doc->equipment_specs = $request->equipment_specs;
        $doc->capacity_info = $request->capacity_info;
        $doc->order_reference = $request->order_reference;
        $doc->document_category = $request->document_category;
        $doc->technical_details = $request->technical_details;
        $doc->completion_date = $request->completion_date;
        $doc->remarks = $request->remarks;
        
        // Set custom date if provided
        if ($request->filled('selected_date')) {
            $doc->created_at = $request->selected_date . ' ' . now()->format('H:i:s');
            $doc->updated_at = $request->selected_date . ' ' . now()->format('H:i:s');
        }
        
        $doc->save();

        // Broadcast event untuk real-time notification
        event(new DocumentUploaded($doc, auth()->user()));

        return redirect()->route('indihome.index')->with('success', 'Dokumen berhasil diupload!');
    }

    public function edit($id)
    {
        $document = \App\Models\IndihomeDocument::findOrFail($id);
        
        // Cek apakah user yang login adalah pemilik dokumen
        if ($document->user_id !== auth()->id()) {
            return redirect()->route('indihome.index')
                ->with('error', 'Anda tidak memiliki izin untuk mengedit dokumen ini.');
        }
        
        // Ambil daftar kabupaten/kota dari file data
        $lokasiList = include(app_path('Data/KabupatenKotaList.php'));
        // Ambil data koordinat
        $koordinatData = include(app_path('Data/KoordinatLokasi.php'));
        
        // Data untuk dropdown studi kasus
        $projectTypes = \App\Models\IndihomeDocument::PROJECT_TYPES;
        $implementationStatuses = \App\Models\IndihomeDocument::IMPLEMENTATION_STATUSES;
        $documentCategories = \App\Models\IndihomeDocument::DOCUMENT_CATEGORIES;
        
        return view('indihome.edit', compact(
            'document', 
            'lokasiList', 
            'koordinatData',
            'projectTypes',
            'implementationStatuses',
            'documentCategories'
        ));
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $document = \App\Models\IndihomeDocument::findOrFail($id);
        
        // Cek apakah user yang login adalah pemilik dokumen
        if ($document->user_id !== auth()->id()) {
            return redirect()->route('indihome.index')
                ->with('error', 'Anda tidak memiliki izin untuk mengubah dokumen ini.');
        }
        
        // Tentukan lokasi yang akan digunakan
        $lokasi = $request->lokasi ?: $request->lokasi_new;
        
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'file' => 'nullable|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:10240',
            'keterangan' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'selected_date' => 'nullable|date',
            // Validasi field baru
            'site_code' => 'nullable|string|max:100',
            'project_type' => 'nullable|in:edge_otn,mini_olt,ftth,bts_upgrade,other',
            'implementation_status' => 'nullable|in:planning,implementation,testing,completed,on_hold,cancelled',
            'equipment_specs' => 'nullable|string',
            'capacity_info' => 'nullable|string',
            'order_reference' => 'nullable|string|max:255',
            'document_category' => 'nullable|in:technical_spec,progress_report,testing_result,completion_report,maintenance_log,other',
            'technical_details' => 'nullable|string',
            'completion_date' => 'nullable|date',
            'remarks' => 'nullable|string',
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

        // Update field baru untuk studi kasus
        $document->site_code = $request->site_code;
        $document->project_type = $request->project_type;
        $document->implementation_status = $request->implementation_status;
        $document->equipment_specs = $request->equipment_specs;
        $document->capacity_info = $request->capacity_info;
        $document->order_reference = $request->order_reference;
        $document->document_category = $request->document_category;
        $document->technical_details = $request->technical_details;
        $document->completion_date = $request->completion_date;
        $document->remarks = $request->remarks;

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
        
        // Cek apakah user yang login adalah pemilik dokumen
        if ($document->user_id !== auth()->id()) {
            return redirect()->route('indihome.index')
                ->with('error', 'Anda tidak memiliki izin untuk menghapus dokumen ini.');
        }
        
        // Hapus file dari storage
        if ($document->file_path && \Storage::disk('public')->exists($document->file_path)) {
            \Storage::disk('public')->delete($document->file_path);
        }
        
        $document->delete();

        return redirect()->route('indihome.index')->with('success', 'Dokumen berhasil dihapus!');
    }
}