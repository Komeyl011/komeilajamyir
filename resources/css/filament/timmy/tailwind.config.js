import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './vendor/bezhansalleh/filament-language-switch/resources/views/language-switch.blade.php',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                primary: {
                    light: '#2563EB',
                    dark: '#3B82F6',
                },
                secondary: {
                    light: '#9CA3AF',
                    dark: '#4B5563',
                },
                accent: {
                    light: '#10B981',
                    dark: '#34D399',
                },
                warning: {
                    light: '#F59E0B',
                    dark: '#FBBF24',
                },
                danger: {
                    light: '#F43F5E',
                    dark: '#FB7185',
                },
                background: {
                    light: '#F9FAFB',
                    dark: '#111827',
                },
                surface: {
                    light: '#FFFFFF',
                    dark: '#1F2937',
                },
            },
        },
    }
}
