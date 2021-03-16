<?php


include "../productService.php";

require_once "../../../config/config.php";
/**
 * UnitTest for driverDB.
 */

 class unitTestService{

    private $service;
    public function __construct($param){
        $this->service=new productService($param);

    }
    public function checkFields(){
        // Check wrong data inputs and injections
        $methodType="INSERT";
        $fields=[
            "name"=>"15236 2512",
            "description" => "INSERT INTO product(name) VALUES 'caca'",
            "price"=>"cosa",
            "id" => "5"
        ];
        
        echo $this->service->createProduct($fields,null);
        echo $this->service->updateProduct($fields);
        echo $this->service->getProduct($fields['id']);
        echo $this->service->deleteProduct($fields['id']);
    }
    

 }

$test = new unitTestService($param);
$test->checkFields();
?>