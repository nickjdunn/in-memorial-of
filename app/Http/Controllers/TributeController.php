<?php

namespace App\Http/Controllers;

use App\Models\Memorial;
use Illuminate\Http\Request;

class TributeController extends Controller
{
    /**
     * Store a newly created tribute in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Memorial  $memorial
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Memorial $memorial)
    {
        // We add an authorization check here. No one can submit a tribute if the feature is disabled.
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
}