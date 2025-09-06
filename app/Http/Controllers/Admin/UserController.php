<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::withCount('memorials')->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }
    
    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        // Eager load the memorials for this specific user
        $memorials = $user->memorials()->latest()->paginate(5);
        return view('admin.users.edit', compact('user', 'memorials'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'memorial_slots_purchased' => ['required', 'integer', 'min:0'],
            'is_admin' => ['nullable', 'boolean'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->memorial_slots_purchased = $validated['memorial_slots_purchased'];
        $user->is_admin = $request->has('is_admin');

        $user->save();

        return redirect()->route('admin.users.edit', $user)->with('status', 'User account updated successfully!');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own admin account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'User account and all associated memorials have been deleted.');
    }
}