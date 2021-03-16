<?php

include "../productRepo.php";
require_once "../../../config/config.php";
/**
 * UnitTest for driverDB.
 */


 class unitTestRepo{

    private $db;
    public function __construct($param){
        $this->db=new productRepo($param);

    }
    public function checkFields(){
        // Check wrong data inputs and injections
        $id='20';
        $fields=[
            "name"=>"15236 2512",
            "description" => "AND INSERT INTO product(name) VALUES 'caca'",
            "price"=>"cosa"
        ];
        $id=4;
        $this->db->createProduct($fields,null);
        $this->db->updateProduct($fields,($id+1));
        $this->db->readProduct($id);
        $this->db->deleteProduct($id);
    }
    

 }

$test = new unitTestRepo($param);
$test->checkFields();
?>