<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Mexitek\PHPColors\Color;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key');
        $defaults = [
            'primary_color_500' => '#3b82f6', 'text_color_base' => '#374151',
            'text_color_heading' => '#111827', 'link_color' => '#2563eb',
            'link_hover_color' => '#1e3a8a', 'header_bg_color' => '#1e3a8a',
            'header_text_color' => '#ffffff', 'nav_link_color' => '#dbeafe',
            'nav_link_hover_color' => '#ffffff', 'nav_link_active_color' => '#ffffff',
            'font_family_base' => 'Figtree', 'font_family_headings' => 'Figtree',
        ];
        $settings = collect($defaults)->merge($settings);
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'primary_color_500' => 'required|string', 'text_color_base' => 'required|string',
            'text_color_heading' => 'required|string', 'link_color' => 'required|string',
            'link_hover_color' => 'required|string', 'header_bg_color' => 'required|string',
            'header_text_color' => 'required|string', 'nav_link_color' => 'required|string',
            'nav_link_hover_color' => 'required|string', 'nav_link_active_color' => 'required|string',
            'font_family_base' => 'required|string', 'font_family_headings' => 'required|string',
        ]);
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
            Setting::updateOrCreate(['key' => 'primary_color_500'], ['value' => $validated['primary_color_500']]);
        }
        foreach ($validated as $key => $value) {
            if ($key !== 'primary_color_500') {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }
        Cache::forget('theme_font_settings');
        return redirect()->route('admin.settings.index')->with('status', 'Settings updated successfully!');
    }
}