<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        if ($request->role)   $query->where('role', $request->role);
        if ($request->search) $query->where(fn($q) =>
            $q->where('name','like',"%{$request->search}%")
            ->orWhere('email','like',"%{$request->search}%")
        );
        return view('admin.user.index', [
            'users'       => $query->latest()->paginate(10),
            'totalUsers'  => User::count(),
            'totalPenjual'=> User::where('role','penjual')->count(),
            'totalPembeli'=> User::where('role','pembeli')->count(),
            'newThisWeek' => User::where('created_at','>=',now()->startOfWeek())->count(),
        ]);
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:pembeli,penjual,admin',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.user.index')
                         ->with('success', 'User berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role'  => 'required|in:pembeli,penjual,admin',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6|confirmed']);
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.user.index')
                         ->with('success', 'User berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        abort_if($user->id === auth()->id(), 403, 'Tidak bisa hapus akun sendiri.');
        $user->delete();
        return back()->with('success', 'User berhasil dihapus!');
    }
}