<?php
namespace App\Controllers;
use System\Core\Controller;
use App\Models\Attendance;
use App\Models\User;

class Admin extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
            $this->redirect('login');
        }
    }
    
    public function dashboard() {
        $model = new Attendance();
        $attendances = $model->getAllAttendances();
        
        $this->view('admin/dashboard', [
            'attendances' => $attendances
        ]);
    }
    
    public function users() {
        $model = new User();
        
        $limit = 10;
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;
        
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        
        $totalUsers = $model->countAllUsers($search);
        $totalPages = ceil($totalUsers / $limit);
        
        if ($page > $totalPages && $totalPages > 0) {
            $page = $totalPages;
            $offset = ($page - 1) * $limit;
        }
        
        $users = $model->getPaginatedUsers($limit, $offset, $search);
        
        $this->view('admin/users', [
            'users' => $users,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'search' => $search
        ]);
    }

    public function userCreate() {
        $this->view('admin/user_form', ['user' => null]);
    }

    public function userStore() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrf();
            $model = new User();
            $model->create($_POST);
            $this->redirect('admin/users');
        }
    }

    public function userEdit($id) {
        $model = new User();
        $user = $model->getById($id);
        if (!$user) {
            $this->redirect('admin/users');
        }
        $this->view('admin/user_form', ['user' => $user]);
    }

    public function userUpdate($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrf();
            $model = new User();
            $model->update($id, $_POST);
            $this->redirect('admin/users');
        }
    }

    public function userDelete($id) {
        $this->validateCsrf($_GET['csrf_token'] ?? null);
        $model = new User();
        // Evitar que el admin se borre a sí mismo
        if ($id != $_SESSION['user_id']) {
            $model->delete($id);
        }
        $this->redirect('admin/users');
    }
}
