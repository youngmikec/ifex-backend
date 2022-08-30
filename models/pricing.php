<?php
    class Pricing {
        private $conn;
        private $table = 'pricing';

        // Transaction properties
        public $id;
        public $originating_state;
        public $originating_state_id;
        public $originating_state_name;
        public $base_price;
        public $category;
        public $incremental_charge;
        public $worth;
        public $max_weight;
        public $date_created;

        // constructor with db
        public function __construct($db) {
            $this->conn = $db;
        }

        public function read () {
            $query = 'SELECT 
                s.name as state_name,
                p.id,
                p.originating_state,
                p.base_price,
                p.category,
                p.incremental_charge,
                p.worth,
                p.max_weight,
                p.date_created,
             FROM ' . $this->table . ' p 
             LEFT JOIN 
                states s ON p.originating_state = s.id 
             ORDER BY 
                p.date_created DESC
             LIMIT 5 ';

            // prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();
            return $stmt;
        }

        // Get single transaction
        public function get_pricing() {
            $query = 'SELECT 
                *
             FROM ' . $this->table . ' p 
             LEFT JOIN 
                states s ON p.originating_state = s.id 
             WHERE 
                p.originating_state = '. $this->originating_state .'
            AND 
                p.category = "'. $this->category .'"
            LIMIT 0,5';

            // prepare statement;
            $stmt = $this->conn->prepare($query);

            // bind parameter
            // $stmt->bindParam(1, $this->originating_state);

            try{
                // Execute query
                $stmt->execute();
                
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
                //set properties
                if($row){
                    $this->id = $row['id'];
                    $this->originating_state_id = $row['originating_state'];
                    $this->originating_state_name = $row['name'];
                    $this->base_price = $row['base_price'];
                    $this->category = $row['category'];
                    $this->incremental_charge = $row['incremental_charge'];
                    $this->worth = $row['worth'];
                    $this->max_weight = $row['max_weight'];
                    $this->date_created = $row['date_created'];
                }

            }catch(PDOException $e){
                echo $e->getMessage();
            }
            return $stmt;
        }
    }
?>