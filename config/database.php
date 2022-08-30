<?php
    class Database {
        // Database properties 
        private $host = 'localhost';
        private $db_name = 'ifexex5_app';
        private $username = 'root';
        private $password = '';
        private $conn;

        // Connect database;
        public function connect() {
            $this->conn = null;
            try{        
                $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password); 
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                echo 'Connection Error:' . $e->getMessage();
            }
            return $this->conn;
        } 
    }
?>