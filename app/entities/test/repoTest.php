<?php

include "../productRepo.php";
/**
 * UnitTest for driverDB.
 */

 class unitTestRepo{

    private $db;
    public function __construct(){
        $this->db=new productRepo();

    }
    public function checkFields(){
        // Check wrong data inputs and injections
        $methodType="INSERT";
        $fields=[
            "name"=>"15236 2512",
            "description" => "INSERT INTO product(name) VALUES 'caca'",
            "price"=>"cosa"
        ];
        $id=4;
        $this->db->createProduct($fields,null);
        $this->db->updateProduct($fields,$id);
        $this->db->readProduct($id);
        $this->db->deleteProduct($id);
    }
    

 }

$test = new unitTestRepo();
$test->checkFields();
?>