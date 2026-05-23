<?php

/**
 * Laravel on Vercel entrypoint.
 * Forward everything to Laravel's public/index.php
 */
$appDir = __DIR__ . '/..';

// Create directories for Laravel in /tmp since Vercel is read-only
$storagePath = '/tmp/storage';
$dirs = [
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/framework/views',
    $storagePath . '/logs'
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

// Override storage paths to use /tmp
putenv("VIEW_COMPILED_PATH=/tmp/storage/framework/views");
putenv("APP_SERVICES_CACHE=/tmp/storage/framework/cache/services.php");
putenv("APP_PACKAGES_CACHE=/tmp/storage/framework/cache/packages.php");
putenv("APP_CONFIG_CACHE=/tmp/storage/framework/cache/config.php");
putenv("APP_ROUTES_CACHE=/tmp/storage/framework/cache/routes.php");
putenv("APP_EVENTS_CACHE=/tmp/storage/framework/cache/events.php");

require $appDir . '/public/index.php';
