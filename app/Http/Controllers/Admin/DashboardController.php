<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Memorial;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::with('memorials')->latest()->paginate(10, ['*'], 'users_page');
        $memorials = Memorial::with('user')->latest()->paginate(10, ['*'], 'memorials_page');
        return view('admin.dashboard', compact('users', 'memorials'));
    }
}