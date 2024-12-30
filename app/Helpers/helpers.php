<?php

if (!function_exists('load_vite_assets')) {
    function load_vite_assets()
    {
        $assetsPath = public_path('build/.vite/manifest.json'); // Lokasi manifest.json
        $appUrl = rtrim(env('APP_URL', ''), '/'); // Ambil APP_URL dari .env

        // Cek apakah manifest.json ada
        if (!file_exists($assetsPath)) {
            return [
                'css' => [],
                'js' => []
            ];
        }

        // Baca manifest.json
        $manifest = json_decode(file_get_contents($assetsPath), true);

        $assets = [
            'css' => [],
            'js' => [],
        ];

        // Iterasi setiap entry di manifest.json
        foreach ($manifest as $key => $entry) {
            // Deteksi file CSS langsung
            if (isset($entry['file']) && str_ends_with($entry['file'], '.css')) {
                $assets['css'][] = "{$appUrl}/build/{$entry['file']}";
            }

            // Deteksi file CSS dari properti `css`
            if (isset($entry['css'])) {
                foreach ($entry['css'] as $cssFile) {
                    $assets['css'][] = "{$appUrl}/build/{$cssFile}";
                }
            }

            // Deteksi file JS
            if (isset($entry['file']) && str_ends_with($entry['file'], '.js')) {
                $assets['js'][] = "{$appUrl}/build/{$entry['file']}";
            }
        }

        return $assets;
    }
}
