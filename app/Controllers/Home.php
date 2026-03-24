<?php
namespace App\Controllers;
use System\Core\Controller;
use App\Models\User;
use App\Models\Attendance;

class Home extends Controller {
    public function index() {
        // Simple kiosk view for DNI
        $data = ['message' => '', 'type' => ''];
        if (isset($_SESSION['kiosk_message'])) {
            $data['message'] = $_SESSION['kiosk_message'];
            $data['type'] = $_SESSION['kiosk_type'];
            unset($_SESSION['kiosk_message']);
            unset($_SESSION['kiosk_type']);
        }
        $this->view('home', $data);
    }
    
    public function clock() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrf();
            $dni = trim($_POST['dni'] ?? '');
            if (empty($dni)) {
                $this->setFlashMessage('Por favor, ingresa un DNI válido.', 'danger');
                $this->redirect('');
            }
            
            $userModel = new User();
            $user = $userModel->getByDni($dni);
            
            if (!$user) {
                $this->setFlashMessage('DNI no encontrado en el sistema.', 'danger');
                $this->redirect('');
            }
            
            $attModel = new Attendance();
            $today = date('Y-m-d');
            $time = date('H:i:s');
            $current = $attModel->getByUserIdAndDate($user['id'], $today);
            
            if (!$current) {
                // Clock In
                $status = (date('H:i') > '09:15') ? 'late' : 'present';
                $attModel->clockIn($user['id'], $today, $time, $status);
                $this->setFlashMessage("¡Entrada registrada con éxito para {$user['first_name']} {$user['last_name']} a las " . date('H:i') . "!", 'success');
            } else if (empty($current['clock_out'])) {
                // Clock Out
                $attModel->clockOut($current['id'], $time);
                $this->setFlashMessage("¡Salida registrada con éxito para {$user['first_name']} {$user['last_name']} a las " . date('H:i') . "!", 'success');
            } else {
                $this->setFlashMessage("Ya completaste tu jornada de hoy, {$user['first_name']}.", 'warning');
            }
            $this->redirect('');
        }
    }
    
    private function setFlashMessage($message, $type) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['kiosk_message'] = $message;
        $_SESSION['kiosk_type'] = $type;
    }
}
