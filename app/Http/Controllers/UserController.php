<?php

namespace App\Http\Controllers;

use App\Models\IdBadge;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        $users = User::role('user')->with('idBadges')->orderByDesc('id')->get();
        $badges = IdBadge::all();

        return view('user.index', ['users' => $users, 'badges' => $badges, 'title' => 'List Users']);
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'id_badges' => 'array|nullable',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $user->assignRole('user');

        // Attach ID Badges
        if ($request->has('id_badges')) {
            $user->idBadges()->attach($request->id_badges);
        }

        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'id_badges' => 'array|nullable',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Sync ID Badges
        if ($request->has('id_badges')) {
            $user->idBadges()->sync($request->id_badges);
        } else {
            $user->idBadges()->detach();
        }

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }
}
