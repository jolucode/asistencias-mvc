<?php
namespace System\Router;

class Router {
    private $routes = [];

    public function add($route, $params) {
        $this->routes[$route] = $params;
    }

    public function dispatch($url) {
        $matched = false;
        foreach ($this->routes as $route => $params) {
            $routePattern = preg_replace('/\//', '\\/', $route);
            // Replace e.g., {id} with a regex group to capture segment
            $routePattern = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z0-9-]+)', $routePattern);
            $routePattern = '/^' . $routePattern . '$/i';
            
            if (preg_match($routePattern, $url, $matches)) {
                $matched = true;
                $controller = "App\\Controllers\\" . $params['controller'];
                $method = $params['method'];

                if (class_exists($controller)) {
                    $controller_object = new $controller();
                    
                    if (is_callable([$controller_object, $method])) {
                        $args = [];
                        foreach ($matches as $key => $match) {
                            if (is_string($key)) {
                                $args[$key] = $match;
                            }
                        }
                        call_user_func_array([$controller_object, $method], $args);
                    } else {
                        echo "Method $method not found in controller $controller";
                    }
                } else {
                    echo "Controller class $controller not found";
                }
                break;
            }
        }
        
        if (!$matched) {
            http_response_code(404);
            echo "404 Not Found";
        }
    }
}
