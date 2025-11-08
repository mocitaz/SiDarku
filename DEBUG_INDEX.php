<?php
/**
 * DEBUG FILE - Hapus file ini setelah debugging selesai!
 * 
 * Copy isi file ini ke public_html/index.php untuk melihat error detail
 * JANGAN digunakan di production!
 */

// Display all errors (ONLY FOR DEBUGGING!)
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

echo "<h2>Debug Info</h2>";
echo "<pre>";

// Check PHP version
echo "PHP Version: " . PHP_VERSION . "\n";
echo "PHP Version OK: " . (version_compare(PHP_VERSION, '8.2.0', '>=') ? 'YES' : 'NO') . "\n\n";

// Check required extensions
$required_extensions = ['pdo', 'pdo_mysql', 'mbstring', 'openssl', 'tokenizer', 'json', 'ctype', 'fileinfo'];
echo "Required Extensions:\n";
foreach ($required_extensions as $ext) {
    echo "  $ext: " . (extension_loaded($ext) ? 'LOADED' : 'MISSING') . "\n";
}
echo "\n";

// Check file paths
echo "File Paths:\n";
echo "  __DIR__: " . __DIR__ . "\n";
echo "  vendor/autoload.php exists: " . (file_exists(__DIR__.'/../vendor/autoload.php') ? 'YES' : 'NO') . "\n";
echo "  bootstrap/app.php exists: " . (file_exists(__DIR__.'/../bootstrap/app.php') ? 'YES' : 'NO') . "\n";
echo "  .env exists: " . (file_exists(__DIR__.'/../.env') ? 'YES' : 'NO') . "\n";
echo "  storage/ exists: " . (is_dir(__DIR__.'/../storage') ? 'YES' : 'NO') . "\n";
echo "  storage/logs/ writable: " . (is_writable(__DIR__.'/../storage/logs') ? 'YES' : 'NO') . "\n";
echo "\n";

// Check .env
if (file_exists(__DIR__.'/../.env')) {
    $env = file_get_contents(__DIR__.'/../.env');
    echo ".env APP_KEY exists: " . (strpos($env, 'APP_KEY=') !== false && strpos($env, 'APP_KEY=') !== strpos($env, 'APP_KEY=') ? 'YES' : 'NO') . "\n";
    echo ".env DB_CONNECTION: " . (preg_match('/DB_CONNECTION=(.+)/', $env, $matches) ? $matches[1] : 'NOT SET') . "\n";
}
echo "\n";

echo "</pre>";
echo "<hr>";

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

try {
    // Register the Composer autoloader...
    if (!file_exists(__DIR__.'/../vendor/autoload.php')) {
        die("<h1>Error: vendor/autoload.php not found!</h1><p>Run: composer install</p>");
    }
    
    require __DIR__.'/../vendor/autoload.php';
    
    // Bootstrap Laravel and handle the request...
    if (!file_exists(__DIR__.'/../bootstrap/app.php')) {
        die("<h1>Error: bootstrap/app.php not found!</h1>");
    }
    
    /** @var Application $app */
    $app = require_once __DIR__.'/../bootstrap/app.php';
    
    $app->handleRequest(Request::capture());
    
} catch (Exception $e) {
    echo "<h1>Error:</h1>";
    echo "<pre>";
    echo "Message: " . $e->getMessage() . "\n\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n\n";
    echo "Stack Trace:\n" . $e->getTraceAsString();
    echo "</pre>";
}

