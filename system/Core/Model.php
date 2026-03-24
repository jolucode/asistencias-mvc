<?php
namespace System\Core;

use App\Config\Database;
use PDO;
use PDOException;

class Model {
    protected $db;

    public function __construct() {
        $config = new Database();
        try {
            $dsn = "mysql:host={$config->host};dbname={$config->dbname};charset=utf8mb4";
            $this->db = new PDO($dsn, $config->username, $config->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}
