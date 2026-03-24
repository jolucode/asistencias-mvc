<?php
namespace System\Core;

class Controller {
    protected function view($view, $data = []) {
        extract($data);
        $file = APPPATH . 'Views/' . $view . '.php';
        if (file_exists($file)) {
            require $file;
        } else {
            die("View does not exist: $view");
        }
    }
    
    protected function redirect($url) {
        header('Location: ' . BASE_URL . ltrim($url, '/'));
        exit;
    }
}
