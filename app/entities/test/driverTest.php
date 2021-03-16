<?php

include "../driverDB.php";
/**
 * UnitTest for driverDB.
 * Note. Test must be run first than adding registers to the table.
 * Can be use to mock.
 * uncomment to delete.
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
                "name"=>"product".$i,
                "description" => "Description ".$i,
                "price"=>"10.32562"
            ];
            $this->db->setSQL($methodType,$fields,$i);
        }
        $methodType="SELECT";
        for($i=0;$i<20;$i++){
            $this->db->setSQL($methodType,$fields,$i);
        }
        $methodType="UPDATE";
        for($i=0;$i<20;$i++){
            $fields=[
                //"name"=>"product".($i+1),
                "description" => "Description ".($i+1),
                "price"=>"10.32562"
            ];
            $this->db->setSQL($methodType,$fields,$i);
        }
        /*
        $methodType="DELETE";
        for($i=0;$i<20;$i++){
            $fields=[
                "name"=>"product".$i,
                "description" => "Description ".$i,
                "price"=>"10.32562"
            ];
            $this->db->setSQL($methodType,$fields,$i);
        }*/
        
    }

    function checkData(){
        $id='19';
        // data and injections
        $methodType="INSERT";
        $fields=[
            "name"=>"1234",
            "description" => "AND name='cosa' WHERE id='1' ",
            "price"=>"10.32562"
        ];
        $this->db->setSQL($methodType,$fields,$id);
        $methodType="INSERT";
        $fields=[
            "name"=>"product",
            "description" => "Description ",
            "price"=>"hola"
        ];
        $this->db->setSQL($methodType,$fields,$id);
        // wrong id format
        $methodType="SELECT";
        $id='he';
        $fields=[
            "name"=>"product",
            "description" => "Description ",
            "price"=>"10.32562"
        ];
        $this->db->setSQL($methodType,$fields,$id);
        $methodType="SELECT";
        $id='12.1';
        $fields=[
            "name"=>"product",
            "description" => "Description ",
            "price"=>"10.32562"
        ];
        $this->db->setSQL($methodType,$fields,$id);
        $methodType="UPDATE";
        $id='he';
        $fields=[
            "name"=>"product",
            "description" => "Description ",
            "price"=>"10.32562"
        ];
        $this->db->setSQL($methodType,$fields,$id);
        $methodType="UPDATE";
        $id='12.1';
        $fields=[
            "name"=>"product",
            "description" => "Description ",
            "price"=>"10.32562"
        ];
        $this->db->setSQL($methodType,$fields,$id);
    }
    

 }

$test = new unitTestDriver();
$test->checkFields();
$test->checkData();
?>