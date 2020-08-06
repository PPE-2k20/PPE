<?php

/*
* Database Constants
* Make sure you are putting the values according to your database here 
*/
define('DB_HOST','5.39.62.4');
define('DB_USERNAME','w_415235');
define('DB_PASSWORD','103tr9qq');
define('DB_NAME', '415235_sql');

//Connecting to the database
$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

//checking the successful connection
if($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//making an array to store the response
$response = array();

//if there is a post request move ahead 
if($_SERVER['REQUEST_METHOD']=='POST'){

    //getting the name from request 
    $num_serie = $_POST['numero_serie'];
    $num_inter = $_POST['numero_intervention'];
    $temps = $_POST['temps_passer'];
    $com = $_POST['commentaire'];
    
    //creating a statement to insert to database 
    $stmt = $conn->prepare("INSERT INTO controler (numero_serie, numero_intervention, temps_passer, commentaire) VALUES (?,?,?,?)");

    //binding the parameter to statement 
    $stmt->bind_param("iiss",  $num_serie, $num_inter, $temps, $com);
    
    //if data inserts successfully
    if($stmt->execute()){
        //making success response 
        $response['error'] = false;
        $response['message'] = 'Intervention saved successfully';
        $requpdate = "UPDATE intervention SET validation = 1 WHERE numero_intervention = ".$num_inter;
        mysqli_query($conn, $requpdate);
    }else{
        //if not making failure response 
        $response['error'] = true;
        $response['message'] = 'Please try later';
    }

}else{
    $response['error'] = true;
    $response['message'] = "Invalid request";
}

//displaying the data in json format 
echo json_encode($response);
mysqli_close($conn);


