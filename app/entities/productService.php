<?php
include_once "productRepo.php";


/**
 * Class. Manage data and bussiness logic.
 * @param array Database configuration.["host"=>"localhost",...]
 * host, dbname, user, passwd, opt (options for PDOmysqli)
 */

class productService {



// menssages

// private variables
    private $db;
    private $errorParam = ["error"=>"Mixing params"];
    private $notExec = ["error"=>"Not executed SQL sentence."];

/**
 * Constructor. Creates an instance of productRepo.
 */
    public function __construct ($param){

        $this->db = new productRepo($param);  
    }

    /**
     * Method. Search in database the register that its id is equal to the one given.
     * @return Object A json object of the register.
     */
    public function getProduct($id) {
        
        $product=$this->db->readProduct($id);
        $jsonResponse=json_encode($product);
        return $jsonResponse;
    }

    /**
     * Method. Insert a new product in the database.
     * @param Array Array must contains name, description and price
     * @return Object Returns a json object or null
     */

    public function createProduct($args){
        // Check data
        // check price format, decimals and trunk
        
        $args['price'] = round ($args['price'],4);
        if(isset($args['name'])&&isset($args['description'])){
            if($args['name']!==null && $args['description']!==null){
                // If it comes more data is ignore
                $response = $this->db->createProduct($args);
                if($response!==null){
                    return json_encode($response);
                }else{
                    return $this->notExec;
                }
                
            }else{
                return $this->errorParam;
            }
        }
        
    }

    /**
     * Method. Updates a register with the data given.
     * @return 
     */
    public function updateProduct($args){
        // It just can update name, price and description, the rest is updated
        // if needed otherway. Ex. triggers.
        // id is mandatory.
        $data = array();
        if($args['id']!==null){
            // filter exact data needed
            foreach($args as $key => $value){
                if($key=="name"||$key=="description"||$key=="price"){
                    $data[$key]=$value;
                }
            }
            $response = $this->db->updateProduct($data,$args['id']);
            return json_encode($response);
        }else{
            return json_encode(null);
        }
        
    }
    /**
     * Method. Deletes the register that its id is equal to the one given.
     * @return Object json object or null.
     * @param Int The id of the register to be deleted.
     */
    public function deleteProduct($id){
        
        if($id!==null){
            $response = $this->db->deleteProduct($id);
            return json_encode($response);
        }else{
            return null;
        }
    }
}


?>