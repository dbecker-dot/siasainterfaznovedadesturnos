<?php

require_once 'BaseSIASA.php';

Class novedades {

    public $db;
    private $sql;
    private $conexsiasa;
    private $stmt;
    public $idnovedadturno;
    public $fechahoraultimanovedadregistrada;
    public $resultadows;
    public $estadoenvio;

    public function __construct() {
        $this->db=new BaseSIASA();
    }

    public function ultimonovedadregistrada(){
        try {
            $this->sql="SELECT * FROM vista_ultimanovedadturnoregistrada";
            $this->conexsiasa= $this->db->conectar();
            $this->stmt = sqlsrv_query($this->conexsiasa, $this->sql );
            if( $this->stmt === false) {
                $this->db->cierraconexion();
                $this->idnovedadturno=0;
                $this->fechahoraultimanovedadregistrada='';
            }
            $i=0;
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                IF ($row[0] == null){
                    $this->idnovedadturno=0;
                    $this->fechahoraultimanovedadregistrada='';
                } else {
                    $this->idnovedadturno=$row[0];
                    $this->fechahoraultimanovedadregistrada=$row[1]->Format('d-m-Y H:i'); 
                }
            }
            $this->db->cierraconexion();
        } catch (Exception $ex) {
            $this->db->cierraconexion();
            $this->idnovedadturno=0;
            $this->fechahoraultimanovedadregistrada='';
        }
       
    }

    public function CantNovedadesNoRegistradasGT(){
        $cant=0;
        try {
            $this->sql="SELECT count(Existe) as cant FROM vista_novedadesGT where existe=0";
            $this->conexsiasa= $this->db->conectar();
            $this->stmt = sqlsrv_query($this->conexsiasa, $this->sql );
            if( $this->stmt === false) {
                $this->db->cierraconexion();
                return $cant;
            }
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                if ($row[0]<>NULL){
                    $cant= $row[0];
                } else {
                    $cant=0;
                }
            }
            $this->db->cierraconexion();
            return $cant;
        } catch (Exception $ex) {
            $this->db->cierraconexion();
            return $cant-1;
        }
       
    }

    public function insertarnovedadGT(){
        try
        {
            $this->sql="INSERT INTO novedadturno(PTU_ID, COD_NOVEDAD,fechahoranovedad) SELECT PTU_ID,'GT',GT FROM vista_novedadesGT where Existe=0";
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
            echo"<script> alert('Error al registrar turno');  </script>";
            exit();
        }
        
    }

    public function CantNovedadesNoRegistradasCP(){
        $cant=0;
        try {
            $this->sql="SELECT count(Existe) as cant FROM vista_novedadesCP where existe=0";
            $this->conexsiasa= $this->db->conectar();
            $this->stmt = sqlsrv_query($this->conexsiasa, $this->sql );
            if( $this->stmt === false) {
                $this->db->cierraconexion();
                return $cant;
            }
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                if ($row[0]<>NULL){
                    $cant= $row[0];
                } else {
                    $cant=0;
                }
            }
            $this->db->cierraconexion();
            return $cant;
        } catch (Exception $ex) {
            $this->db->cierraconexion();
            return $cant-1;
        }
       
    }

    public function insertarnovedadCP(){
        try
        {
            $this->sql="INSERT INTO novedadturno(PTU_ID, COD_NOVEDAD,fechahoranovedad) SELECT PTU_ID,'CP',CP FROM vista_novedadesCP where Existe=0";
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
            echo"<script> alert('Error al registrar turno');  </script>";
            exit();
        }
        
    }

    public function CantNovedadesNoRegistradasAC(){
        $cant=0;
        try {
            $this->sql="SELECT count(Existe) as cant FROM vista_novedadesAC where existe=0";
            $this->conexsiasa= $this->db->conectar();
            $this->stmt = sqlsrv_query($this->conexsiasa, $this->sql );
            if( $this->stmt === false) {
                $this->db->cierraconexion();
                return $cant;
            }
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                if ($row[0]<>NULL){
                    $cant= $row[0];
                } else {
                    $cant=0;
                }
            }
            $this->db->cierraconexion();
            return $cant;
        } catch (Exception $ex) {
            $this->db->cierraconexion();
            return $cant-1;
        }
       
    }

    public function insertarnovedadAC(){
        try
        {
            $this->sql="INSERT INTO novedadturno(PTU_ID, COD_NOVEDAD,fechahoranovedad) SELECT PTU_ID,'AC',AC FROM vista_novedadesAC where Existe=0";
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
            echo"<script> alert('Error al registrar turno');  </script>";
            exit();
        }
        
    }

    public function CantNovedadesNoRegistradasIC(){
        $cant=0;
        try {
            $this->sql="SELECT count(Existe) as cant FROM vista_novedadesIC where existe=0";
            $this->conexsiasa= $this->db->conectar();
            $this->stmt = sqlsrv_query($this->conexsiasa, $this->sql );
            if( $this->stmt === false) {
                $this->db->cierraconexion();
                return $cant;
            }
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                if ($row[0]<>NULL){
                    $cant= $row[0];
                } else {
                    $cant=0;
                }
            }
            $this->db->cierraconexion();
            return $cant;
        } catch (Exception $ex) {
            $this->db->cierraconexion();
            return $cant-1;
        }
       
    }
    
    public function insertarnovedadIC(){
        try
        {
            $this->sql="INSERT INTO novedadturno(PTU_ID, COD_NOVEDAD,fechahoranovedad) SELECT PTU_ID,'IC',IC FROM vista_novedadesIC where Existe=0";
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
            echo"<script> alert('Error al registrar turno');  </script>";
            exit();
        }
        
    }

    public function CantNovedadesNoRegistradasCCI(){
        $cant=0;
        try {
            $this->sql="SELECT count(Existe) as cant FROM vista_novedadesCCI where existe=0";
            $this->conexsiasa= $this->db->conectar();
            $this->stmt = sqlsrv_query($this->conexsiasa, $this->sql );
            if( $this->stmt === false) {
                $this->db->cierraconexion();
                return $cant;
            }
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                if ($row[0]<>NULL){
                    $cant= $row[0];
                } else {
                    $cant=0;
                }
            }
            $this->db->cierraconexion();
            return $cant;
        } catch (Exception $ex) {
            $this->db->cierraconexion();
            return $cant-1;
        }
       
    }
    
    public function insertarnovedadCCI(){
        try
        {
            $this->sql="INSERT INTO novedadturno(PTU_ID, COD_NOVEDAD,fechahoranovedad) SELECT PTU_ID,'CCI',CCI FROM vista_novedadesCCI where Existe=0";
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
            echo"<script> alert('Error al registrar turno');  </script>";
            exit();
        }
        
    }

    public function CantNovedadesNoRegistradasCCF(){
        $cant=0;
        try {
            $this->sql="SELECT count(Existe) as cant FROM vista_novedadesCCF where existe=0";
            $this->conexsiasa= $this->db->conectar();
            $this->stmt = sqlsrv_query($this->conexsiasa, $this->sql );
            if( $this->stmt === false) {
                $this->db->cierraconexion();
                return $cant;
            }
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                if ($row[0]<>NULL){
                    $cant= $row[0];
                } else {
                    $cant=0;
                }
            }
            $this->db->cierraconexion();
            return $cant;
        } catch (Exception $ex) {
            $this->db->cierraconexion();
            return $cant-1;
        }
       
    }

    public function insertarnovedadCCF(){
        try
        {
            $this->sql="INSERT INTO novedadturno(PTU_ID, COD_NOVEDAD,fechahoranovedad) SELECT PTU_ID,'CCF',CCF FROM vista_novedadesCCF where Existe=0";
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
            echo"<script> alert('Error al registrar turno');  </script>";
            exit();
        }
        
    }

    public function CantNovedadesNoRegistradasADMI(){
        $cant=0;
        try {
            $this->sql="SELECT count(Existe) as cant FROM vista_novedadesADMI where existe=0";
            $this->conexsiasa= $this->db->conectar();
            $this->stmt = sqlsrv_query($this->conexsiasa, $this->sql );
            if( $this->stmt === false) {
                $this->db->cierraconexion();
                return $cant;
            }
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                if ($row[0]<>NULL){
                    $cant= $row[0];
                } else {
                    $cant=0;
                }
            }
            $this->db->cierraconexion();
            return $cant;
        } catch (Exception $ex) {
            $this->db->cierraconexion();
            return $cant-1;
        }
       
    }

    public function insertarnovedadADMI(){
        try
        {
            $this->sql="INSERT INTO novedadturno(PTU_ID, COD_NOVEDAD,fechahoranovedad) SELECT PTU_ID,'ADMI',ADMI FROM vista_novedadesADMI where Existe=0";
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
            echo"<script> alert('Error al registrar turno');  </script>";
            exit();
        }
        
    }

    public function CantNovedadesNoRegistradasADMF(){
        $cant=0;
        try {
            $this->sql="SELECT count(Existe) as cant FROM vista_novedadesADMF where existe=0";
            $this->conexsiasa= $this->db->conectar();
            $this->stmt = sqlsrv_query($this->conexsiasa, $this->sql );
            if( $this->stmt === false) {
                $this->db->cierraconexion();
                return $cant;
            }
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                if ($row[0]<>NULL){
                    $cant= $row[0];
                } else {
                    $cant=0;
                }
            }
            $this->db->cierraconexion();
            return $cant;
        } catch (Exception $ex) {
            $this->db->cierraconexion();
            return $cant-1;
        }
       
    }

    public function insertarnovedadADMF(){
        try
        {
            $this->sql="INSERT INTO novedadturno(PTU_ID, COD_NOVEDAD,fechahoranovedad) SELECT PTU_ID,'ADMF',ADMF FROM vista_novedadesADMF where Existe=0";
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
            echo"<script> alert('Error al registrar turno');  </script>";
            exit();
        }
        
    }

    public function CantNovedadesNoRegistradasSC(){
        $cant=0;
        try {
            $this->sql="SELECT count(Existe) as cant FROM vista_novedadesSC where existe=0";
            $this->conexsiasa= $this->db->conectar();
            $this->stmt = sqlsrv_query($this->conexsiasa, $this->sql );
            if( $this->stmt === false) {
                $this->db->cierraconexion();
                return $cant;
            }
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                if ($row[0]<>NULL){
                    $cant= $row[0];
                } else {
                    $cant=0;
                }
            }
            $this->db->cierraconexion();
            return $cant;
        } catch (Exception $ex) {
            $this->db->cierraconexion();
            return $cant-1;
        }
       
    }

    public function insertarnovedadSC(){
        try
        {
            $this->sql="INSERT INTO novedadturno(PTU_ID, COD_NOVEDAD,fechahoranovedad) SELECT PTU_ID,'SC',SC FROM vista_novedadesSC where Existe=0";
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
            echo"<script> alert('Error al registrar turno');  </script>";
            exit();
        }
        
    }

    //aplicativo

    public function cantnovedadesaplicativonoinformadas(){
        $cant=0;
        try {
            $this->sql="SELECT cant FROM vista_novedadesaplicativonoinformadas";
            $this->conexsiasa= $this->db->conectar();
            $this->stmt = sqlsrv_query($this->conexsiasa, $this->sql );
            if( $this->stmt === false) {
                $this->db->cierraconexion();
                return $cant;
            }
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                if ($row[0]<>NULL){
                    $cant= $row[0];
                } else {
                    $cant=0;
                }
            }
            $this->db->cierraconexion();
            return $cant;
        } catch (Exception $ex) {
            $this->db->cierraconexion();
            return $cant-1;
        }
       
    }

    public function listarnovedadesaplicativopendientesdeinformar(){
        try {
            $datos=[];
            $datosaux=[];
            $this->sql="SELECT * FROM vista_ctrolinfaplicativo where estado is null";
            $this->conexsiasa= $this->db->conectar();
            $this->stmt = sqlsrv_query($this->conexsiasa, $this->sql );
            if( $this->stmt === false) {
                $this->db->cierraconexion();
                $datos=[
                    'turno'=>0
                ];
                return $datos;
            }
            $i=0;
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                $datos[$i]=['turno'=>$row[0],
                    'idnovedadturno'=>$row[3]
                ];
                
            $i++;    
            }
            $this->db->cierraconexion();
            return $datos;
        } catch (Exception $ex) {
            $this->db->cierraconexion();
                $datos=[
                    'turno'=>0
                ];
                return $datos;
        }
       
    }

    public function modificarestadonovedadturnoenbdsiasa(){
        try
        {
            $this->sql="INSERT INTO ctrolinfaplicativo (idnovedadturno,resultadows,estado) VALUES($this->idnovedadturno,'$this->resultadows','$this->estadoenvio')";
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
            echo"<script> alert('Error al registrar novedad turno');  </script>";
            exit();
        }
        
    }
}