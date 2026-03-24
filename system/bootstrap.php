<?php
// Autoloader for App and System namespaces
spl_autoload_register(function ($class) {
    $prefix = '';
    $base_dir = '';
    
    if (strpos($class, 'App\\') === 0) {
        $prefix = 'App\\';
        $base_dir = APPPATH;
    } elseif (strpos($class, 'System\\') === 0) {
        $prefix = 'System\\';
        $base_dir = SYSTEMPATH;
    }

    if ($prefix !== '') {
        $len = strlen($prefix);
        $relative_class = substr($class, $len);
        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

        if (file_exists($file)) {
            require $file;
        }
    }
});

// Load Config
require_once APPPATH . 'Config/Routes.php';

// Route Request
$router = new \System\Router\Router();
\App\Config\Routes::load($router);

$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '/';
$router->dispatch($url);
