<?php

namespace App\Http\Controllers;

use App\Models\Memorial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MemorialController extends Controller
{

    public function create()
    {
        $user = Auth::user();
        if ($user->memorial_slots <= $user->memorials()->count()) {
            return redirect()->route('dashboard')->with('error', 'You have no available memorial slots. Please purchase one.');
        }

        return view('memorials.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->memorial_slots <= $user->memorials()->count()) {
            return redirect()->route('dashboard')->with('error', 'You have no available memorial slots.');
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'date_of_passing' => 'nullable|date',
            'biography' => 'nullable|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'primary_color' => 'required|string|max:7',
            'font_family_name' => 'required|string|max:255',
            'font_family_body' => 'required|string|max:255',
            'photo_shape' => 'required|string|in:rounded-none,rounded-md,rounded-lg,rounded-full',
            'tributes_enabled' => 'nullable|boolean',
        ]);

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('photos', 'public');
            $validated['profile_photo_path'] = $path;
        }

        $validated['user_id'] = $user->id;
        $validated['slug'] = Str::slug($validated['full_name']) . '-' . uniqid();
        $validated['tributes_enabled'] = $request->has('tributes_enabled');

        Memorial::create($validated);

        return redirect()->route('dashboard')->with('success', 'Memorial created successfully.');
    }

    public function edit(Memorial $memorial)
    {
        if (Auth::id() !== $memorial->user_id && !Auth::user()->is_admin) {
            abort(430);
        }
        return view('memorials.edit', compact('memorial'));
    }

    public function update(Request $request, Memorial $memorial)
    {
        if (Auth::id() !== $memorial->user_id && !Auth::user()->is_admin) {
            abort(430);
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'date_of_passing' => 'nullable|date',
            'biography' => 'nullable|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'primary_color' => 'required|string|max:7',
            'font_family_name' => 'required|string|max:255',
            'font_family_body' => 'required|string|max:255',
            'photo_shape' => 'required|string|in:rounded-none,rounded-md,rounded-lg,rounded-full',
            'tributes_enabled' => 'nullable|boolean',
        ]);

        if ($request->hasFile('profile_photo')) {
            if ($memorial->profile_photo_path) {
                Storage::disk('public')->delete($memorial->profile_photo_path);
            }
            $path = $request->file('profile_photo')->store('photos', 'public');
            $validated['profile_photo_path'] = $path;
        }

        if ($memorial->full_name !== $validated['full_name']) {
            $validated['slug'] = Str::slug($validated['full_name']) . '-' . uniqid();
        }

        $validated['tributes_enabled'] = $request->has('tributes_enabled');

        $memorial->update($validated);

        if (Auth::user()->is_admin) {
             return redirect()->route('admin.memorials.index')->with('success', 'Memorial updated successfully.');
        }

        return redirect()->route('dashboard')->with('success', 'Memorial updated successfully.');
    }


    public function destroy(Memorial $memorial)
    {
        if (Auth::id() !== $memorial->user_id && !Auth::user()->is_admin) {
            abort(430);
        }

        if ($memorial->profile_photo_path) {
            Storage::disk('public')->delete($memorial->profile_photo_path);
        }

        $memorial->delete();

        if (Auth::user()->is_admin) {
             return redirect()->route('admin.memorials.index')->with('success', 'Memorial deleted successfully.');
        }

        return redirect()->route('dashboard')->with('success', 'Memorial deleted successfully.');
    }

    public function showPublic(Memorial $memorial)
    {
        return view('memorials.show_public', compact('memorial'));
    }
}