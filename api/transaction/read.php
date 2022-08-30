<?php
    // add the required headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: applicatioin/json');

    include_once('../../config/database.php');
    include_once('../../models/transaction.php');

    // Instantiate database and connect;

    $database = new Database();
    $db = $database->connect();

    // instatiate our transaction object
    $transaction = new Transaction($db);

    // Transaction query;
    $result = $transaction->read();
    // get row count
    $num = $result->rowCount();

    // check any transaction;
    if($num > 0){
        $transactions_arr = array();
        $transactions_arr['status'] = 'success';
        $transactions_arr['message'] = $num . ' Transaction records found';
        $transactions_arr['payload'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $transaction_item = array(
                'id' => $id,
                'wayBillNum' => $wayBillNum,
                'wayBillFormat' => $waybill_format,
                'routeFormat' => $route_format,
                'amount' => $amount,
                'pieces' => $pieces,
                'shipmentType' => $shipmentType,
                'branch_id' => $branch,
                'branch_name' => $branch_name,
                'branch_long_name' => $branch_long_name,
                'branch_address' => $branch_address
            );
            // push to the data
            array_push($transactions_arr['payload'], $transaction_item);
        }

        // Turn data to json and output
        echo json_encode($transactions_arr);
    }else{
        echo json_encode(array('message' => 'No record found')); 
    }

?>