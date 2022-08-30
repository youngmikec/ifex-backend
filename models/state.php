<?php
    class State {
        private $conn;
        private $table = 'states';

        // state properties
        public $tracking_code;
        public $id;
        public $name;
        public $region_id;

        // constructor with db
        public function __construct($db) {
            $this->conn = $db;
        }

        public function read () {
            $query = 'SELECT * FROM ' . $this->table . ' ';

            // prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();
            return $stmt;
        }

        
    }
?>