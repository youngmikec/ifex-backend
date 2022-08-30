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

    // Get waybill format from url
    $transaction->tracking_code = isset($_GET['tracking_code']) ? $_GET['tracking_code'] : die();

    // Get Transaction;
    $transaction->read_single();

    // create array
    $transaction_arr = array();
    $transaction_arr['status'] = true;
    $transaction_arr['message'] = 'Item retrieved successfully';
    $transaction_arr['payload'] = array(
        'id' => $transaction->id,
        'branch_id' => $transaction->branch_id,
        'branch_name' => $transaction->branch_name,
        'branch_long_name' => $transaction->branch_long_name,
        'branch_address' => $transaction->branch_address,
        'wayBillNum' => $transaction->wayBillNum,
        'waybill_format' => $transaction->waybill_format,
        'route_format' => $transaction->route_format,
        'branch_id' => $transaction->branch,
        'amount' => $transaction->amount,
        'pieces' => $transaction->pieces,
        'shipmentType' => $transaction->shipmentType,
        'timeCreated' => $transaction->timeCreated,
    );

    // convert to json
    print_r(json_encode($transaction_arr));

?>