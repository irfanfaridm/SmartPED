<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndihomeDocument extends Model
{
    protected $fillable = [
        'nama_dokumen',
        'lokasi',
        'latitude',
        'longitude',
        'file_path',
        'keterangan',
        'user_id',
        // Field baru untuk studi kasus
        'site_code',           // Kode site (contoh: TSEL BOO821)
        'project_type',        // Jenis proyek (Edge OTN, Mini OLT, dll)
        'implementation_status', // Status implementasi
        'equipment_specs',     // Spesifikasi perangkat
        'capacity_info',       // Informasi kapasitas
        'order_reference',     // Referensi order
        'document_category',   // Kategori dokumen
        'technical_details',   // Detail teknis
        'completion_date',     // Tanggal selesai
        'remarks'             // Catatan tambahan
    ];

    // Enum untuk project type
    const PROJECT_TYPES = [
        'edge_otn' => 'Edge OTN Implementation',
        'mini_olt' => 'Mini OLT Implementation',
        'ftth' => 'FTTH Deployment',
        'bts_upgrade' => 'BTS Upgrade',
        'other' => 'Other'
    ];

    // Enum untuk implementation status
    const IMPLEMENTATION_STATUSES = [
        'planning' => 'Planning',
        'implementation' => 'Implementation',
        'testing' => 'Testing',
        'completed' => 'Completed',
        'on_hold' => 'On Hold',
        'cancelled' => 'Cancelled'
    ];

    // Enum untuk document categories
    const DOCUMENT_CATEGORIES = [
        'technical_spec' => 'Technical Specification',
        'progress_report' => 'Progress Report',
        'testing_result' => 'Testing Result',
        'completion_report' => 'Completion Report',
        'maintenance_log' => 'Maintenance Log',
        'other' => 'Other'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Accessor untuk project type label
    public function getProjectTypeLabelAttribute()
    {
        return self::PROJECT_TYPES[$this->project_type] ?? 'Unknown';
    }

    // Accessor untuk implementation status label
    public function getImplementationStatusLabelAttribute()
    {
        return self::IMPLEMENTATION_STATUSES[$this->implementation_status] ?? 'Unknown';
    }

    // Accessor untuk document category label
    public function getDocumentCategoryLabelAttribute()
    {
        return self::DOCUMENT_CATEGORIES[$this->document_category] ?? 'Unknown';
    }

    // Scope untuk filter berdasarkan project type
    public function scopeByProjectType($query, $projectType)
    {
        return $query->where('project_type', $projectType);
    }

    // Scope untuk filter berdasarkan implementation status
    public function scopeByImplementationStatus($query, $status)
    {
        return $query->where('implementation_status', $status);
    }

    // Scope untuk filter berdasarkan document category
    public function scopeByDocumentCategory($query, $category)
    {
        return $query->where('document_category', $category);
    }

    // Scope untuk filter berdasarkan site code
    public function scopeBySiteCode($query, $siteCode)
    {
        return $query->where('site_code', 'LIKE', '%' . $siteCode . '%');
    }
} 