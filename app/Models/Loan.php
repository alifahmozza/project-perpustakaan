<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loan extends Model
{
    protected $fillable = [
        'member_id', 'user_id', 'tanggal_pinjam',
        'tanggal_kembali', 'tanggal_dikembalikan', 
        'status', 'denda'
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function loanItems(): HasMany
    {
        return $this->hasMany(LoanItem::class);
    }

    /**
     * Hitung denda keterlambatan secara otomatis (Rp 2.000 per hari keterlambatan).
     */
    public function getDendaAttribute($value): int
    {
        if ($value > 0) {
            return (int) $value;
        }

        $tanggalKembali = Carbon::parse($this->tanggal_kembali)->startOfDay();

        // 1. Jika sudah dikembalikan
        if (!empty($this->tanggal_dikembalikan)) {
            $tanggalDikembalikan = Carbon::parse($this->tanggal_dikembalikan)->startOfDay();
            if ($tanggalDikembalikan->greaterThan($tanggalKembali)) {
                $selisih = abs((int) $tanggalKembali->diffInDays($tanggalDikembalikan));
                return $selisih * 2000;
            }
            return 0;
        }

        // 2. Jika belum dikembalikan dan sudah melewati batas waktu
        $hariIni = Carbon::now()->startOfDay();
        if ($hariIni->greaterThan($tanggalKembali) || $this->attributes['status'] === 'terlambat') {
            $selisih = abs((int) $tanggalKembali->diffInDays($hariIni));
            return max(1, $selisih) * 2000;
        }

        return 0;
    }

    /**
     * Status otomatis terlambat jika melewati batas tanggal kembali
     */
    public function getStatusAttribute($value): string
    {
        if ($value === 'dipinjam' && empty($this->tanggal_dikembalikan)) {
            if (Carbon::now()->startOfDay()->greaterThan(Carbon::parse($this->tanggal_kembali)->startOfDay())) {
                return 'terlambat';
            }
        }
        return $value ?? 'dipinjam';
    }
}
