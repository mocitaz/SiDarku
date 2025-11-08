<?php
/**
 * Debug Script - Hapus setelah debugging selesai!
 * Akses: https://sidarku.site/check.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>System Check</h2>";
echo "<pre>";

// PHP Version
echo "PHP Version: " . PHP_VERSION . "\n";
echo "PHP Version OK: " . (version_compare(PHP_VERSION, '8.2.0', '>=') ? 'YES ✓' : 'NO ✗') . "\n\n";

// Check extensions
$extensions = ['pdo', 'pdo_mysql', 'mbstring', 'openssl', 'tokenizer', 'json', 'ctype', 'fileinfo', 'xml', 'gd'];
echo "PHP Extensions:\n";
foreach ($extensions as $ext) {
    $loaded = extension_loaded($ext);
    echo "  $ext: " . ($loaded ? 'LOADED ✓' : 'MISSING ✗') . "\n";
}
echo "\n";

// Check file paths
echo "File Paths:\n";
$base = dirname(__DIR__);
echo "  Base path: $base\n";
echo "  vendor/autoload.php: " . (file_exists("$base/vendor/autoload.php") ? 'EXISTS ✓' : 'NOT FOUND ✗') . "\n";
echo "  bootstrap/app.php: " . (file_exists("$base/bootstrap/app.php") ? 'EXISTS ✓' : 'NOT FOUND ✗') . "\n";
echo "  .env: " . (file_exists("$base/.env") ? 'EXISTS ✓' : 'NOT FOUND ✗') . "\n";
echo "  storage/: " . (is_dir("$base/storage") ? 'EXISTS ✓' : 'NOT FOUND ✗') . "\n";
echo "  storage/logs/: " . (is_dir("$base/storage/logs") ? 'EXISTS ✓' : 'NOT FOUND ✗') . "\n";
echo "  storage/logs/ writable: " . (is_writable("$base/storage/logs") ? 'YES ✓' : 'NO ✗') . "\n";
echo "\n";

// Check .env
if (file_exists("$base/.env")) {
    $env = file_get_contents("$base/.env");
    echo ".env Check:\n";
    echo "  APP_KEY: " . (preg_match('/APP_KEY=base64:[\w+\/=]+/', $env) ? 'SET ✓' : 'NOT SET ✗') . "\n";
    echo "  APP_DEBUG: " . (preg_match('/APP_DEBUG=(.+)/', $env, $m) ? $m[1] : 'NOT SET') . "\n";
    echo "  DB_CONNECTION: " . (preg_match('/DB_CONNECTION=(.+)/', $env, $m) ? $m[1] : 'NOT SET') . "\n";
    echo "  DB_DATABASE: " . (preg_match('/DB_DATABASE=(.+)/', $env, $m) ? $m[1] : 'NOT SET') . "\n";
}
echo "\n";

// Check database connection
echo "Database Connection Test:\n";
try {
    if (file_exists("$base/.env")) {
        $env_lines = file("$base/.env", FILE_IGNORE_NEW_LINES);
        $config = [];
        foreach ($env_lines as $line) {
            if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
                list($key, $value) = explode('=', $line, 2);
                $config[trim($key)] = trim($value, '"\'');
            }
        }
        
        if (isset($config['DB_CONNECTION']) && $config['DB_CONNECTION'] === 'mysql') {
            $host = $config['DB_HOST'] ?? '127.0.0.1';
            $dbname = $config['DB_DATABASE'] ?? '';
            $username = $config['DB_USERNAME'] ?? '';
            $password = $config['DB_PASSWORD'] ?? '';
            
            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
            $pdo = new PDO($dsn, $username, $password);
            echo "  Connection: SUCCESS ✓\n";
        } else {
            echo "  Connection: SKIPPED (not MySQL)\n";
        }
    }
} catch (Exception $e) {
    echo "  Connection: FAILED ✗\n";
    echo "  Error: " . $e->getMessage() . "\n";
}

echo "\n";
echo "Done! If all checks pass, the issue might be with Laravel bootstrap.\n";
echo "</pre>";

