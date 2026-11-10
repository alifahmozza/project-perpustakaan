<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use App\Models\User;
use Carbon\Carbon;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $memberIds = Member::pluck('id');
        $userIds = User::pluck('id');
        $bookIds = Book::pluck('id');

        for ($i = 0; $i < 10; $i++) {
            $tanggalPinjam = now()->subDays(fake()->numberBetween(1, 30));
            $tanggalKembali = $tanggalPinjam->copy()->addDays(7);
            $status = fake()->randomElement(['dipinjam', 'dikembalikan', 'dikembalikan', 'terlambat']);
            $tanggalDikembalikan = null;
            $denda = 0;

            if ($status === 'dikembalikan') {
                $tanggalDikembalikan = $tanggalKembali->copy()->subDays(fake()->numberBetween(0, 3))->toDateString();
            } elseif ($status === 'terlambat') {
                $selisih = abs((int) $tanggalKembali->startOfDay()->diffInDays(now()->startOfDay()));
                $denda = max(1, $selisih) * 2000;
            }

            $loan = Loan::create([
                'member_id' => $memberIds->random(),
                'user_id' => $userIds->random(),
                'tanggal_pinjam' => $tanggalPinjam->toDateString(),
                'tanggal_kembali' => $tanggalKembali->toDateString(),
                'tanggal_dikembalikan' => $tanggalDikembalikan,
                'status' => $status,
                'denda' => $denda,
            ]);

            $bookIds->random(fake()->numberBetween(1, min(3, $bookIds->count())))
                ->each(fn ($bookId) => $loan->loanItems()->create(['book_id' => $bookId]));
        }
    }
}
