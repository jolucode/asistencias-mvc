<?php
namespace App\Models;
use System\Core\Model;

class User extends Model {
    public function getByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function getByDni($dni) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE dni = ?");
        $stmt->execute([$dni]);
        return $stmt->fetch();
    }
    
    public function countAllUsers($search = '') {
        if ($search) {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE dni LIKE ? OR first_name LIKE ? OR last_name LIKE ?");
            $searchTerm = "%$search%";
            $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
            return $stmt->fetchColumn();
        } else {
            $stmt = $this->db->query("SELECT COUNT(*) FROM users");
            return $stmt->fetchColumn();
        }
    }
    
    public function getPaginatedUsers($limit, $offset, $search = '') {
        if ($search) {
            $stmt = $this->db->prepare("SELECT u.*, r.name as role_name FROM users u JOIN roles r ON u.role_id = r.id WHERE u.dni LIKE ? OR u.first_name LIKE ? OR u.last_name LIKE ? ORDER BY u.id DESC LIMIT ? OFFSET ?");
            $searchTerm = "%$search%";
            $stmt->bindValue(1, $searchTerm, \PDO::PARAM_STR);
            $stmt->bindValue(2, $searchTerm, \PDO::PARAM_STR);
            $stmt->bindValue(3, $searchTerm, \PDO::PARAM_STR);
            $stmt->bindValue(4, $limit, \PDO::PARAM_INT);
            $stmt->bindValue(5, $offset, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } else {
            $stmt = $this->db->prepare("SELECT u.*, r.name as role_name FROM users u JOIN roles r ON u.role_id = r.id ORDER BY u.id DESC LIMIT ? OFFSET ?");
            $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
            $stmt->bindValue(2, $offset, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }
    
    public function getAllUsers() {
        $stmt = $this->db->query("SELECT u.*, r.name as role_name FROM users u JOIN roles r ON u.role_id = r.id ORDER BY u.id DESC");
        return $stmt->fetchAll();
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO users (role_id, dni, first_name, last_name, email, password) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['role_id'],
            $data['dni'],
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT)
        ]);
    }
    
    public function update($id, $data) {
        if (!empty($data['password'])) {
            $stmt = $this->db->prepare("UPDATE users SET role_id = ?, dni = ?, first_name = ?, last_name = ?, email = ?, password = ? WHERE id = ?");
            return $stmt->execute([
                $data['role_id'], $data['dni'], $data['first_name'], $data['last_name'], $data['email'], password_hash($data['password'], PASSWORD_DEFAULT), $id
            ]);
        } else {
            $stmt = $this->db->prepare("UPDATE users SET role_id = ?, dni = ?, first_name = ?, last_name = ?, email = ? WHERE id = ?");
            return $stmt->execute([
                $data['role_id'], $data['dni'], $data['first_name'], $data['last_name'], $data['email'], $id
            ]);
        }
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
