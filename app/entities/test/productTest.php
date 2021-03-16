<?php

/**
 * test using curl to test REST API
 */

function callAPI($method, $url, $data){
    $curl = curl_init();
    switch ($method){
       case "POST":
          curl_setopt($curl, CURLOPT_POST, false);
          if ($data)
             curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
          break;
       case "PUT":
          curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
          if ($data)
             curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
          break;
       
       default:
          if ($data)
             $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    // OPTIONS:
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
       'APIKEY: 111111111111111111111',
       'Content-Type: application/json',
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // EXECUTE:
    $result = curl_exec($curl);
    if(!$result){die("Connection Failure");}
    curl_close($curl);
    return $result;
}
 

$j=0;

$url="http://localhost/ferrerMtest/public/product.php";

/*
// POST REQUEST TEST
$data_array=array();
for($j=0;$j<10;$j++){
    $data_array[$j] =  [
        "name" => "producto".$j,
        "descrition" => "description ".$j,
        "price" => (int)(100+$j*10)
    ];
    $make_call = callAPI('POST', $url, json_encode($data_array));
    $response = json_decode($make_call, true);
    var_dump($response);
} */


// GET REQUEST TEST
for($i=0;$i<50;$i++){
    $get_data = callAPI('GET', $url."?id=".$i,false);
    $response = json_decode($get_data, true);
    var_dump($response);
} 
/*
// PUT REQUEST TEST
for($i=0;$i<50;$i++){
   $get_data = callAPI('PUT', $url."?id=".$i,json_encode($data_array));
   $response = json_decode($get_data, true);
   var_dump($response);
} */

?>