<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Set a per-request session cookie name so admin and user sessions are isolated
// This runs early, before the framework boots and configuration is loaded.
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
if (str_starts_with($requestUri, '/admin') || str_contains($requestUri, '/admin/')) {
    // Admin area — use a separate cookie name
    putenv('SESSION_COOKIE=haier_admin_session');
    $_ENV['SESSION_COOKIE'] = 'haier_admin_session';
    $_SERVER['SESSION_COOKIE'] = 'haier_admin_session';
} else {
    // Default user cookie
    putenv('SESSION_COOKIE=haier_user_session');
    $_ENV['SESSION_COOKIE'] = 'haier_user_session';
    $_SERVER['SESSION_COOKIE'] = 'haier_user_session';
}

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
