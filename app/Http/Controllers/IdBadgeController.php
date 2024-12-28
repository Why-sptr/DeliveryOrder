<?php

namespace App\Http\Controllers;

use App\Models\IdBadge;
use App\Models\User;
use Illuminate\Http\Request;

class IdBadgeController extends Controller
{
    public function index()
    {
        $badges = IdBadge::orderBy('id', 'desc')->get();
        return view('id_badge.index', ['badges' => $badges, 'title' => 'ID Badges']);
    }

    public function create()
    {
        return view('id_badge.create');
    }

    public function store(Request $request)
    {
        $request->validate(['badge_name' => 'required|string|unique:id_badges']);

        IdBadge::create(['badge_name' => $request->badge_name]);

        return redirect()->route('id-badges.index')->with('success', 'ID Badge created successfully.');
    }

    public function edit(IdBadge $idBadge)
    {
        return view('id_badge.edit', compact('idBadge'));
    }

    public function update(Request $request, IdBadge $idBadge)
    {
        $request->validate(['badge_name' => 'required|string|unique:id_badges,badge_name,' . $idBadge->id]);

        $idBadge->update(['badge_name' => $request->badge_name]);

        return redirect()->route('id-badges.index')->with('success', 'ID Badge updated successfully.');
    }

    public function destroy(IdBadge $idBadge)
    {
        $idBadge->delete();
        return redirect()->route('id-badges.index')->with('success', 'ID Badge deleted successfully.');
    }
}
