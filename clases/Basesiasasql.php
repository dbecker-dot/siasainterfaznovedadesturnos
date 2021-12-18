<?php

include_once 'config.inc.php';

class Basesiasasql {
    private $host=DB_HOST;
    private $usuario=DB_USUARIO;
    private $password = DB_PASSWORD;
    private $base= DB_BD;
    private $dbh;
    private $stmt;
    private $error;
    
    private $conn;
  
    public function conectar() {
        $serverName = $this->host; //serverName\instanceName
        $connectionInfo = array( "Database"=> $this->base, "UID"=> $this->usuario, "PWD"=> $this->password);
        $this->conn = sqlsrv_connect( $serverName, $connectionInfo);
        if($this->conn === false ) 
        {
            die( print_r( sqlsrv_errors(), true));
            return 'Error';
        } else {
            return $this->conn;			
        }
        
    }
    
    public function cierraconexion (){
        sqlsrv_close($this->conn);
    }
}


?>