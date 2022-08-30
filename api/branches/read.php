<?php

 // add the required headers
 header('Access-Control-Allow-Origin: *');
 header('Content-Type: applicatioin/json');

 include_once('../../config/database.php');
 include_once('../../models/branch.php');

 $database = new Database();
 $db = $database->connect();

 $branch = new Branch($db);

 $result = $branch->read();

 $num = $result->rowCount();

 if($num > 0){
    $branches_arr = array();
    $branches_arr['status'] = 'success';
    $branches_arr['message'] = $num . ' Branch records found';
    $branches_arr['payload'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $branch_item = array(
            'id' => $id,
            'name' => $name,
            'long_name' => $long_name,
            'address' => $address,
            'state_id' => $state_id,
            'state_name' => $state_name,
            'created_by' => $created_by,
            'date' => $date,
        );

        array_push($branches_arr['payload'], $branch_item);
    }

    echo json_encode($branches_arr);
 }else {
    echo json_encode(array('message' => 'No record found')); 
}

?>