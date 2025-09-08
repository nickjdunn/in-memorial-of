<?php

namespace App\Http\Controllers;

use App\Models\Memorial;
use App\Models\Tribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TributeController extends Controller
{
    /**
     * Display a listing of the tributes for the authenticated user to moderate.
     */
    public function index()
    {
        $user = Auth::user();
        $memorialIds = $user->memorials->pluck('id');

        $pendingTributes = Tribute::with('memorial')
            ->whereIn('memorial_id', $memorialIds)
            ->where('status', 'pending')
            ->latest()
            ->get();
        
        $approvedTributes = Tribute::with('memorial')
            ->whereIn('memorial_id', $memorialIds)
            ->where('status', 'approved')
            ->latest()
            ->get();

        return view('tributes.index', compact('pendingTributes', 'approvedTributes'));
    }

    /**
     * Store a newly created tribute in storage.
     */
    public function store(Request $request, Memorial $memorial)
    {
        if (!$memorial->tributes_enabled) {
            abort(403, 'Tributes are not enabled for this memorial.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $memorial->tributes()->create([
            'name' => $validated['name'],
            'message' => $validated['message'],
        ]);

        return redirect()->route('memorials.show_public', $memorial->slug)
            ->with('tribute_submitted', 'Thank you for your tribute. It has been submitted for review.');
    }

    /**
     * Approve the specified tribute.
     */
    public function approve(Tribute $tribute)
    {
        if ($tribute->memorial->user_id !== Auth::id()) {
            abort(403);
        }

        $tribute->update(['status' => 'approved']);

        return redirect()->route('tributes.index')->with('success', 'Tribute approved successfully.');
    }

    /**
     * Remove the specified tribute from storage.
     */
    public function destroy(Tribute $tribute)
    {
        if ($tribute->memorial->user_id !== Auth::id()) {
            abort(403);
        }

        $tribute->delete();

        return redirect()->route('tributes.index')->with('success', 'Tribute deleted successfully.');
    }
}