<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

// Support requests that have a /public prefix when running via artisan serve
if (str_starts_with($uri, '/public')) {
    $strippedUri = substr($uri, 7);
    $filePath = __DIR__ . '/public' . $strippedUri;
    if (file_exists($filePath) && !is_dir($filePath)) {
        $mimeTypes = [
            'css' => 'text/css',
            'js' => 'application/javascript',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'ico' => 'image/x-icon',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf' => 'font/ttf',
            'otf' => 'font/otf',
            'eot' => 'application/vnd.ms-fontobject',
            'json' => 'application/json',
        ];
        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $contentType = $mimeTypes[$ext] ?? (function_exists('mime_content_type') ? @mime_content_type($filePath) : 'application/octet-stream');

        header('Content-Type: ' . $contentType);
        readfile($filePath);
        exit;
    }
}

require_once __DIR__ . '/public/index.php';

