<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('indihome_documents', function (Blueprint $table) {
            // Field untuk studi kasus Edge OTN dan Mini OLT
            $table->string('site_code')->nullable()->after('lokasi')->comment('Kode site seperti TSEL BOO821');
            $table->enum('project_type', ['edge_otn', 'mini_olt', 'ftth', 'bts_upgrade', 'other'])->nullable()->after('site_code')->comment('Jenis proyek implementasi');
            $table->enum('implementation_status', ['planning', 'implementation', 'testing', 'completed', 'on_hold', 'cancelled'])->nullable()->after('project_type')->comment('Status implementasi proyek');
            $table->text('equipment_specs')->nullable()->after('implementation_status')->comment('Spesifikasi perangkat yang digunakan');
            $table->text('capacity_info')->nullable()->after('equipment_specs')->comment('Informasi kapasitas dan demand');
            $table->string('order_reference')->nullable()->after('capacity_info')->comment('Referensi order microdemand');
            $table->enum('document_category', ['technical_spec', 'progress_report', 'testing_result', 'completion_report', 'maintenance_log', 'other'])->nullable()->after('order_reference')->comment('Kategori dokumen');
            $table->text('technical_details')->nullable()->after('document_category')->comment('Detail teknis implementasi');
            $table->date('completion_date')->nullable()->after('technical_details')->comment('Tanggal selesai implementasi');
            $table->text('remarks')->nullable()->after('completion_date')->comment('Catatan tambahan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('indihome_documents', function (Blueprint $table) {
            $table->dropColumn([
                'site_code',
                'project_type',
                'implementation_status',
                'equipment_specs',
                'capacity_info',
                'order_reference',
                'document_category',
                'technical_details',
                'completion_date',
                'remarks'
            ]);
        });
    }
}; 