<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Member::query();

        if ($request->has('search') && $request->search != '') {
            $katakunci = $request->search;

            $query->where('nama', 'like', '%' . $katakunci . '%')
                  ->orWhere('nim', 'like', '%' . $katakunci . '%');
        }

        $members = $query->paginate(10);

        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(StoreMemberRequest $request)
    {
        $validated = $request->validated();

        Member::create($validated);

        return redirect()->route('members.index')
            ->with('success', "Anggota \"{$validated['nama']}\" berhasil ditambahkan.");
    }

    public function show(string $id)
    {
        $member = Member::with(['loans.loanItems.book', 'loans.user'])->findOrFail($id);

        return view('members.show', compact('member'));
    }

    public function edit(string $id)
    {
        $member = Member::findOrFail($id);

        return view('members.edit', compact('member'));
    }

    public function update(Request $request, string $id)
    {
        $member = Member::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'nim' => 'required|string|max:20|unique:members,nim,' . $member->id,
            'email' => 'required|email|max:100|unique:members,email,' . $member->id,
            'nomor_telepon' => 'required|string|max:12',
            'alamat' => 'required|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $member->update($validated);

        return redirect()->route('members.index')
            ->with('success', "Anggota \"{$validated['nama']}\" berhasil diperbarui.");
    }

    public function resetPassword($id)
    {
        $member = Member::find($id);
        
        if (!$member) {
            return back()->with('error', 'Data anggota tidak ditemukan di database.');
        }

        $user = \App\Models\User::find($member->user_id);
        
        if (!$user) {
            return back()->with('error', 'Gagal! Anggota ini tidak memiliki relasi akun User yang valid.');
        }

        // Jika keduanya ada, baru reset passwordnya
        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make('perpus123')
        ]);

        return back()->with('success', 'Password berhasil direset menjadi: perpus123');
    }

    public function destroy(string $id)
    {
        $member = Member::findOrFail($id);
        $member->delete();

        return redirect()->route('members.index')
            ->with('success', 'Anggota berhasil dihapus.');
    }
}