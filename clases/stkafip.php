<?php

require_once 'Base.php';

class stkafip {
    
    public $db;
    public $turno;
    public $token;
    public $id;
    public $sign;
    public $desde;
    public $hasta;
    public $est;
    public $idus;
    public $status;
    private $dbh;
    private $dsn;
    private $options;
    private $sql;
    private $conexsiasa;
    private $stmt;

    public function __construct() {
        $this->db=new Base;
    }
    
    public function buscartokenxid(){
        try {
            if (! $this->db) {
                die('ERR -> No hay conexión con la BD');
            }
            $sql='SELECT * FROM accesowsafip';
            echo $sql;
            $this->db->query($sql);
            echo $sql;
            $this->db->bind(':id', $this->id );
            $resultado=$this->db->registro();
            //return $resultado;
            while ($row = $resultado){
                echo "ID: {$row["id"]} <br>";
                echo "Est: {$row["est"]} <br><br>";
            }
            exit();
        } catch (Exception $ex) {
            $this->error=$ex->getMessage();
            echo $this->error;
        }
        
        
        try {
            // FETCH_ASSOC
            $this->stmt = $this->dbh->prepare('SELECT id,est FROM accesowsafip where id=:id');
            $this->stmt->bindParam(':id',$this->id, PDO::PARAM_STR);
            // Especificamos el fetch mode antes de llamar a fetch()
            $this->stmt->setFetchMode(PDO::FETCH_ASSOC);
            // Ejecutamos
            $this->stmt->execute();
            // Mostramos los resultados
            while ($row = $stmt->fetch()){
                echo "ID: {$row["id"]} <br>";
                echo "Est: {$row["est"]} <br><br>";
            }
            print_r(PDO::getAvailableDrivers());
            $this->status='E';
            $this->sql="SELECT id,est FROM accesowsafip where id='$this->id'";
            if ($this->db->conectar()<>'Error'){
                $this->conexsiasa= $this->db->conectar();
                $this->stmt = sqlsrv_query($this->conexsiasa, $this->sql );
                if( $this->stmt == false) {
                    $this->db->cierraconexion();
                    $this->status='A';   
                } else {
                    while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                        if ($row[0]<>NULL){
                            $this->id=$row[0];
                            $this->est=$row[1];
                            $this->status='NA';
                            $this->db->cierraconexion();
                           
                        } else {
                            $this->status='A';
                            echo $this->id;
                        }
                    }
                    $this->db->cierraconexion();
                }
                $this->status='A';
            } else {
                $this->status='E';
                exit();
            }
            
            
        } catch (Exception $ex) {
            echo $ex;
            $this->db->cierraconexion();
            $this->status='E';
        }
       
    }
    
    public function insertarnvotoken(){
        try
        {
            $this->idus=2;
            $this->sql="INSERT INTO accesowsafip(idwsafip,id,token,sign,cuit,desde,hasta,est,idus) VALUES(1,'$this->id','$this->token','$this->sign','33693450239','$this->desde','$this->hasta','$this->est',$this->idus)";
            $this->conexsiasa= $this->db->conectar();
            $this->stmt = sqlsrv_query($this->conexsiasa, $this->sql );
            if( $this->stmt === false) {
                $this->db->cierraconexion();
                exit();
            } else {
                $this->db->cierraconexion();
            }
           
        } catch (Exception $ex) {
            $this->db->cierraconexion();
            echo"<script> alert('Error al registrar credenciales vigiloo comuniquese con el sector de sistemas');  </script>";
            exit();
        }
        
    }
    
}
