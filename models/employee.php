<?php
    class Employee {
        private $conn;
        private $table_name = 'employee';
        
        public $id;
        public $first_name;
        public $last_name;
        public $email;
        public $username;
        public $hashed_password;
        public $department;
        public $division;
        public $job_title;
        public $contract_type;
        public $salary; 
        public $nhf;
        public $leave_allowance_id;
        public $address;
        public $city;
        public $lga;
        public $state;
        public $branch;
        public $phone;
        public $gender;
        public $dob;
        public $age;
        public $marital_status;
        public $region;
        public $admin_level;
        public $creator;
        public $deleted;
        public $logistic;
        public $acc;
        public $hr;
        public $created_date;
        public $join_date;
        public $payed_salary;

        public $input_password;
        public $input_email;
        public $isLoggedIng;
        

        public function __construct($db) {
            $this->conn = $db;
        }

        function login() {
            $query = 'SELECT * FROM employee  WHERE email= "'. $this->input_email. '" LIMIT 0,1';
            $stmt = $this->conn->prepare($query);

            try{
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->hashed_password = $row['hashed_password'];
                $result = $this->verify_password($this->input_password, $this->hashed_password);
                if($result){
                    $this->isLoggedIn = true;
                }
            }catch(PDOException $e){
                $this->isLoggedIn = false;
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