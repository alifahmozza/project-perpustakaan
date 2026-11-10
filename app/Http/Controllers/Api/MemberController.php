<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\LoanResource;
use App\Models\Loan;
use App\Models\Member;
use App\Http\Resources\MemberResource;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Member::query();

        if ($request->has('search') && $request->search != '') {
            $katakunci = $request->search;
            $query->where('nama', 'like', '%' . $katakunci . '%');
        }

        $members = $query->paginate(10);

        return MemberResource::collection($members);
    }

    public function show(string $id)
    {
        $member = Member::findOrFail($id);

        return new MemberResource($member);
    }
}
