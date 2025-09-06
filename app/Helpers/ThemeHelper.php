<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('get_google_font_url')) {
    function get_google_font_url()
    {
        $settings = Cache::remember('theme_font_settings', 3600, function () {
            return Setting::whereIn('key', ['font_family_base', 'font_family_headings'])->pluck('value', 'key');
        });
        $baseFont = $settings->get('font_family_base', 'Figtree');
        $headingFont = $settings->get('font_family_headings', 'Figtree');
        $fonts = collect([$baseFont, $headingFont])->unique();
        if ($fonts->isEmpty()) { return ''; }
        $familyStrings = $fonts->map(function ($font) {
            return 'family=' . urlencode($font) . ':wght@400;500;600;700';
        })->implode('&');
        return 'https://fonts.googleapis.com/css2?' . $familyStrings . '&display=swap';
    }
}