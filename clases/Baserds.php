<?php

include_once 'config.inc.php';

class Baserds {
    private $host=DB_HOSTRDS;
    private $usuario=DB_USUARIORDS;
    private $password = DB_PASSWORDRDS;
    private $base= DB_BDRDS;
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