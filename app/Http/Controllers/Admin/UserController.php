<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('profile'); // Eager load profiles to avoid N+1 queries
        
        // Filter by role if specified
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }
        
        // Search by name or email if specified
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $users = $query->paginate(10);
        $roles = ['buyer', 'seller', 'admin'];
        
        return view('admin.users.index', compact('users', 'roles'));
    }
    
    public function show(User $user)
    {
        // Load the user with their profile
        $user->load('profile');
        
        return view('admin.users.show', compact('user'));
    }
    
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }
    
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:buyer,seller,admin',
        ]);
        
        $user->update($validated);
        
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }
    
    public function verify(User $user)
    {
        $user->update(['is_verified' => !$user->is_verified]);
        
        return redirect()->route('admin.users.index')->with('success', 'User verification status updated.');
    }
    
    public function destroy(User $user)
    {
        // Prevent deletion of the current admin user
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete yourself.');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}