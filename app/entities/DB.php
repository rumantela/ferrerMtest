<?php

/** 
 * 
 * @author Adolfo Sánchez López
 * Clase que maneja bases de datos usando PDO:mysql
 * Para configurar la setDB(args)
 * @param args host, user, dbname, passwd, opc
 */       
        
class DB{
    
    private $dbname,$host,$user,$passwd,$opc,$dns;
    private $db;
    private $args=array();

    public function __construct() {
        $this->host="localhost";
        $this->user="raspbee";
        $this->passwd="2768453577Ruman";
        $this->opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        $this->args=[
            "host"=>  $this->host,
            "user"=> $this->user,
            "dbname"=> $this->dbname,
            "passwd"=> $this->passwd,
            "opc"=> $this->opc,
        ];
        
    }
    
    // Setter y getter
    public function setDB($args) {
        $this->args=$args;
    }
    public function __set($name, $value) {
        $this->args[$name]=$value;
    }
    
    public function getDb() {
        return $this->db;
    }
    
    public function getDns() {
        return $this->args['dns'];
    }

    // FIN Setter y getter
    
    //////////////////////////////////////
    // Métodos globales
    /////////////////////
    
    
    protected function querySql($sql){
        $this->args['dsn'] = "mysql:host=".$this->args['host'].";dbname=". $this->args['dbname'];
        $db = new PDO($this->args['dsn'], $this->args['user'], $this->args['passwd']);
        $this->db=$db;
        $resultado = null;
        if (isset($db)) {
            $resultado = $db->query($sql);
            return $resultado;
        }else{
            return FALSE;
        }
    }
    protected function execSql($sql){
        $this->args['dsn'] = "mysql:host=".$this->args['host'].";dbname=". $this->args['dbname'];
        $db = new PDO($this->args['dsn'], $this->args['user'], $this->args['passwd']);
        $this->db=$db;
        $resultado = null;
        if (isset($db)) {
            $db->beginTransaction();
            print $sql;
            $resultado = $db->exec($sql);
            if($resultado!=false){
            $db->commit();
            return $resultado;
            }else{
                $db->rollBack();
            }
        }else{
            return FALSE;
        }
    }
    
    /////////////////////////////////////
    // Métodos especificos
    ////////////////////////
     /**
     * Método getCoches()- Hace una petición a la base de datos para traer todo
     * el contenido de la tabla "coche", lo trata y devuelve un array con todos
     * los datos
     * @return array Array con los elementos de la tabla coches, para saber su 
     *                  estructura consultar la base de datos
     */

    
    
     public function getColmenares($usuario){
         $sql="SELECT * FROM colmenar WHERE usuario='".$usuario."'";
         $resultado=self::querySql($sql);
         if($resultado!=null){
         $row=$resultado->fetch();
         if($row!=null){
         while($row!=null){
             $colmenares[]=$row;
             $row=$resultado->fetch();
         }
         return $colmenares;
         }
         }
         return null;
     }
     
     public function getApicultorID($usuario){
         $sql="SELECT apicultorID FROM apicultores WHERE usuario='".$usuario."'";
         $resultado=self::querySql($sql);
         if($resultado!=null){
         $row=$resultado->fetch();
         if($row!=null){
            while($row!=null){
                $colmenares[]=$row;
                $row=$resultado->fetch();
                }
            return $colmenares;
            }
         }
         return null;
     }
     
     public function getColmenas($colmenar){
         $sql="SELECT * FROM colmenas WHERE colmenarID='".$colmenar."'";
         $resultado=self::querySql($sql);
         $row=$resultado->fetch();
         if($row!=null){
            while($row!=null){
                $colmenas[]=$row;
                $row=$resultado->fetch();
            }
            return $colmenas;
         }
         return null;
    }
    
    
    
    public function getMiel($colmena) {
        $sql = "SELECT cantidad,fecha FROM miel WHERE colmenaID='".$colmena."' ORDER BY fecha ASC";
        $resultado=self::querySql($sql);
        if(!empty($resultado)){
            $row=$resultado->fetch();
            if($row!=null){
               while($row!=null){
                   $miel[]=$row;
                   $row=$resultado->fetch();
               }
               return $miel;
            }
        }
         return null;
    }
    public function getPolen($colmena) {
        $sql = "SELECT cantidad,fecha FROM polen WHERE colmenaID='".$colmena."'";
        $resultado=self::querySql($sql);
        if(!empty($resultado)){
            $row=$resultado->fetch();
             if($row!=null){
                while($row!=null){
                    $miel[]=$row;
                    $row=$resultado->fetch();
                }
                return $miel;
             }
        }
         return null;
    }
    public function getEntradas($colmena) {
        $sql = "SELECT cantidad,fecha FROM vuelos WHERE colmenaID='".$colmena."'";
        $resultado=self::querySql($sql);
        if(!empty($resultado)){
            $row=$resultado->fetch();
             if($row!=null){
                while($row!=null){
                    $miel[]=$row;
                    $row=$resultado->fetch();
                }
                return $miel;
             }
        }
         return null;
    }
    public function getNectar($colmena) {
        $sql = "SELECT cantidad,fecha FROM nectar WHERE colmenaID='".$colmena."'";
        $resultado=self::querySql($sql);
        if(!empty($resultado)){
            $row=$resultado->fetch();
            if($row!=null){
               while($row!=null){
                   $miel[]=$row;
                   $row=$resultado->fetch();
               }
               return $miel;
           }
        
            }
         return null;
    }
    public function getPoblacion($colmena) {
        $sql = "SELECT cantidad,fecha FROM obreras WHERE colmenaID='".$colmena."'";
        $resultado=self::querySql($sql);
        if(!empty($resultado)){
            $row=$resultado->fetch();
            if($row!=null){
                while($row!=null){
                    $miel[]=$row;
                    $row=$resultado->fetch();
                }
                return $miel;
             }
        }
         return null;
    }
    
    public function getEstado($colmena){
        $sql = "SELECT estado FROM estado WHERE colmenaID='".$colmena."'";
        $resultado=self::querySql($sql);
        if(!empty($resultado)){
            $row=$resultado->fetch();
            if($row!=null){
                while($row!=null){
                    $miel[]=$row;
                    $row=$resultado->fetch();
                }
                
                return $miel[0];
             }
        }
         return null;
    }


    public function setUser($usuario,$password) {
        $sql="INSERT INTO usuarios (usuario,password) VALUES ('".$usuario."','".$password."')";
        $resultado=self::execSql($sql);
        if($resultado!=NULL){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    public function setApicultor($param) {
        $sql="INSERT INTO apicultores (nombre,apellido1,apellido2,direccion,telefono,email,usuario)"
                . " VALUES ('".$param['nombre']."','"
                .$param['apellido1']."','"
                .$param['apellido2']."','"
                .$param['direccion']."','"
                .$param['telefono']."','"
                .$param['email']."','"
                .$param['usuario']."')";
        $resultado=self::querySql($sql);
        if($resultado!=null){
            return true;
        }else{
            return false;
        }
    }
    
    public function setColmenar($param) {
        $sql="INSERT INTO colmenar (apicultorID,localidad,coordenadaX,coordenadaY,numColmenas,estado,usuario)"
                . " VALUES ('".$param['apicultorID']."','"
                .$param['localidad']."','"
                .$param['coordenadaX']."','"
                .$param['coordenadaY']."','"
                .$param['numColmenas']."','"
                .$param['estado']."','"
                .$param['usuario']."')";
        $resultado=self::querySql($sql);
        if($resultado!=null){
            return true;
        }else{
            return false;
        }
    }
    
    public function updateColmenar($param) {
        $sql="UPDATE colmenar SET "
                ."apicultorID=".$param["apicultorID"]. ""
                . "localidad=".$param["localidad"].""
                . "coordenadaX=".$param['coordenadaX'].""
                . "coordenadaY=".$param['coordenadaY'].""
                . "numColmenas".$param["numColmenas"].""
                . "estado=".$param["estado"].""
                . "colmenarID=".$param["colmenarID"];
        $resultado=self::querySql($sql);
        if($resultado!=null){
            return true;
        }else{
            return false;
        }
    }
    
    public function setColmena($param){
        $sql="INSERT INTO colmenas (colmenaID, colmenarID, tipo, miel, polen, nectar, poblacion)"
                . " VALUES (NULL,".$param['colmenarID'].",'"
                .$param["tipo"]."',"
                .$param['miel'].","
                .$param['polen'].","
                .$param['nectar'].","
                .$param['poblacion'].")";
        $resultado=self::querySql($sql);
        if($resultado!=null){
            return true;
        }else{
            return false;
        }
    }
    
    public function updateIP($ip,$colmenarID,$user){
        $sql="UPDATE colmenar SET ip='".$ip."' WHERE colmenarID=".$colmenarID." AND usuario='".$user."'";
        $resultado=self::querySql($sql);
        if($resultado!=null){
            return true;
        }else{
        return false;
        }
    }
    
    public function updateColmena($param){
        $sql="UPDATE colmenas SET "
                ."miel=".$param['miel'].","
                ."polen=".$param['polen'].","
                ."nectar=".$param['nectar'].","
                ."poblacion=".$param['poblacion']." WHERE colmenaID=".$param['colmenaID'];
        $resultado=self::querySql($sql);
        
        if($resultado!=null){
            return true;
        }else{
            return false;
        }
    }
  
    function setMiel($param) {
        $sql="INSERT INTO miel (colmenarID,colmenaID,cantidad,fecha)"
                . " VALUES ('".$param['colmenarID']."','"
                .$param['colmenaID']."','"
                .$param['cantidad']."','"
                .$param['fecha']."')";
        $resultado=self::querySql($sql);
        if($resultado!=null){
            return true;
        }else{
            return false;
        }
    }
    function setEntradas($param) {
        $sql="INSERT INTO vuelos (colmenarID,colmenaID,cantidad,fecha)"
                . " VALUES ('".$param['colmenarID']."','"
                .$param['colmenaID']."','"
                .$param['cantidad']."','"
                .$param['fecha']."')";
        $resultado=self::querySql($sql);
        if($resultado!=null){
            return true;
        }else{
            return false;
        }
    }
    function setPolen($param) {
        $sql="INSERT INTO polen (colmenarID,colmenaID,cantidad,fecha)"
                . " VALUES ('".$param['colmenarID']."','"
                .$param['colmenaID']."','"
                .$param['cantidad']."','"
                .$param['fecha']."')";
        $resultado=self::querySql($sql);
        if($resultado!=null){
            return true;
        }else{
            return false;
        }
    }
    function setPoblacion($param) {
        $sql="INSERT INTO obreras (colmenarID,colmenaID,cantidad,fecha)"
                . " VALUES ('".$param['colmenarID']."','"
                .$param['colmenaID']."','"
                .$param['cantidad']."','"
                .$param['fecha']."')";
        $resultado=self::querySql($sql);
        if($resultado!=null){
            return true;
        }else{
            return false;
        }
    }
    function setNectar($param) {
        $sql="INSERT INTO nectar (colmenarID,colmenaID,cantidad,fecha)"
                . " VALUES ('".$param['colmenarID']."','"
                .$param['colmenaID']."','"
                .$param['cantidad']."','"
                .$param['fecha']."')";
        $resultado=self::querySql($sql);
        if($resultado!=null){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * getUser
     */
    
    public function getUser($user){
        $sql="SELECT * FROM usuarios WHERE usuario='".$user."'";
        $resultado=self::querySql($sql);
        if($resultado!=null){
            $row=$resultado->fetch();
            while ($row){
                $usuario[]=$row;
                $row=$resultado->fetch();
            }
            return $usuario;
            }
        return false;
    }
    
    /**
     * Método authSql. Método para realizar una consulta tipo identificacion
     * Se trabaja con la siguiente estructura:
     *      Tabla: nombre de tabla = $args['tableName']
     *             columnas = 'user','passwd' 
     * Se presupone que el nombre de las columnas debe ser user y passwd, en caso
     * contrario la consulta será siempre NULL, en este caso se deberá introducir
     * los parametros self_user y self_passwd que harán referencia al nombre de 
     * las columnas de la tabla de la base de datos
     * @abstract authSql
     * @param array $args Contiene un array con las opciones de la consulta sql
     *      args (
     *          'user'=> ,
     *          'passwd'=> ,
     *          'tableName'=>,
     *          'self_user=>,
     *          'self_passwd'
     *      )
     * @return boolean Devuelve true si la consulta se ha realizado correctamente
     *          en caso contrario devuelve false
     * @see authSqlHandler
     */
    public function authSql($args) {
        
        if(isset($args['self_user'])&&isset($args['self_passwd'])){
            
            return self::authSqlHandler($args);
        }else{
            $args['self_user']="usuario";
            $args['self_passwd']="password";
            return self::authSqlHandler($args);
        }
    }
    /**
     * Método authSqlHandler
     * Es un método auxiliar de la clase, su método público es authSql.
     * Hace una consulta a la base de datos especificada y comprueba que el usuario
     * y contraseña introducidos tienen un par en la base de datos y además coinciden
     * en este caso devuelve TRUE, en caso contrario FALSE. La clase no permite en
     * ningún caso que se vean 
     * @param array $args Array que debe incluir user, passwd, self_passwd, self_user,
     *          y tableName
     * @return boolean Devuelve TRUE si la autentificación es correcta, en caso 
     *          contrario devuelve FALSE.
     */
    protected function authSqlHandler($args) {
        $sql="SELECT * FROM usuarios";
        $resultado=self::querySql($sql);
        if($resultado!=false){
        // Si se introduce como argumento user y passwd se comprueba si existe
        // coincidencia con el resultado de la consulta
            if(isset($args['self_user'])&&isset($args['self_passwd'])){
                $row=$resultado->fetch();
                while($row!=null){
                    if(($args['self_user']==$row['usuario'])&&($args['self_passwd']==$row['password'])){
                        return TRUE;
                    }
                    $row=$resultado->fetch();
                }
            }
        }
        return false;
    }
}

