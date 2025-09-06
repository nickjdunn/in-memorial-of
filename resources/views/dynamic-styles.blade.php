:root {
    /* Primary (Button/Accent) Color Palette */
    --color-primary-50: {{ $settings['primary_color_50'] ?? '#eff6ff' }};
    --color-primary-100: {{ $settings['primary_color_100'] ?? '#dbeafe' }};
    --color-primary-200: {{ $settings['primary_color_200'] ?? '#bfdbfe' }};
    --color-primary-300: {{ $settings['primary_color_300'] ?? '#93c5fd' }};
    --color-primary-400: {{ $settings['primary_color_400'] ?? '#60a5fa' }};
    --color-primary-500: {{ $settings['primary_color_500'] ?? '#3b82f6' }};
    --color-primary-600: {{ $settings['primary_color_600'] ?? '#2563eb' }};
    --color-primary-700: {{ $settings['primary_color_700'] ?? '#1d4ed8' }};
    --color-primary-800: {{ $settings['primary_color_800'] ?? '#1e40af' }};
    --color-primary-900: {{ $settings['primary_color_900'] ?? '#1e3a8a' }};
    --color-primary-950: {{ $settings['primary_color_950'] ?? '#172554' }};
    
    /* Text & Link Colors */
    --color-text-base: {{ $settings['text_color_base'] ?? '#374151' }};
    --color-text-heading: {{ $settings['text_color_heading'] ?? '#111827' }};
    --color-link: {{ $settings['link_color'] ?? '#2563eb' }};
    --color-link-hover: {{ $settings['link_hover_color'] ?? '#1e3a8a' }};

    /* Header & Navigation Colors */
    --color-header-bg: {{ $settings['header_bg_color'] ?? '#1e3a8a' }};
    --color-header-text: {{ $settings['header_text_color'] ?? '#ffffff' }};
    --color-nav-link: {{ $settings['nav_link_color'] ?? '#dbeafe' }};
    --color-nav-link-hover: {{ $settings['nav_link_hover_color'] ?? '#ffffff' }};
    --color-nav-link-active: {{ $settings['nav_link_active_color'] ?? '#ffffff' }};

    /* Fonts */
    --font-family-base: '{{ $settings['font_family_base'] ?? 'Figtree' }}', sans-serif;
    --font-family-headings: '{{ $settings['font_family_headings'] ?? 'Figtree' }}', sans-serif;
}

/* Base body styles */
body {
    font-family: var(--font-family-base);
    color: var(--color-text-base);
}
h1, h2, h3, h4, h5, h6, .font-heading {
    font-family: var(--font-family-headings);
    color: var(--color-text-heading);
}

/* Unified Header Styling */
.unified-header {
    background-color: var(--color-header-bg);
}
.page-title {
    color: var(--color-header-text);
}

/* Main Navigation Link Styling */
.main-nav a { color: var(--color-nav-link); }
.main-nav a:hover { color: var(--color-nav-link-hover); }
.main-nav a.active-nav-link { color: var(--color-nav-link-active); border-color: var(--color-nav-link-active) !important; }
.main-nav-dropdown-trigger { color: var(--color-nav-link); }
.main-nav-dropdown-trigger:hover { color: var(--color-nav-link-hover); }
.main-nav-responsive { background-color: var(--color-header-bg); }
.main-nav-responsive-border { border-color: var(--color-primary-700); }
.main-nav-responsive-text { color: var(--color-header-text); }
.main-nav-responsive-email { color: var(--color-nav-link); }

/* Content Link styles */
.main-content a:not(.button-link), table a:not(.button-link) {
    color: var(--color-link);
    text-decoration: none;
    transition: color 0.2s ease-in-out;
}
.main-content a:not(.button-link):hover, table a:not(.button-link):hover {
    color: var(--color-link-hover);
    text-decoration: underline;
}

/* Helper classes for brand colors (mostly for buttons and accents) */
.bg-brand-600 { background-color: var(--color-primary-600); }
.hover\:bg-brand-500:hover { background-color: var(--color-primary-500); }
.focus\:bg-brand-700:focus { background-color: var(--color-primary-700); }
.active\:bg-brand-900:active { background-color: var(--color-primary-900); }

.text-brand-600 { color: var(--color-primary-600); }
.text-brand-800 { color: var(--color-primary-800); }
.text-brand-700 { color: var(--color-primary-700); }
.text-brand-900 { color: var(--color-primary-900); }

.border-brand-500 { border-color: var(--color-primary-500); }

.focus\:ring-brand-500:focus { --tw-ring-color: var(--color-primary-500); }

/* Memorial page specific background */
.memorial-page-bg {
    background-color: #111827; /* Tailwind's gray-900 */
}