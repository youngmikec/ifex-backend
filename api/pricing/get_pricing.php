<?php
    // add the required headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: applicatioin/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type,Access-Control-Allow-Origin,X-Requested-With, Authorization');

    include_once('../../config/database.php');
    include_once('../../models/pricing.php');

    // Instantiate database and connect;

    $database = new Database();
    $db = $database->connect();

    // instatiate our pricing object
    $pricing = new Pricing($db);

    // Get waybill format from url
    // $pricing->originating_state = isset($_GET['state_id']) ? $_GET['state_id'] : die();
    $data = json_decode(file_get_contents("php://input"));
    $pricing->originating_state = $data->state_id ? $data->state_id : die();
    $pricing->category = $data->category ? htmlspecialchars(strip_tags($data->category)) : die();

    // Get pricing;
    $result = $pricing->get_pricing();

    if($result){
        // create array
        $pricing_arr = array();
        $pricing_arr['status'] = true;
        $pricing_arr['message'] = 'Price retrieved successfully';
        $pricing_arr['payload'] = array(
            'id' => $pricing->id,
            'originating_state_id' => $pricing->originating_state_id,
            'state_name' => $pricing->originating_state_name,
            'base_price' => $pricing->base_price,
            'category' => $pricing->category,
            'incremental_charge' => $pricing->incremental_charge,
            'worth' => $pricing->worth,
            'max_weight' => $pricing->max_weight,
            'date_created' => $pricing->date_created,
        );
        // convert to json
        print_r(json_encode($pricing_arr));
    }else {
        $pricing_arr = array();
        $pricing_arr['status'] = false;
        $pricing_arr['message'] = 'Error occured while retreiving pricing';
        $pricing_arr['payload'] = array();
        // convert to json
        print_r(json_encode($pricing_arr));
        
    }


?>