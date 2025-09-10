<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Response;

class DynamicCssController extends Controller
{
    public function generate()
    {
        // Cache the settings for 1 hour for performance. 
        // The cache is automatically cleared when an admin saves new settings.
        $settings = Cache::remember('theme_settings', 3600, function () {
            // Get all settings from the database and add the config defaults as a fallback
            $db_settings = Setting::pluck('value', 'key')->all();
            $default_settings = config('app_settings');
            return array_merge($default_settings, $db_settings);
        });

        $css = view('dynamic-styles', ['settings' => $settings])->render();

        return new Response($css, 200, ['Content-Type' => 'text/css']);
    }
}