<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tribute;
use Illuminate\Http\Request;

class TributeController extends Controller
{
    /**
     * Display a listing of all pending tributes for moderation.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $pendingTributes = Tribute::with(['memorial', 'memorial.user'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('admin.tributes.index', compact('pendingTributes'));
    }
}