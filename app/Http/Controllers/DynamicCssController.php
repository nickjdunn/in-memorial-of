<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Response;

class DynamicCssController extends Controller
{
    public function generate()
    {
        $settings = Setting::pluck('value', 'key');
        $css = view('dynamic-styles', compact('settings'))->render();
        return new Response($css, 200, ['Content-Type' => 'text/css']);
    }
}