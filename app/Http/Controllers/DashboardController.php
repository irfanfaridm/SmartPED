<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HemDocument;
use App\Models\QeDocument;
use App\Models\IndihomeDocument;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data statistik dari database
        $hemDocuments = HemDocument::count();
        $qeDocuments = QeDocument::count();
        $indihomeDocuments = IndihomeDocument::count();
        $totalDocuments = $hemDocuments + $qeDocuments + $indihomeDocuments;
        $recentDocuments = HemDocument::latest()->take(5)->get();
        
        // Pertumbuhan HEM
        $lastMonthHemCount = HemDocument::where('created_at', '>=', now()->subMonth())->count();
        $hemGrowthPercentage = $lastMonthHemCount > 0
            ? round((($hemDocuments - $lastMonthHemCount) / $lastMonthHemCount) * 100)
            : 0;

        // Pertumbuhan QE
        $lastMonthQeCount = QeDocument::where('created_at', '>=', now()->subMonth())->count();
        $qeGrowthPercentage = $lastMonthQeCount > 0
            ? round((($qeDocuments - $lastMonthQeCount) / $lastMonthQeCount) * 100)
            : 0;
        
        // Pertumbuhan INDIHOME
        $lastMonthIndihomeCount = IndihomeDocument::where('created_at', '>=', now()->subMonth())->count();
        $indihomeGrowthPercentage = $lastMonthIndihomeCount > 0
            ? round((($indihomeDocuments - $lastMonthIndihomeCount) / $lastMonthIndihomeCount) * 100)
            : 0;
        
        // Aktivitas terbaru
        // Ambil 5 aktivitas HEM terakhir
        $hemActivities = HemDocument::with('user')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($doc) {
                return [
                    'type' => 'HEM',
                    'message' => "Dokumen {$doc->nama_dokumen} diupload",
                    'time' => $doc->created_at->diffForHumans(),
                    'color' => 'green'
                ];
            });

        // Ambil 5 aktivitas QE terakhir
        $qeActivities = QeDocument::with('user')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($doc) {
                return [
                    'type' => 'QE',
                    'message' => "Dokumen {$doc->nama_dokumen} diupload",
                    'time' => $doc->created_at->diffForHumans(),
                    'color' => 'blue'
                ];
            });

        // Ambil 5 aktivitas INDIHOME terakhir
        $indihomeActivities = IndihomeDocument::with('user')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($doc) {
                return [
                    'type' => 'INDIHOME',
                    'message' => "Dokumen {$doc->nama_dokumen} diupload",
                    'time' => $doc->created_at->diffForHumans(),
                    'color' => 'purple'
                ];
            });

        // Gabungkan dan ambil 5 terbaru dari ketiganya
        $recentActivities = collect($hemActivities)
            ->merge($qeActivities)
            ->merge($indihomeActivities)
            ->sortByDesc('time')
            ->take(5)
            ->values();

        return view('dashboard', compact(
            'totalDocuments',
            'hemDocuments',
            'qeDocuments',
            'indihomeDocuments',
            'hemGrowthPercentage',
            'qeGrowthPercentage',
            'indihomeGrowthPercentage',
            'recentActivities'
        ));
    }
} 