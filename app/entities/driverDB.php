<?php

/**
 * @author Adolfo Sanchez Lopez
 *  driver to handle the DB based on PDO:mysql
 */



 /**
  * Class. Drives the DB.
  *  @param host host of the DB
  *  @param dbname db name
  *  @param user username of the DB
  *  @param passwd password for the user
  *  @param opt rest of the options for PDO
  */


  class driverDB {

    private $dbname,$host,$user,$passwd,$opt,$dns;
    private $db;
    private $args=array();
    // Errors
    static private $error_connection = "Connection error";
    static private $error_create = "Creation rejected.";
    static private $error_read = "Not found.";
    static private $error_update = "Not updated.";
    static private $error_delete = "Deleting error.";
    
    // constructor
    public function __construct($param){
      
      // default config DB
      $this->host=$param['host'];
      $this->dbname = $param['dbname'];
      $this->user=$param['user'];
      $this->passwd=$param['passwd'];
      //$this->opt = $param['opt']
      $this->opt = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
      $this->args=[
          "host"=>  $this->host,
          "user"=> $this->user,
          "dbname"=> $this->dbname,
          "passwd"=> $this->passwd,
          "opt"=> $this->opt,
      ];
    }


    // setter methods
    public function setDB($dbname){
      $this->dbname = $dbname;
    }
    public function setHost($host){
      $this->host = $host;
    }
    public function setUser($user){
      $this->user = $user;
    }
    public function setPasswd($passwd){
      $this->passwd=$passwd;
    }
    public function setParams($args){
      $this->args = $args;
    }
    public function __set($name, $value) {
      $this->args[$name]=$value;
    }
    // getter methods


    // Especific
    /**
    * setSQL. Set the sql sentece to query.
    * @return Object Mysql query.
    * @param String $sqlType INSERT, UPDATE, DELETE
    * @param String $table Name of the table
    * @param Array $fields Columns of the table must be an array $key => $value.
    */
    public function setSQL($sqlType,$fields,$id){
      try{
        $this->args['dsn'] = "mysql:host=".$this->args['host'].";dbname=". $this->args['dbname'];
        $db = new PDO($this->args['dsn'], $this->args['user'], $this->args['passwd']);
        //$this->db=$db;

      
        switch($sqlType){
          case "INSERT":
            
            $sql=$db->prepare("INSERT INTO product (name,description,price) VALUES (:name,:description,:price)");
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
            $sql->bindParam(':name',$fields['name'],PDO::PARAM_STR);
            $sql->bindParam(':description',$fields['description'],PDO::PARAM_STR);
            $sql->bindParam(':price',$fields['price'],PDO::PARAM_STR);
            $resultado = $sql->execute();
            $db=null;
            if($resultado){
              return $resultado;
            }
            // close conection ?
            return null;
            break;
            
          case "UPDATE":
            $resultado=null;
            foreach ($fields as $key => $value){
              $sql=$db->prepare("UPDATE product SET ".$key."=:value WHERE id=:id");
              $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
              $sql->bindValue(":value",$value,PDO::PARAM_STR);
              $sql->bindValue(":id",$id,PDO::PARAM_INT);
              $resultado=$sql->execute();
            }
            $db=null;
            // close conection ?
            if($resultado!==false){
              return $resultado;
            }
            return null;           
            break;

          case "DELETE":
            $sql=$db->prepare("DELETE FROM product WHERE id=:id");
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
            $sql->bindValue(":id",$id,PDO::PARAM_STR);
            $resultado=$sql->execute();
            $db=null;
            if($resultado){
              return $resultado;
            }
            return null;
            break;

          case "SELECT":
            $sql=$db->prepare("SELECT * FROM product WHERE id=:id");
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
            $sql->bindValue(":id",$id,PDO::PARAM_INT);
            $resultado=$sql->execute();
            if($resultado!==false){
              $row=$sql->fetch();
              if($row!=null){
                while($row!=null){
                    $product[]=$row;
                    $row=$sql->fetch();
                }
              return $product;
              }
            }
            return null;
            break;
          default:
            $db = null;
            return NULL;
          break;
        }
      }catch (PDOException $e){
        error_log($e->getMessage(),0);
        return $error_connection;
      }

    }


  }

?>