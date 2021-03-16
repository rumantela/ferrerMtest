<?php

include_once "../app/entities/productController.php";
require_once "../config/config.php";            // database config
/**
 * Api target.
 * Main url for the api rest and http request.
 * First sets the class controller for handling request, 
 * then handles the request through $_SERVER gets method
 * type and through $_REQUEST gets data.
 * The API expects to recive data through params and not
 * through resources.
 * To configure the database modify config.php file.
 */

 
//echo $request = json_decode(file_get_contents('php://input',true));
//var_dump($request);

$controller = new productController($param);
$controller->attendRequest();


?>