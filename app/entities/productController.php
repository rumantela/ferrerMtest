<?php
include "productService.php";

/**
 * Class. Main class to handle request and response.
 * it creates an instance of productService class and then it handles
 * requests depending on http_method. Analizes the method and params
 * and decides what to do. Sends an http response and json Object.
 * It takes data through the service.
 * @author Adolfo Sanchez Lopez
 * @param null
 * @return null Returns nothing
 */


class productController {

    private $service;

    private $notfound="Not found argument.";
    private $errorParam="Some arguments mixing or wrong data type.";
    private $errorRequest="Action not completed";
    private $notsupported="Method not supported";

    public function __construct($param){
        //$param = json_decode($param);
        $this->service = new productService($param);
    }

    /**
     * Method. Ones the object is initialized call this method to
     * handle the request. Depends on the http method do an action.
     *  -GET Reads a register
     *  -POST Create a register
     *  -PUT Update a register
     *  -DELETE Delete a register.
     * To call the CRUD for product table use http method. Works for
     * REST API. 
     * 
     */
    public function attendRequest(){
        
        $request=$_REQUEST;         // save $_REQUEST to have data saved.
        //echo var_dump($request);
        //$url="php://input";
        //$request=json_decode(file_get_contents($url));
        switch($_SERVER['REQUEST_METHOD']){
            case 'GET': 
                // Check id field isset
                if(isset($request['id'])){
                    $response=$this->service->getProduct($request['id']);
                    if($response!=="null"){
                        http_response_code(200);    // ok
                        echo $response;
                    }else{
                        http_response_code(404);
                        echo json_encode(["error"=>$this->notfound]);
                    }
                }else {
                    http_response_code(404);
                    echo json_encode(["error"=>$this->notfound]);
                }
            break;
            case 'POST':
                
                $response=$this->service->createProduct($request);
                if($response!=="null"){
                    http_response_code(201);    // created
                    echo $response;
                }else{
                    http_response_code(400);
                    echo json_encode(["error"=>$this->errorRequest]);
                }
            break;
            case 'PUT': 
                if(isset($_REQUEST['id'])){
                    $response=$this->service->updateProduct($request);
                    if($response!=="null"){
                        http_response_code(200);    // ok
                        echo $response;
                    }else{
                        http_response_code(400);        // not found
                        echo json_encode(["error"=>$this->errorParam]);
                    }
                }else{
                    http_response_code(404);
                    echo json_encode(["error"=>$this->notfound]);
                }
                
            break;
            case 'DELETE':
                $response=$this->service->deleteProduct($request['id']);
                if($response!=="null"){
                    http_response_code(204);    // no content
                    echo $response;
                }else{
                    http_response_code(404);        // not found
                    echo json_encode(["error"=>$this->notfound]);
                }
            break;
            default:
                http_response_code(405);        // method not supported
                echo json_encode(["error"=>$this->notsupported]);
            break;
        }
    }

}

?>