<?php
    // add the required headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: applicatioin/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type,Access-Control-Allow-Origin,X-Requested-With, Authorization');

    include_once('../../config/database.php');
    include_once('../../models/employee.php');

    // Instantiate database and connect;

    $database = new Database();
    $db = $database->connect();

    // instatiate our transaction object
    $employee = new Employee($db);

    // Get email and password from post request
    $data = json_decode(file_get_contents("php://input"));
    // htmlspecialchars(strip_tags())
    $employee->input_email = $data->email ? $data->email : die();
    $employee->input_password = $data->password ? $data->password : die();

    // login;
    $employee->login();

    if($employee->isLoggedIn){
        $employee_arr = array();
        $employee_arr['status'] = true;
        $employee_arr['message'] = 'Admin login successful';
        $employee_arr['payload'] = array(
            'expiresIn' => 20220830120012200
        );
        print_r(json_encode($employee_arr));
    }else {
        $employee_arr = array();
        $employee_arr['status'] = false;
        $employee_arr['message'] = 'Login failed';
    
        print_r(json_encode($employee_arr));

    }
    // create array  

    // convert to json

?>