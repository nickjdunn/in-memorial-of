<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Memorial;
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
}