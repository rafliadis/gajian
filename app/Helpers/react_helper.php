<?php

if (!function_exists('load_react_assets')) {
    function load_react_assets(): string
    {
        $manifestPath = FCPATH . 'dist/.vite/manifest.json';
        // Catatan: Di Vite versi 5/6, manifest.json disimpan di dist/.vite/manifest.json secara default.
        // Jika tidak ada, fallback ke dist/manifest.json.
        if (!file_exists($manifestPath)) {
            $manifestPath = FCPATH . 'dist/manifest.json';
        }

        // Mode Development: check jika Vite dev server (port 3000) aktif
        $devServerActive = false;
        if (ENVIRONMENT === 'development') {
            $fp = @fsockopen('localhost', 3000, $errno, $errstr, 0.1);
            if ($fp) {
                $devServerActive = true;
                fclose($fp);
            }
        }

        if ($devServerActive) {
            return '
                <script type="module" src="http://localhost:3000/@vite/client"></script>
                <script type="module" src="http://localhost:3000/src/main.tsx"></script>
            ';
        }

        // Mode Production / Build Static
        if (!file_exists($manifestPath)) {
            return '<!-- React build manifest.json not found. Run "npm run build" in frontend folder. -->';
        }

        $manifest = json_decode(file_get_contents($manifestPath), true);
        $entryKey = 'src/main.tsx';

        if (!isset($manifest[$entryKey])) {
            return '<!-- Entry point src/main.tsx not found in manifest.json. -->';
        }

        $entry = $manifest[$entryKey];
        $html = '';

        // Buang index.php/ jika ada di base_url() untuk memuat aset statis secara langsung
        $baseUrl = base_url();
        $baseUrl = str_replace('index.php/', '', $baseUrl);
        $baseUrl = rtrim($baseUrl, '/') . '/';

        // Load CSS files
        if (isset($entry['css'])) {
            foreach ($entry['css'] as $cssFile) {
                $html .= '<link rel="stylesheet" href="' . $baseUrl . 'dist/' . $cssFile . '">';
            }
        }

        // Load JS file
        $html .= '<script type="module" src="' . $baseUrl . 'dist/' . $entry['file'] . '"></script>';

        return $html;
    }
}
