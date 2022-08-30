<?php
    // add the required headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: applicatioin/json');

    include_once('../../config/database.php');
    include_once('../../models/state.php');

    // Instantiate database and connect;

    $database = new Database();
    $db = $database->connect();

    // instatiate our transaction object
    $state = new State($db);

    // Transaction query;
    $result = $state->read();
    // get row count
    $num = $result->rowCount();

    // check any transaction;
    if($num > 0){
        $state_arr = array();
        $state_arr['status'] = 'success';
        $state_arr['message'] = $num . ' State records found';
        $state_arr['payload'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $state_item = array(
                'id' => $id,
                'name' => $name,
            );
            // push to the data
            array_push($state_arr['payload'], $state_item);
        }

        // Turn data to json and output
        echo json_encode($state_arr);
    }else{
        echo json_encode(array('message' => 'No record found')); 
    }

?>