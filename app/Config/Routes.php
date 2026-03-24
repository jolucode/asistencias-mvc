<?php
namespace App\Config;

class Routes {
    public static function load($router) {
        $router->add('/', ['controller' => 'Home', 'method' => 'index']);
        $router->add('clock', ['controller' => 'Home', 'method' => 'clock']);
        
        $router->add('login', ['controller' => 'Auth', 'method' => 'login']);
        $router->add('loginSubmit', ['controller' => 'Auth', 'method' => 'loginSubmit']);
        $router->add('logout', ['controller' => 'Auth', 'method' => 'logout']);
        
        // Worker routes
        $router->add('worker/dashboard', ['controller' => 'Worker', 'method' => 'dashboard']);
        $router->add('worker/clock', ['controller' => 'Worker', 'method' => 'clockInOut']);
        
        // Admin routes
        $router->add('admin/dashboard', ['controller' => 'Admin', 'method' => 'dashboard']);
        $router->add('admin/users', ['controller' => 'Admin', 'method' => 'users']);
        $router->add('admin/users/create', ['controller' => 'Admin', 'method' => 'userCreate']);
        $router->add('admin/users/store', ['controller' => 'Admin', 'method' => 'userStore']);
        $router->add('admin/users/edit/{id}', ['controller' => 'Admin', 'method' => 'userEdit']);
        $router->add('admin/users/update/{id}', ['controller' => 'Admin', 'method' => 'userUpdate']);
        $router->add('admin/users/delete/{id}', ['controller' => 'Admin', 'method' => 'userDelete']);
    }
}
