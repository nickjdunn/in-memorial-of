/*
    In Memorial Of - Dynamic Stylesheet
    Generated: {{ now() }}
*/

:root {
    /* ==========================================================================
       1. Theme Variables - Fetched from your database settings
       ========================================================================== */

    /* Header & Navigation Colors */
    --header-bg-color: {{ $settings['header_bg_color'] ?? '#ffffff' }};
    --header-text-color: {{ $settings['header_text_color'] ?? '#111827' }};
    --nav-link-color: {{ $settings['nav_link_color'] ?? '#6b7280' }};
    --nav-link-hover-color: {{ $settings['nav_link_hover_color'] ?? '#374151' }};
    --nav-link-active-color: {{ $settings['nav_link_active_color'] ?? '#4f46e5' }};

    /* General Page Element Colors */
    --primary-color-500: {{ $settings['primary_color_500'] ?? '#6366f1' }};
    --text-color-base: {{ $settings['text_color_base'] ?? '#374151' }};
    --text-color-heading: {{ $settings['text_color_heading'] ?? '#111827' }};
    --link-color: {{ $settings['link_color'] ?? '#4f46e5' }};
    --link-hover-color: {{ $settings['link_hover_color'] ?? '#3730a3' }};
    
    /* Typography */
    --font-family-base: '{{ $settings['font_family_base'] ?? 'Inter' }}', sans-serif;
    --font-family-headings: '{{ $settings['font_family_headings'] ?? 'Figtree' }}', sans-serif;
}

/* ==========================================================================
   2. Applying The Theme - Overriding default styles with our variables
   ========================================================================== */

body {
    font-family: var(--font-family-base);
    color: var(--text-color-base);
}

h1, h2, h3, h4, h5, h6, .font-heading {
    font-family: var(--font-family-headings);
    color: var(--text-color-heading);
}

/* --- App Layout & Navigation --- */
nav.bg-white { 
    background-color: var(--header-bg-color) !important;
}

.page-title { /* For headings like "Site Settings" */
    color: var(--header-text-color);
}

.text-gray-500 { color: var(--nav-link-color); }
.hover\:text-gray-700:hover { color: var(--nav-link-hover-color) !important; }
.border-indigo-500 { border-color: var(--nav-link-active-color) !important; }
.text-indigo-600 { color: var(--nav-link-active-color) !important; }

/* --- Buttons --- */
x-primary-button, .bg-indigo-600 {
    background-color: var(--primary-color-500);
}
x-primary-button:hover, .hover\:bg-indigo-700:hover {
    filter: brightness(0.9);
}

/* --- General Links --- */
a, .text-indigo-600 {
    color: var(--link-color);
}
a:hover, .hover\:text-indigo-900:hover {
    color: var(--link-hover-color);
}