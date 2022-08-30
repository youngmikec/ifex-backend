<?php
    // add the required headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: applicatioin/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type,Access-Control-Allow-Origin,X-Requested-With, Authorization');

    include_once('../../config/database.php');
    include_once('../../models/client.php');

    // Instantiate database and connect;

    $database = new Database();
    $db = $database->connect();

    // instatiate our transaction object
    $client = new Client($db);

    // Get email and password from post request
    $data = json_decode(file_get_contents("php://input"));
    $client->client_email = $data->email ? htmlspecialchars(strip_tags($data->email)) : die();
    $client->password = $data->password ? $data->password : die();

    // login;
    $client->login();

    // create array  
    $client_arr = array();
    $client_arr['status'] = true;
    $client_arr['message'] = 'User Found';
    $client_arr['payload'] = array(
        'hashed_password' => $client->hashed_password,
    );

    // convert to json
    print_r(json_encode($client_arr));

?>