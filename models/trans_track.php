<?php
    class TransactionTrack {
        private $conn;
        private $table = 'transaction';
        private $track_table = 'trans_track';
        private $status_table = 'status';

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

        //transaction_track properties
        public $track_id;
        public $trans_id;
        public $status_id;
        public $status_name;
        public $time;
        public $rider_id;
        public $receiver_name;
        public $phone;
        public $comments;
        public $airline;
        public $source;
        public $destination;
        public $updated_by;
        public $deleted;

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
        public function track_item() {
            $query = "SELECT t.id FROM " . $this->table . " t WHERE t.waybill_format = ? LIMIT 0,1";

            $stmt = $this->conn->prepare($query);
    
            $stmt->bindParam(1, $this->tracking_code);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            //SET RETURNED TRANSACTION ID;
            $this->id = $row['id'];

            // if($this->id){
            //     $this->track();
            // }else{
            //     echo 'error occured';
            // }
        }

        public function track() {
            
            $query_string = 'SELECT 
                s.name as status_name,
                t.status,
                t.id,
                t.trans_id,
                t.status,
                t.time,
                t.rider_id,
                t.receiver_name,
                t.phone,
                t.comments,
                t.airline,
                t.source,
                t.destination
            FROM '. $this->track_table . ' t
            LEFT JOIN 
                status s ON t.status = s.id
            WHERE
                t.trans_id ='. $this->id .'
            LIMIT 0,1
            '; 
    
            $stmt = $this->conn->prepare($query_string);
            $stmt->execute();
            $item = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $track_id = $item['id'];
            $trans_id = $item['trans_id'];
            $status_id = $item['status'];
            $status_name = $item['status_name'];
            $time = $item['time'];
            $rider_id = $item['rider_id'];
            $receiver_name = $item['receiver_name'];
            $phone = $item['phone'];
            $comments = $item['comments'];
            $airline = $item['airline'];
            $source = $item['source'];
            $destination = $item['destination'];
            
            return $item;
            
        }
    }

?>