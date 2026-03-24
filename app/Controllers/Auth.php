<?php
namespace App\Controllers;
use System\Core\Controller;
use App\Models\User;

class Auth extends Controller {
    public function login() {
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['role_id'] == 1) {
                $this->redirect('admin/dashboard');
            } else {
                $this->redirect('worker/dashboard');
            }
        }
        $data = ['error' => ''];
        if (isset($_SESSION['error'])) {
            $data['error'] = $_SESSION['error'];
            unset($_SESSION['error']);
        }
        $this->view('auth/login', $data);
    }

    public function loginSubmit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrf();
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $userModel = new User();
            $user = $userModel->getByEmail($email);
            
            // Note: In an actual app, we'd use password_verify. 
            // The dumped sql has password123 hashed using password_hash.
            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role_id'] = $user['role_id'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];
                
                if ($user['role_id'] == 1) {
                    $this->redirect('admin/dashboard');
                } else {
                    $this->redirect('worker/dashboard');
                }
            } else {
                $_SESSION['error'] = 'Correo o contraseña incorrectos';
                $this->redirect('login');
            }
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('login');
    }
}
