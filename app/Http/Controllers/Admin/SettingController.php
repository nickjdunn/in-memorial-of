<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Memorial;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->all();
        $memorials = Memorial::with('user')->get();
        return view('admin.settings.index', compact('settings', 'memorials'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'homepage_example_memorial_id' => 'nullable|exists:memorials,id',
            
            // Color Settings
            'header_bg_color' => 'required|string|max:7',
            'header_text_color' => 'required|string|max:7',
            'nav_link_color' => 'required|string|max:7',
            'nav_link_hover_color' => 'required|string|max:7',
            'nav_link_active_color' => 'required|string|max:7',
            'primary_color_500' => 'required|string|max:7',
            'text_color_base' => 'required|string|max:7',
            'text_color_heading' => 'required|string|max:7',
            'link_color' => 'required|string|max:7',
            'link_hover_color' => 'required|string|max:7',

            // Font Settings
            'font_family_base' => 'required|string|max:255',
            'font_family_headings' => 'required|string|max:255',
        ]);

        foreach ($validated as $key => $value) {
            // Provide a null check for safety, though validation should prevent this.
            if ($value !== null) {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }

        Cache::forget('theme_settings');
        Cache::forget('app_settings');

        return redirect()->route('admin.settings.index')->with('status', 'Site settings updated successfully!');
    }
}