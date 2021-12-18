<?php

require_once 'Basesiasasql.php';
require_once 'Baserds.php';

class aplicativo {
    
    public $db;
    public $dbrds;
    public $turno;
    public $token;
    public $signature;
    public $cuitdest;
    public $cuitprod;
    public $cuitremcomer;
    public $cuitransp;
    public $cuitchof;
    public $chasis;
    private $sql;
    private $conexsiasa;
    private $conexrds;
    private $stmt;
    
    public $ptu_id;
    public $cli_id;
    public $ptu_numero;
    public $numerorefcli;
    public $ptu_nro_documento;
    public $ptu_chofer;
    public $ptu_patente_1;
    public $ptu_patente_2;
    public $ptu_fh_alta;
    public $idnovedadturno;
    public $tiponovedad;
    public $fechahoranovedad;
    public $feultimanovedad;
    public $resultadows;
    public $estadoenvio;
    
    public function __construct() {
        $this->db=new Basesiasasql();
        $this->dbrds=new Baserds();
    }
    
    public function buscarcredencialesvalidas(){
        try {
            $this->token=0;
            $this->signature=0;
            $this->sql="SELECT token,signature FROM credencialesvigiloo where hab='SI'";
            $this->conexsiasa= $this->db->conectar();
            $this->stmt = sqlsrv_query($this->conexsiasa, $this->sql );
            if( $this->stmt === false) {
                $this->db->cierraconexion();
                $this->token='';
                $this->signature='';
                
            }
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                if ($row[0]<>NULL){
                    $this->token=$row[0];
                    $this->signature=$row[1];
                } else {
                    $this->token=0;
                    $this->signature=0;
                }
            }
            $this->db->cierraconexion();
            
        } catch (Exception $ex) {
            $this->db->cierraconexion();
            $this->token=-1;
            $this->signature=-1;
        }
       
    }
    
    public function insertarcredencialesvigiloo(){
        try
        {
            $this->sql="INSERT INTO credencialesvigiloo(token,signature) VALUES('$this->token','$this->signature')";
            $this->conexsiasa= $this->db->conectar();
            $this->stmt = sqlsrv_query($this->conexsiasa, $this->sql );
            if( $this->stmt === false) {
                $this->db->cierraconexion();
                exit();
            }
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
    
    public function cantnovedadesnoinformadas(){
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
    
    public function listarnovedadespendientesdeinformar(){
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
    
    public function prepararnovedadainformar(){
        try {
            $datos=[];
            $datosaux=[];
            $this->sql="SELECT * FROM vista_ctrolinfvigiloo where estado is null";
            $this->conexsiasa= $this->db->conectar();
            $this->stmt = sqlsrv_query($this->conexsiasa, $this->sql );
            if( $this->stmt === false) {
                $this->db->cierraconexion();
                $datos=[
                    'nroembarque'=>0
                ];
                return $datos;
            }
            $i=0;
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                $datos[$i]=['turno'=>$row[0],
                    'nroembarque'=>$row[1],
                    'tipo'=>$row[2],
                    'fechahoranovedad'=>$row[3],
                    'idnovedadturno'=>$row[5]
                ];
                
            $i++;    
            }
            $this->db->cierraconexion();
            return $datos;
        } catch (Exception $ex) {
            $this->db->cierraconexion();
                $datos=[
                    'nroembarque'=>0
                ];
                return $datos;
        }
       
    }
    
    //ultimo turno registrado
    
    public function ultimoturnoregistrado(){
        try {
            $datos=[];
            $datosaux=[];
            $this->ptu_id=232646;
            $this->sql="SELECT MAX(PTU_ID) as PTU_ID FROM datoturno";
            $this->conexsiasa= $this->db->conectar();
            $this->stmt = sqlsrv_query($this->conexsiasa, $this->sql );
            if( $this->stmt === false) {
                $this->db->cierraconexion();
                return $this->ptu_id;
            }
            $i=0;
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                IF ($row[0] == null){
                    $this->ptu_id=232646;
                } else {
                    $this->ptu_id=$row[0]; 
                }
            }
            $this->db->cierraconexion();
            return $this->ptu_id;
        } catch (Exception $ex) {
            $this->db->cierraconexion();
            return $this->ptu_id;
        }
       
    }
    
    public function checkturnoregistrado(){
        try {
            $datos=[];
            $datosaux=[];
            $this->sql="SELECT PTU_ID  FROM datoturno where PTU_ID=$this->ptu_id ";
            $this->ptu_id=0;
            $this->conexsiasa= $this->db->conectar();
            $this->stmt = sqlsrv_query($this->conexsiasa, $this->sql );
            if( $this->stmt === false) {
                $this->db->cierraconexion();
                return 0;
            }
            $i=0;
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                IF ($row[0] == null){
                    $this->ptu_id=0;
                } else {
                    $this->ptu_id=$row[0];
                }
            }
            $this->db->cierraconexion();
            return $this->ptu_id;
        } catch (Exception $ex) {
            $this->db->cierraconexion();
            return 0;
        }
       
    }
    
    //procesamiento de datos desde RDS
    
    public function listarnovedadesturnos(){
        try {
            $datos=[];
            $datosaux=[];
            $id= $this->ultimoturnoregistrado();
            echo 'id '.$id;
            $this->sql="SELECT T1.PTU_ID,T1.CLI_ID,T1.PTU_NUMERO,T2.CDA_VALOR,T1.PTU_NRO_DOCUMENTO,T1.PTU_CHOFER,T1.PTU_PATENTE_1,T1.PTU_PATENTE_2,T1.PTU_FH_ALTA FROM PLANIFICACIONES_TURNOS T1 LEFT OUTER JOIN CAMPOS_ADICIONALES_DATOS T2 ON T1.PTU_ID=T2.CDA_ID_RELACION AND T2.CAA_ID=27 WHERE  T1.PTU_ID>$id AND T1.CLI_ID=12 order by T1.PTU_ID";
            $this->conexrds= $this->dbrds->conectar();
            $this->stmt = sqlsrv_query($this->conexrds, $this->sql );
            if( $this->stmt === false) {
                $this->dbrds->cierraconexion();
                $datos=[
                    'ptu_id'=>0
                ];
                return $datos;
            }
            $i=0;
            
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                $datos[$i]=['ptu_id'=>$row[0],
                    'cli_id'=>$row[1],
                    'ptu_numero'=>$row[2],
                    'embarque'=>$row[3],
                    'ptu_nro_documento'=>$row[4],
                    'ptu_chofer'=>$row[5],
                    'ptu_patente_1'=>$row[6],
                    'ptu_patente_2'=>$row[7],
                    'ptu_fh_alta'=>$row[8]->Format('Y-m-d H:i')
                ];
                
            $i++;    
            }
            $this->dbrds->cierraconexion();
            return $datos;
        } catch (Exception $ex) {
            $this->dbrds->cierraconexion();
                $datos=[
                    'ptu_id'=>0
                ];
                return $datos;
        }
       
    }
    
    public function insertarturnoenbdsiasa(){
        try
        {
            $this->sql="INSERT INTO datoturno(PTU_ID,CLI_ID,PTU_NUMERO,NUMEROREFCLI,PTU_NRO_DOCUMENTO,PTU_CHOFER,PTU_PATENTE_1,PTU_PATENTE_2,PTU_FH_ALTA) VALUES($this->ptu_id,$this->cli_id,$this->ptu_numero,'$this->numerorefcli','$this->ptu_nro_documento','$this->ptu_chofer','$this->ptu_patente_1','$this->ptu_patente_2','$this->ptu_fh_alta')";
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
    
    public function ultimoturnoarribo(){
        try {
            $datos=[];
            $datosaux=[];
            $this->feultimanovedad='2021/06/10 07:02';
            $this->sql="SELECT MAX(fechahoranovedad) as fechahoranovedad FROM novedadturno where tipo='AR'";
            $this->conexsiasa= $this->db->conectar();
            $this->stmt = sqlsrv_query($this->conexsiasa, $this->sql );
            if( $this->stmt === false) {
                $this->db->cierraconexion();
                return $this->feultimanovedad;
            }
            $i=0;
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                IF ($row[0] == null){
                    $this->feultimanovedad='2021/06/10 07:02';
                } else {
                    $this->feultimanovedad=$row[0]->Format('Y-m-d H:i'); 
                }
            }
            $this->db->cierraconexion();
            return $this->feultimanovedad;
        } catch (Exception $ex) {
            $this->db->cierraconexion();
            return $this->feultimanovedad;
        }
       
    }
    
    public function listarnovedadesarribos(){
        try {
            $datos=[];
            $datosaux=[];
            $this->ultimoturnoarribo();
            $this->sql="SELECT NUMERO,[Arribo Camion Fh Inicio] AS ARRIBO FROM DTS_PLANIFICACIONES_TURNOS  WHERE   CLIENTE_CODIGO='BAYER' and [Arribo Camion Fh Inicio] > '$this->feultimanovedad' order by [Arribo Camion Fh Inicio]";
            $this->conexrds= $this->dbrds->conectar();
            $this->stmt = sqlsrv_query($this->conexrds, $this->sql );
            if( $this->stmt === false) {
                $this->dbrds->cierraconexion();
                $datos=[
                    'turno'=>0
                ];
                return $datos;
            }
            $i=0;
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                $datos[$i]=['turno'=>$row[0],
                    'Arribo'=>$row[1]->Format('Y-m-d H:i')
                ];
                
            $i++;    
            }
            $this->dbrds->cierraconexion();
            return $datos;
        } catch (Exception $ex) {
            $this->dbrds->cierraconexion();
                $datos=[
                    'turno'=>0
                ];
                return $datos;
        }
       
    }
    
    public function ultimoturnocargacamion(){
        try {
            $datos=[];
            $datosaux=[];
            $this->feultimanovedad='2021/06/10 07:02';
            $this->sql="SELECT MAX(fechahoranovedad) as fechahoranovedad FROM novedadturno where tipo='CC'";
            $this->conexsiasa= $this->db->conectar();
            $this->stmt = sqlsrv_query($this->conexsiasa, $this->sql );
            if( $this->stmt === false) {
                $this->db->cierraconexion();
                return $this->feultimanovedad;
            }
            $i=0;
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                IF ($row[0] == null){
                    $this->feultimanovedad='2021/06/10 07:02';
                } else {
                    $this->feultimanovedad=$row[0]->Format('Y-m-d H:i'); 
                }
            }
            $this->db->cierraconexion();
            return $this->feultimanovedad;
        } catch (Exception $ex) {
            $this->db->cierraconexion();
            return $this->feultimanovedad;
        }
       
    }
    
    public function listarnovedadescargacamion(){
        try {
            $datos=[];
            $datosaux=[];
            $this->ultimoturnocargacamion();
            $this->sql="SELECT NUMERO,[Operacion Carga y Descarga Fh Inicio] AS CARGA FROM DTS_PLANIFICACIONES_TURNOS  WHERE   CLIENTE_CODIGO='BAYER' and [Operacion Carga y Descarga Fh Inicio] > '$this->feultimanovedad' order by [Operacion Carga y Descarga Fh Inicio]";
            $this->conexrds= $this->dbrds->conectar();
            $this->stmt = sqlsrv_query($this->conexrds, $this->sql );
            if( $this->stmt === false) {
                $this->dbrds->cierraconexion();
                $datos=[
                    'turno'=>0
                ];
                return $datos;
            }
            $i=0;
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                $datos[$i]=['turno'=>$row[0],
                    'Carga'=>$row[1]->Format('Y-m-d H:i')
                ];
                
            $i++;    
            }
            $this->dbrds->cierraconexion();
            return $datos;
        } catch (Exception $ex) {
            $this->dbrds->cierraconexion();
                $datos=[
                    'turno'=>0
                ];
                return $datos;
        }
       
    }
    
public function ultimoturnoccfin(){
        try {
            $datos=[];
            $datosaux=[];
            $this->feultimanovedad='2021/07/12 17:30';
            $this->sql="SELECT MAX(fechahoranovedad) as fechahoranovedad FROM novedadturno where tipo='CCF'";
            $this->conexsiasa= $this->db->conectar();
            $this->stmt = sqlsrv_query($this->conexsiasa, $this->sql );
            if( $this->stmt === false) {
                $this->db->cierraconexion();
                return $this->feultimanovedad;
            }
            $i=0;
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                IF ($row[0] == null){
                    $this->feultimanovedad='2021/07/12 17:30';
                } else {
                    $this->feultimanovedad=$row[0]->Format('Y-m-d H:i'); 
                }
            }
            $this->db->cierraconexion();
            return $this->feultimanovedad;
        } catch (Exception $ex) {
            $this->db->cierraconexion();
            return $this->feultimanovedad;
        }
       
    }
    
    public function listarnovedadesccfin(){
        try {
            $datos=[];
            $datosaux=[];
            $this->ultimoturnoccfin();
            $this->sql="SELECT NUMERO,[Operacion Carga y Descarga Fh Fin] AS Cargacamfin FROM DTS_PLANIFICACIONES_TURNOS  WHERE    [Operacion Carga y Descarga Fh Fin] > '$this->feultimanovedad' order by [Operacion Carga y Descarga Fh Fin]";
            $this->conexrds= $this->dbrds->conectar();
            $this->stmt = sqlsrv_query($this->conexrds, $this->sql );
            if( $this->stmt === false) {
                $this->dbrds->cierraconexion();
                $datos=[
                    'turno'=>0
                ];
                return $datos;
            }
            $i=0;
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                $datos[$i]=['turno'=>$row[0],
                    'Cargacamfin'=>$row[1]->Format('Y-m-d H:i')
                ];
                
            $i++;    
            }
            $this->dbrds->cierraconexion();
            return $datos;
        } catch (Exception $ex) {
            $this->dbrds->cierraconexion();
                $datos=[
                    'turno'=>0
                ];
                return $datos;
        }
       
    }

    public function ultimoturnoadmini(){
        try {
            $datos=[];
            $datosaux=[];
            $this->feultimanovedad='2021/07/12 17:30';
            $this->sql="SELECT MAX(fechahoranovedad) as fechahoranovedad FROM novedadturno where tipo='ADMI'";
            $this->conexsiasa= $this->db->conectar();
            $this->stmt = sqlsrv_query($this->conexsiasa, $this->sql );
            if( $this->stmt === false) {
                $this->db->cierraconexion();
                return $this->feultimanovedad;
            }
            $i=0;
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                IF ($row[0] == null){
                    $this->feultimanovedad='2021/07/12 17:30';
                } else {
                    $this->feultimanovedad=$row[0]->Format('Y-m-d H:i'); 
                }
            }
            $this->db->cierraconexion();
            return $this->feultimanovedad;
        } catch (Exception $ex) {
            $this->db->cierraconexion();
            return $this->feultimanovedad;
        }
       
    }
    
    public function listarnovedadesadminicio(){
        try {
            $datos=[];
            $datosaux=[];
            $this->ultimoturnoadmini();
            $this->sql="SELECT NUMERO,[Administracion Fh Inicio] AS ADMINI FROM DTS_PLANIFICACIONES_TURNOS  WHERE    [Administracion Fh Inicio] > '$this->feultimanovedad' order by [Administracion Fh Inicio]";
            $this->conexrds= $this->dbrds->conectar();
            $this->stmt = sqlsrv_query($this->conexrds, $this->sql );
            if( $this->stmt === false) {
                $this->dbrds->cierraconexion();
                $datos=[
                    'turno'=>0
                ];
                return $datos;
            }
            $i=0;
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                $datos[$i]=['turno'=>$row[0],
                    'Admini'=>$row[1]->Format('Y-m-d H:i')
                ];
                
            $i++;    
            }
            $this->dbrds->cierraconexion();
            return $datos;
        } catch (Exception $ex) {
            $this->dbrds->cierraconexion();
                $datos=[
                    'turno'=>0
                ];
                return $datos;
        }
       
    }
    
    public function ultimoturnoadmfin(){
        try {
            $datos=[];
            $datosaux=[];
            $this->feultimanovedad='2021/07/12 17:30';
            $this->sql="SELECT MAX(fechahoranovedad) as fechahoranovedad FROM novedadturno where tipo='ADMF'";
            $this->conexsiasa= $this->db->conectar();
            $this->stmt = sqlsrv_query($this->conexsiasa, $this->sql );
            if( $this->stmt === false) {
                $this->db->cierraconexion();
                return $this->feultimanovedad;
            }
            $i=0;
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                IF ($row[0] == null){
                    $this->feultimanovedad='2021/07/12 17:30';
                } else {
                    $this->feultimanovedad=$row[0]->Format('Y-m-d H:i'); 
                }
            }
            $this->db->cierraconexion();
            return $this->feultimanovedad;
        } catch (Exception $ex) {
            $this->db->cierraconexion();
            return $this->feultimanovedad;
        }
       
    }
    
    public function listarnovedadesadmfin(){
        try {
            $datos=[];
            $datosaux=[];
            $this->ultimoturnoadmfin();
            $this->sql="SELECT NUMERO,[Administracion Fh Fin] AS ADMFIN FROM DTS_PLANIFICACIONES_TURNOS  WHERE    [Administracion Fh Fin] > '$this->feultimanovedad' order by [Administracion Fh Fin]";
            $this->conexrds= $this->dbrds->conectar();
            $this->stmt = sqlsrv_query($this->conexrds, $this->sql );
            if( $this->stmt === false) {
                $this->dbrds->cierraconexion();
                $datos=[
                    'turno'=>0
                ];
                return $datos;
            }
            $i=0;
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                $datos[$i]=['turno'=>$row[0],
                    'Admfin'=>$row[1]->Format('Y-m-d H:i')
                ];
                
            $i++;    
            }
            $this->dbrds->cierraconexion();
            return $datos;
        } catch (Exception $ex) {
            $this->dbrds->cierraconexion();
                $datos=[
                    'turno'=>0
                ];
                return $datos;
        }
       
    }


    public function ultimoturnosalidacamion(){
        try {
            $datos=[];
            $datosaux=[];
            $this->feultimanovedad='2021/06/10 07:02';
            $this->sql="SELECT MAX(fechahoranovedad) as fechahoranovedad FROM novedadturno where tipo='SC'";
            $this->conexsiasa= $this->db->conectar();
            $this->stmt = sqlsrv_query($this->conexsiasa, $this->sql );
            if( $this->stmt === false) {
                $this->db->cierraconexion();
                return $this->feultimanovedad;
            }
            $i=0;
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                IF ($row[0] == null){
                    $this->feultimanovedad='2021/06/10 07:02';
                } else {
                    $this->feultimanovedad=$row[0]->Format('Y-m-d H:i'); 
                }
            }
            $this->db->cierraconexion();
            return $this->feultimanovedad;
        } catch (Exception $ex) {
            $this->db->cierraconexion();
            return $this->feultimanovedad;
        }
       
    }
    
    public function listarnovedadessalidacamion(){
        try {
            $datos=[];
            $datosaux=[];
            $this->ultimoturnosalidacamion();
            $this->sql="SELECT NUMERO,[Salida de Planta Fh Inicio] AS SALIDA FROM DTS_PLANIFICACIONES_TURNOS  WHERE   CLIENTE_CODIGO='BAYER' and [Salida de Planta Fh Inicio] > '$this->feultimanovedad' order by [Salida de Planta Fh Inicio] ";
            $this->conexrds= $this->dbrds->conectar();
            $this->stmt = sqlsrv_query($this->conexrds, $this->sql );
            if( $this->stmt === false) {
                $this->dbrds->cierraconexion();
                $datos=[
                    'turno'=>0
                ];
                return $datos;
            }
            $i=0;
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                $datos[$i]=['turno'=>$row[0],
                    'Salida'=>$row[1]->Format('Y-m-d H:i')
                ];
                
            $i++;    
            }
            $this->dbrds->cierraconexion();
            return $datos;
        } catch (Exception $ex) {
            $this->dbrds->cierraconexion();
                $datos=[
                    'turno'=>0
                ];
                return $datos;
        }
       
    }
    
    public function checknovedadregistrada(){
        try {
            $datos=[];
            $datosaux=[];
            $this->sql="SELECT idnovedadturno  FROM novedadturno where PTU_NUMERO=$this->ptu_numero and tipo='$this->tiponovedad' ";
            $this->idnovedadturno=0;
            $this->conexsiasa= $this->db->conectar();
            $this->stmt = sqlsrv_query($this->conexsiasa, $this->sql );
            if( $this->stmt === false) {
                $this->db->cierraconexion();
                return 0;
            }
            $i=0;
            while( $row = sqlsrv_fetch_array( $this->stmt, SQLSRV_FETCH_NUMERIC) ){
                IF ($row[0] == null){
                    $this->idnovedadturno=0;
                } else {
                    $this->idnovedadturno=$row[0];
                }
            }
            $this->db->cierraconexion();
            return $this->idnovedadturno;
        } catch (Exception $ex) {
            $this->db->cierraconexion();
            return 0;
        }
       
    }
    
    public function insertarnovedadturnoenbdsiasa(){
        try
        {
            $this->sql="INSERT INTO novedadturno(tipo,PTU_NUMERO,fechahoranovedad) VALUES('$this->tiponovedad',$this->ptu_numero,'$this->fechahoranovedad')";
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

