<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Memorial;
use App\Models\User;
use Illuminate\Http\Request;

class MemorialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $memorials = Memorial::with('user')->latest()->paginate(15);
        return view('admin.memorials.index', compact('memorials'));
    }

    /**
     * Show the form for creating a new memorial for a specific user.
     */
    public function createForUser(User $user)
    {
        // Check if the user has available slots
        if ($user->memorials()->count() >= $user->memorial_slots_purchased) {
            return redirect()->route('admin.users.edit', $user)->with('error', 'This user has no available memorial slots.');
        }

        // We pass the target user to the view
        return view('memorials.create', ['userFor' => $user]);
    }
}