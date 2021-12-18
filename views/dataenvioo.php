<?php

date_default_timezone_set("America/Argentina/Buenos_Aires" ) ;
$fechactual=date('d-m-Y H:i');
require_once '../clases/vigilooapp.php';
require_once '../clases/config.inc.php';
$datvigiloo=new vigilooapp();



    echo 'Ultimo turno: '.$datvigiloo->ultimoturnoregistrado();
    echo '</br>-------------------TURNOS-------------------</br>';
    
    $novedades= $datvigiloo->listarnovedadesturnos();
    foreach ($novedades as $row) :
        $datvigiloo->ptu_id=$row['ptu_id'];
        $datvigiloo->cli_id=$row['cli_id'];
        $datvigiloo->ptu_numero=$row['ptu_numero'];
        $datvigiloo->numerorefcli=$row['embarque'];
        $datvigiloo->ptu_nro_documento=$row['ptu_nro_documento'];
        $datvigiloo->ptu_chofer=$row['ptu_chofer'];
        $datvigiloo->ptu_patente_1=$row['ptu_patente_1'];
        $datvigiloo->ptu_patente_2=$row['ptu_patente_2'];
        $datvigiloo->ptu_fh_alta=$row['ptu_fh_alta'];
        if ($datvigiloo->checkturnoregistrado()==0){
            $datvigiloo->ptu_id=$row['ptu_id'];
            $datvigiloo->insertarturnoenbdsiasa();
            $datvigiloo->tiponovedad='GT';
            $datvigiloo->ptu_numero=$row['ptu_numero'];
            $datvigiloo->fechahoranovedad=$row['ptu_fh_alta'];
            $datvigiloo->insertarnovedadturnoenbdsiasa();
            echo $row['ptu_id'].' - '.$row['cli_id'].' - '.$row['ptu_numero'].' - '.$row['embarque'].' - '.$row['ptu_nro_documento'].' - '.$row['ptu_chofer'].' - '.$row['ptu_patente_1'].' - '.$row['ptu_patente_2'].' - '.$row['ptu_fh_alta'].'</br>';
        } else {
            echo 'No inserto '.$datvigiloo->checkturnoregistrado();
        }
    endforeach;
    echo '</br>//////////////////////////TURNOS////////////////</br>';
    echo '-------------------CREACION DE PAPELES-------------------</br>';
    
    
   $novedades= $datvigiloo->listarnovedadescreacionpapeles();
   foreach ($novedades as $row) :
        $datvigiloo->tiponovedad='CP';
        $datvigiloo->ptu_numero=$row['turno'];
        $datvigiloo->fechahoranovedad=$row['Creacionpapeles'];
        if ($datvigiloo->checknovedadregistrada()==0){
            $datvigiloo->insertarnovedadturnoenbdsiasa();
            echo $row['turno'].' - '.$row['Creacionpapeles'].'</br>';
        }
    endforeach;
   echo '</br>//////////////////////////CREACION DE PAPELES////////////////</br>';
    echo '</br>//////////////////////////TURNOS////////////////</br>';
    echo '-------------------ARRIBOS-------------------</br>';
    
    
   $novedades= $datvigiloo->listarnovedadesarribos();
   foreach ($novedades as $row) :
        $datvigiloo->tiponovedad='AR';
        $datvigiloo->ptu_numero=$row['turno'];
        $datvigiloo->fechahoranovedad=$row['Arribo'];
        if ($datvigiloo->checknovedadregistrada()==0){
            $datvigiloo->insertarnovedadturnoenbdsiasa();
            echo $row['turno'].' - '.$row['Arribo'].'</br>';
        }
    endforeach;
   echo '</br>//////////////////////////ARRIBOS////////////////</br>';
   echo '-------------------INGRESO A PLANTA-------------------</br>';
    
    
   $novedades= $datvigiloo->listarnovedadesingresocamion();
   foreach ($novedades as $row) :
        $datvigiloo->tiponovedad='IC';
        $datvigiloo->ptu_numero=$row['turno'];
        $datvigiloo->fechahoranovedad=$row['Ingresocamion'];
        if ($datvigiloo->checknovedadregistrada()==0){
            $datvigiloo->insertarnovedadturnoenbdsiasa();
            echo $row['turno'].' - '.$row['Ingresocamion'].'</br>';
        }
    endforeach;
   echo '</br>//////////////////////////INGRESO A PLANTA////////////////</br>';
    
   
   echo '-------------------CARGA CAMION-------------------</br>';
    
    
   $novedades= $datvigiloo->listarnovedadescargacamion();
   foreach ($novedades as $row) :
        $datvigiloo->tiponovedad='CC';
        $datvigiloo->ptu_numero=$row['turno'];
        $datvigiloo->fechahoranovedad=$row['Carga'];
        if ($datvigiloo->checknovedadregistrada()==0){
            $datvigiloo->insertarnovedadturnoenbdsiasa();
            echo $row['turno'].' - '.$row['Carga'].'</br>';
        }
    endforeach;
    
   echo '</br>//////////////////////////CARGA////////////////</br>';
   echo '-------------------SALIDA CAMION-------------------</br>';
    
    
   $novedades= $datvigiloo->listarnovedadessalidacamion();
   foreach ($novedades as $row) :
        $datvigiloo->tiponovedad='SC';
        $datvigiloo->ptu_numero=$row['turno'];
        $datvigiloo->fechahoranovedad=$row['Salida'];
        if ($datvigiloo->checknovedadregistrada()==0){
            $datvigiloo->insertarnovedadturnoenbdsiasa();
            echo $row['turno'].' - '.$row['Salida'].'</br>';
        }
    endforeach;
    
?>  
<script src="../assets/js/enviovigiloo.js"></script>   
<script type="text/javascript">
  //Función para actualizar cada 4 segundos(4000 milisegundos) o una hora segun el horario operativo  
  function actualizar(){location.reload(true);}
  //setInterval("actualizar()",4000);
    var hoy= new Date();
    var intervalo;
    intervalo=(1000*60)*60;
    console.log(hoy);
    
    if (hoy.getHours()>=6 ){
        console.log(hoy.getHours());
        console.log(hoy.getMinutes());
        if (hoy.getHours()<20 ){
            intervalo=4000;
        } 
    } 
    setInterval("actualizar()",intervalo);
    console.log(intervalo);
</script>