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
    
    protected function validateCsrf($tokenParam = null) {
        $token = $tokenParam ?? ($_POST['csrf_token'] ?? '');
        if (!hash_equals($_SESSION['csrf_token'], $token)) {
            http_response_code(403);
            die("Error 403: Solicitud rechazada por medidas de seguridad (CSRF inválido).");
        }
    }
}
