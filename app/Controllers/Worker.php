<?php
namespace App\Controllers;
use System\Core\Controller;
use App\Models\Attendance;

class Worker extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
            $this->redirect('login');
        }
    }
    
    public function dashboard() {
        $model = new Attendance();
        $today = date('Y-m-d');
        
        $currentAttendance = $model->getByUserIdAndDate($_SESSION['user_id'], $today);
        $history = $model->getHistoryByUserId($_SESSION['user_id']);
        
        $this->view('worker/dashboard', [
            'current' => $currentAttendance,
            'history' => $history,
            'today' => $today
        ]);
    }
    
    public function clockInOut() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrf();
            $model = new Attendance();
            $today = date('Y-m-d');
            $time = date('H:i:s');
            
            $currentAttendance = $model->getByUserIdAndDate($_SESSION['user_id'], $today);
            
            if (!$currentAttendance) {
                // Clock In (Late if past 09:15)
                $status = (date('H:i') > '09:15') ? 'late' : 'present';
                $model->clockIn($_SESSION['user_id'], $today, $time, $status);
            } else if (empty($currentAttendance['clock_out'])) {
                // Clock Out
                $model->clockOut($currentAttendance['id'], $time);
            }
        }
        $this->redirect('worker/dashboard');
    }
}
