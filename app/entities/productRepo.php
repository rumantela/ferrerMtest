<?php

require_once "driverDB.php";
/**
 * Class. Manage the specific table for products
 * @param null
 * Inject data through methods. CRUD methods
 * createProduct, readProduct, updateProduct, deleteProduct.
 */

class productRepo{

    // Aqui va la insercción de datos concretos de la tabla
    private $db;
    
    
    /**
     * constructor. Set db driver with specific config
     */
    public function __construct($param){
        $resultado=$this->db = new driverDB($param);
        
    }

    /**
     * Method. Inserts a new register.
     * @return bool true if completed.
     */
    public function createProduct($args){
        return $this->db->setSQL("INSERT",$args,null);
    }
    /**
     * Method. Updates a register of a specific id
     * @return bool true if updated
     */
    public function updateProduct($args,$id){
        return $this->db->setSQL("UPDATE",$args,$id);
    }
    /**
     * Method. Deletes a register of a given id.
     * @return bool true if completed
     */
    public function deleteProduct($id){
        return $this->db->setSQL("DELETE",[],$id);
    }
    /**
     * Method. Reads the register of a given id.
     * @return array the data stored
     */
    public function readProduct($id){
        return $this->db->setSQL("SELECT",[],$id);
    }
}

?>