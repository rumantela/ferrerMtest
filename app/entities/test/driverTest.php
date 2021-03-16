<?php

include "../driverDB.php";
/**
 * UnitTest for driverDB.
 */

 class unitTestDriver{

    private $db;
    private $param=[
        "host"=>"localhost",
        "dbname" => "ferrer",
        "user" => "root",
        "passwd" =>"",
        "opt" => array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
    ];
    public function __construct(){
        $this->db=new driverDB($this->param);

    }

    public function checkFields(){
        // Check wrong data inputs and injections

        $methodType="INSERT";
        for($i=0;$i<20;$i++){
            $fields=[
                "name"=>"producto".$i,
                "description" => "INSERT INTO product(name) VALUES 'caca'",
                "price"=>"cosa"
            ];
            $this->db->setSQL($methodType,$fields,null);
        }
        
    }
    

 }

$test = new unitTestDriver();
$test->checkFields();
?>