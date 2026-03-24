<?php
namespace App\Models;
use System\Core\Model;

class Attendance extends Model {
    public function getByUserIdAndDate($user_id, $date) {
        $stmt = $this->db->prepare("SELECT * FROM attendances WHERE user_id = ? AND date = ?");
        $stmt->execute([$user_id, $date]);
        return $stmt->fetch();
    }
    
    public function getHistoryByUserId($user_id) {
        $stmt = $this->db->prepare("SELECT * FROM attendances WHERE user_id = ? ORDER BY date DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }
    
    public function getAllAttendances() {
        $stmt = $this->db->query("
            SELECT a.*, u.first_name, u.last_name, u.dni 
            FROM attendances a 
            JOIN users u ON a.user_id = u.id 
            ORDER BY a.date DESC, a.clock_in DESC
        ");
        return $stmt->fetchAll();
    }
    
    public function clockIn($user_id, $date, $time, $status) {
        $stmt = $this->db->prepare("INSERT INTO attendances (user_id, date, clock_in, status) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$user_id, $date, $time, $status]);
    }
    
    public function clockOut($id, $time) {
        $stmt = $this->db->prepare("UPDATE attendances SET clock_out = ? WHERE id = ?");
        return $stmt->execute([$time, $id]);
    }
}
