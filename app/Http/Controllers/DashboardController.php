<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_buku' => 0,
            'total_anggota' => 0,
            'peminjaman_aktif' => 0,
        ];

        try {
            $response = Http::get(config('services.internal_api.base_url').'/api/stats');

            if ($response->successful()) {
                $stats = $response->json();
            }
        } catch (ConnectionException $e) {
            // Server internal API (port 8011) tidak bisa dihubungi — fallback ke query langsung
            $stats = [
                'total_buku' => Book::count(),
                'total_anggota' => Member::count(),
                'peminjaman_aktif' => Loan::where('status', 'dipinjam')->count(),
            ];
        }

        // Ambil kategori (untuk Browse the stacks)
        $categories = Category::withCount('books')->get();

        // Ambil buku terbaru
        $latestBooks = Book::with('category')->latest()->take(8)->get();

        return view('dashboard', compact('stats', 'categories', 'latestBooks'));
    }
}
