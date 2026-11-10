<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['member', 'user', 'loanItems.book'])->latest('id')->paginate(10);

        return view('loans.index', compact('loans'));
    }

    public function report(Request $request)
    {
        $loans = Loan::with(['member', 'user', 'loanItems.book'])->latest('id')->paginate(10);

        $totalLoans = Loan::count();
        $totalDipinjam = Loan::where('status', 'dipinjam')->count();
        $totalDikembalikan = Loan::where('status', 'dikembalikan')->count();
        $totalTerlambat = Loan::where('status', 'terlambat')->count();
        $totalDenda = Loan::all()->sum('denda');

        return view('loans.report', compact(
            'loans',
            'totalLoans',
            'totalDipinjam',
            'totalDikembalikan',
            'totalTerlambat',
            'totalDenda'
        ));
    }

    public function create()
    {
        $members = Member::all();
        $books = Book::where('stok', '>', 0)->get();
        $users = User::all();

        return view('loans.create', compact('members', 'books', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|integer|exists:members,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'book_ids' => 'required|array|min:1',
            'book_ids.*' => 'integer|exists:books,id',
        ]);

        $loan = Loan::create([
            'member_id' => $validated['member_id'],
            'user_id' => auth()->id(),
            'tanggal_pinjam' => $validated['tanggal_pinjam'],
            'tanggal_kembali' => $validated['tanggal_kembali'],
            'status' => 'dipinjam',
            'denda' => 0,
        ]);

        foreach ($validated['book_ids'] as $bookId) {
            $loan->loanItems()->create(['book_id' => $bookId]);
            $book = Book::find($bookId);
            if ($book && $book->stok > 0) {
                $book->decrement('stok');
            }
        }

        return redirect()->route('loans.index')
            ->with('success', 'Transaksi peminjaman berhasil dibuat.');
    }

    public function show(string $id)
    {
        $loan = Loan::with(['member', 'user', 'loanItems.book'])->findOrFail($id);

        return view('loans.show', compact('loan'));
    }

    public function edit(string $id)
    {
        $loan = Loan::with(['member', 'user', 'loanItems.book'])->findOrFail($id);

        return view('loans.edit', compact('loan'));
    }

    public function update(Request $request, string $id)
    {
        $loan = Loan::findOrFail($id);

        $validated = $request->validate([
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'status' => 'required|in:dipinjam,dikembalikan,terlambat',
        ], [
            'tanggal_kembali.required' => 'Tanggal kembali wajib diisi.',
            'tanggal_kembali.after_or_equal' => 'Tanggal kembali tidak boleh sebelum tanggal pinjam.',
        ]);

        $tanggalBatas = Carbon::parse($validated['tanggal_kembali'])->startOfDay();
        $hariIni = Carbon::now()->startOfDay();

        if ($validated['status'] === 'dikembalikan') {
            $tglDikembalikan = $loan->tanggal_dikembalikan ? Carbon::parse($loan->tanggal_dikembalikan)->startOfDay() : $hariIni;
            $validated['tanggal_dikembalikan'] = $tglDikembalikan->toDateString();
            if ($tglDikembalikan->greaterThan($tanggalBatas)) {
                $validated['denda'] = abs((int) $tanggalBatas->diffInDays($tglDikembalikan)) * 2000;
            } else {
                $validated['denda'] = 0;
            }
        } elseif ($validated['status'] === 'terlambat') {
            if ($hariIni->greaterThan($tanggalBatas)) {
                $validated['denda'] = abs((int) $tanggalBatas->diffInDays($hariIni)) * 2000;
            } else {
                $validated['denda'] = 2000;
            }
        } else {
            $validated['denda'] = 0;
        }

        $loan->update($validated);

        return redirect()->route('loans.index')
            ->with('success', 'Transaksi peminjaman berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $loan = Loan::findOrFail($id);
        $loan->loanItems()->delete();
        $loan->delete();

        return redirect()->route('loans.index')
            ->with('success', 'Transaksi peminjaman berhasil dihapus.');
    }

    public function kembalikan($id)
    {
        $loan = Loan::findOrFail($id);

        if ($loan->status === 'dikembalikan') {
            return redirect()->route('loans.index')
                ->with('success', 'Buku ini sudah berstatus dikembalikan.');
        }

        foreach ($loan->loanItems as $item) {
            $book = Book::find($item->book_id);
            if ($book) {
                $book->increment('stok');
            }
        }

        $tanggalBatas = Carbon::parse($loan->tanggal_kembali)->startOfDay();
        $hariIni = Carbon::now()->startOfDay();
        $denda = 0;

        if ($hariIni->greaterThan($tanggalBatas)) {
            $selisihHari = abs((int) $tanggalBatas->diffInDays($hariIni));
            $denda = $selisihHari * 2000;
        }

        $loan->update([
            'status' => 'dikembalikan',
            'tanggal_dikembalikan' => $hariIni->toDateString(),
            'denda' => $denda,
        ]);

        $message = 'Buku berhasil dikembalikan.';
        if ($denda > 0) {
            $message .= ' Denda keterlambatan: Rp ' . number_format($denda, 0, ',', '.') . ' (' . $selisihHari . ' hari terlambat)';
        }

        return redirect()->route('loans.index')
            ->with('success', $message);
    }
}
