<?php
    class Client {
        private $conn;
        private $table_name = 'clients';
        
        public $id;
        public $client_name;
        public $clientcat;
        public $client_address;
        public $state;
        public $contact_person;
        public $contact_phone;
        public $client_phone;
        public $client_phone2; 
        public $client_email;
        public $client_email2;
        public $invoice_frequency;
        public $balance;
        public $name_on_invoice;
        public $bank_name;
        public $account_number;
        public $approved_by;
        public $rates;
        public $client_status;
        public $comment;
        public $hashed_password;
        public $password;
        public $datetime;

        public function __construct($db) {
            $this->conn = $db;
        }

        function login() {
            $query = "SELECT hashed_password FROM clients WHERE client_email='kugwuokwy@yahoo.com'";
            $stmt = $this->conn->prepare($query);

            try{
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->hashed_password = $row['hashed_password'];
                echo $this->verify_password($this->password, $this->hashed_password);
                if($this->hashed_password){
                }
            }catch(PDOException $e){
                echo $e->getMessage();
            }

        }

        protected function set_hashed_password() {
            $this->hashed_password = password_hash($this->password, PASSWORD_BCRYPT);
          }

        public function verify_password($password) {
            return password_verify($password, $this->hashed_password);
        }
    }


?>