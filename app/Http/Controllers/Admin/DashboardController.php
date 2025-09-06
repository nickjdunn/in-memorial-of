<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // The main admin dashboard now redirects to the user management page.
        return redirect()->route('admin.users.index');
    }
}