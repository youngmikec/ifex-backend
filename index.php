<?php

$serverName = 'localhost';
$username = 'root';
$password = '';
$databaseName = 'ifexex5_app';

$conn = mysqli_connect($serverName, $username, $password, $databaseName);
// $query = "INSERT INTO test (question, choiceA, choiceB, choiceC, correct) VALUES('How many colors are in Nigerian flag', 'correct', 'wrong', 'wrong', 'A')";
$query = "SELECT * FROM test";

if(mysqli_query($conn, $query)){
    echo "Data inserted successfully";
    $method = $_SERVER['REQUEST_METHOD'];
    if($method === 'GET'){
        retrieveQuestion();
    }
}else {
    echo "Error occured";
}

function retrieveQuestion () {
    $query = "SELECT * FROM test";
    $result = mysqli_query($conn, $query);

    if($result){
        $row = $result->fetch_assoc();
        echo $row;
    }
}
