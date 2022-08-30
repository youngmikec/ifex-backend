<?php
    // add the required headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: applicatioin/json');

    include_once('../../config/database.php');
    include_once('../../models/trans_track.php');

    // Instantiate database and connect;

    $database = new Database();
    $db = $database->connect();

    // instatiate our transaction object
    $trans_track = new TransactionTrack($db);

    // Get waybill format from url
    $trans_track->tracking_code = isset($_GET['tracking_code']) ? $_GET['tracking_code'] : die();

    // Get Transaction;
    $trans_track->track_item();
    if($trans_track->id){
        $item = $trans_track->track();
        if($item){
            $transaction_arr = array();
            $transaction_arr['status'] = true;
            $transaction_arr['message'] = 'Item retrieved successfully';
            $transaction_arr['payload'] = array(
                'id' => $item['id'],
                'trans_id' => $item['trans_id'],
                'status_id' => $item['status'],
                'status_name' => $item['status_name'],
                'time' => $item['time'],
                'rider_id' => $item['rider_id'],
                'receiver_name' => $item['receiver_name'],
                'phone' => $item['phone'],
                'comments' => $item['comments'],
                'airline' => $item['airline'],
                'source' => $item['source'],
                'destination' => $item['destination'],
            );
        
            // convert to json
            print_r(json_encode($transaction_arr));
        }else{
            $transaction_arr = array();
            $transaction_arr['status'] = false;
            $transaction_arr['message'] = 'No tracking detail found';
            $transaction_arr['payload'] = array();
            print_r(json_encode($transaction_arr));
        }
    }

