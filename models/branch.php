<?php
    class Branch {
        private $conn;
        private $table = 'branches';

        // Branch properties
        public $id;
        public $name;
        public $long_name;
        public $address;
        public $state_id;
        public $created_by;
        public $date;

        public function __construct($db){
            $this->conn = $db;
        }

        public function read() {
            $query = 'SELECT 
                b.id,
                b.name,
                s.name as state_name,
                b.long_name,
                b.address,
                b.state_id,
                b.created_by,
                b.date 
            FROM ' . $this->table . ' b
            LEFT JOIN
                states s ON b.state_id = s.id
            ORDER BY 
                b.date ASC
            ';

            // Prepare statment
            $stmt = $this->conn->prepare($query);

            $stmt->execute();
            return $stmt;
        }
    }

?>