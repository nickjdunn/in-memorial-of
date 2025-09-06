<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Memorial;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Mexitek\PHPColors\Color;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key');
        // Fetch all memorials for the dropdown
        $memorials = Memorial::orderBy('full_name')->get();
        
        $defaults = [
            // Brand Colors
            'primary_color_500' => '#3b82f6', // Blue-500

            // Text & Link Colors
            'text_color_base' => '#374151',   // Gray-700
            'text_color_heading' => '#111827', // Gray-900
            'link_color' => '#2563eb',        // Blue-600
            'link_hover_color' => '#1e3a8a',  // Blue-800

            // Header & Navigation Colors
            'header_bg_color' => '#1e3a8a',       // Blue-900
            'header_text_color' => '#ffffff',     // White
            'nav_link_color' => '#dbeafe',      // Blue-200
            'nav_link_hover_color' => '#ffffff',  // White
            'nav_link_active_color' => '#ffffff', // White

            // Fonts
            'font_family_base' => 'Figtree',
            'font_family_headings' => 'Figtree',

            // Homepage Example
            'homepage_example_memorial_id' => '',
        ];

        $settings = collect($defaults)->merge($settings);
        
        return view('admin.settings.index', compact('settings', 'memorials'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'primary_color_500' => 'required|string',
            'text_color_base' => 'required|string',
            'text_color_heading' => 'required|string',
            'link_color' => 'required|string',
            'link_hover_color' => 'required|string',
            'header_bg_color' => 'required|string',
            'header_text_color' => 'required|string',
            'nav_link_color' => 'required|string',
            'nav_link_hover_color' => 'required|string',
            'nav_link_active_color' => 'required|string',
            'font_family_base' => 'required|string',
            'font_family_headings' => 'required|string',
            'homepage_example_memorial_id' => 'nullable|exists:memorials,id',
        ]);

        // Generate and save all shades of the primary color
        try {
            $baseColor = new Color($validated['primary_color_500']);
            $shades = [
                '50' => $baseColor->lighten(45), '100' => $baseColor->lighten(40),
                '200' => $baseColor->lighten(30), '300' => $baseColor->lighten(20),
                '400' => $baseColor->lighten(10), '500' => $baseColor->getHex(),
                '600' => $baseColor->darken(5), '700' => $baseColor->darken(10),
                '800' => $baseColor->darken(15), '900' => $baseColor->darken(20),
                '950' => $baseColor->darken(25),
            ];
            foreach ($shades as $key => $value) {
                Setting::updateOrCreate(['key' => 'primary_color_' . $key], ['value' => '#' . $value]);
            }
        } catch (\Exception $e) {
            Setting::updateOrCreate(
                ['key' => 'primary_color_500'],
                ['value' => $validated['primary_color_500']]
            );
        }
        

        // Save all other individual settings
        foreach ($validated as $key => $value) {
            if ($key !== 'primary_color_500') {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }
        
        // Clear caches so helpers get the new values
        Cache::forget('theme_font_settings');
        Cache::forget('homepage_example_memorial');

        return redirect()->route('admin.settings.index')->with('status', 'Settings updated successfully!');
    }
}