<?php
//conexion a la base de datos utilizando PDO
require_once 'config.inc.php';
class Base {
    
    private $host=DB_HOST;
    private $usuario=DB_USUARIO;
    private $password = DB_PASSWORD;
    private $base= DB_BD;
    private $dbh;
    private $stmt;
    private $error;
    
    public function __construct() {
        $dsn='sqlsvr:Server='.$this->host.';Database='.$this->base;
        $opciones= array(
            PDO::ATTR_PERSISTENT=>true,
            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION
        );
        
        try {
            $this->dbh=new PDO($dsn, $this->usuario, $this->password,$opciones);
            $this->dbh->exec('set names utf8');
        } catch (PDOException $ex) {
            $this->error=$ex->getMessage();
            echo $this->error;
        }
    }
    
    //funcion para preparar la consulta a la bd
    public function query($sql){
        $this->stmt= $this->dbh->prepare($sql);
    }
    
    //vinculacion de la consulta con bind
    public function bind($parametro,$valor,$tipo=null){
        if (is_null($tipo)){
            switch (true) {
                case is_int($valor):
                    $tipo= PDO::PARAM_INT;
                    break;
                case is_bool($valor):
                    $tipo= PDO::PARAM_BOOL;
                    break;
                case is_null($valor):
                    $tipo= PDO::PARAM_NULL;
                    break;
                default:
                    $tipo= PDO::PARAM_STR;
                    break;
            }
        }
        $this->stmt->bindValue($parametro,$valor,$tipo);
    }
    
    // ejecucion de la consulta para insertar modificar o eliminar registros
    public function insertupdatedeletebd($sql){
        $this->stmt->execute($sql);
    }
    
    // ejecucion de la consulta
    public function execute(){
        return $this->stmt->execute();
    }
    
    //obtener los registros de la consulta
    public function registros(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    //obtener un solo registro de la consulta
    public function registro(){
        $this->execute();
        $result=$this->stmt->fetchAll();
        return $result;
    }
    
    //obtener la cantidad de registros con el metodo rowcount
    public function rowCount(){
        $this->execute();
        return $this->stmt->rowCount();
    }
}



