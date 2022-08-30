<?php
    class Transaction {
        private $conn;
        private $table = 'transaction';

        // Transaction properties
        public $tracking_code;
        public $id;
        public $branch_id;
        public $branch_name;
        public $branch_long_name;
        public $branch_address;
        public $wayBillNum;
        public $waybill_format;
        public $route_format;
        public $branch;
        public $amount;
        public $pieces;
        public $shipmentType;
        public $timeCreated;

        // constructor with db
        public function __construct($db) {
            $this->conn = $db;
        }

        public function read () {
            $query = 'SELECT 
                b.name as branch_name,
                b.long_name as branch_long_name,
                b.address as branch_address,
                t.id,
                t.wayBillNum,
                t.waybill_format,
                t.route_format,
                t.amount,
                t.pieces,
                t.branch,
                t.shipmentType,
                t.timeCreated
             FROM ' . $this->table . ' t 
             LEFT JOIN 
                branches b ON t.branch = b.id 
             ORDER BY 
                t.timeCreated DESC
             LIMIT 5 ';

            // prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();
            return $stmt;
        }

        // Get single transaction
        public function read_single() {
            $query = 'SELECT 
                b.name as branch_name,
                b.long_name as branch_long_name,
                b.address as branch_address,
                t.id,
                t.wayBillNum,
                t.waybill_format,
                t.route_format,
                t.amount,
                t.pieces,
                t.branch,
                t.shipmentType,
                t.timeCreated
             FROM ' . $this->table . ' t 
             LEFT JOIN 
                branches b ON t.branch = b.id 
             WHERE 
                t.waybill_format = ?
            LIMIT 0,1';

            // prepare statement;
            $stmt = $this->conn->prepare($query);

            // bind parameter
            $stmt->bindParam(1, $this->tracking_code);

            // Execute query
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //set properties
            $this->id = $row['id'];
            $this->branch_id = $row['branch'];
            $this->branch_name = $row['branch_name'];
            $this->branch_long_name = $row['branch_long_name'];
            $this->branch_address = $row['branch_address'];
            $this->wayBillNum = $row['wayBillNum'];
            $this->waybill_format = $row['waybill_format'];
            $this->route_format = $row['route_format'];
            $this->branch = $row['branch'];
            $this->amount = $row['amount'];
            $this->pieces = $row['pieces'];
            $this->shipmentType = $row['shipmentType'];
            $this->timeCreated = $row['timeCreated'];
        }
    }
?>