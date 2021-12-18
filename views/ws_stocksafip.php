<?php
date_default_timezone_set("America/Argentina/Buenos_Aires" ) ;
$fechactual=date('d-m-Y H:i');

require_once '../clases/Basesiasasql.php';
require_once '../clases/config.inc.php';
include_once('../clases/WSAA.class.php');
include_once('../clases/stkafip.php');
//verifico conexion con base de datos
$conexbd=new Basesiasasql();
// funcion para conocer los datos del ticket de acceso al web service de afip
function DatosTA(){
        $stk=new stkafip();
        //verifico si el token es valido
        $fechactual=date('d-m-Y H:i');
        $xml = simplexml_load_file(TA);
        if ($xml->xpath("header")){
            $valor = $xml->xpath("header");
            foreach ($valor as $el) 
            {
                $id =  $el->uniqueId;
                $Fecha =  $el->generationTime;
                //echo date("d-m-Y H:i", strtotime( $Fecha)) . "<br>"; 
                $fechadesde=date("d-m-Y H:i", strtotime( $Fecha));
                //echo $el->generationTime;
                $Fecha =  $el->expirationTime;
                //echo date("d-m-Y H:i", strtotime( $Fecha)) . "<br>";
                $fechahasta=date("d-m-Y H:i", strtotime( $Fecha));
            }
        }
        if ($xml->xpath("credentials")){
            $valor = $xml->xpath("credentials");
            foreach ($valor as $el) 
            {
                $token= $el->token;
                $sign= $el->sign;
            }
        }
        
        echo '
        <ul class="list-group">
            <li class="list-group-item">DATOS TA (Ticket Acceso)</li>
            <li class="list-group-item">ID: '.$id.'</li>
            <li class="list-group-item">Vigencia</li>
            
            <li class="list-group-item">Desde: '.$fechadesde.' Hasta: '.$fechahasta.'</li>
            <li class="list-group-item">Token: '.$token.'</li>
            <li class="list-group-item">Sign: '.$sign.'</li>
        </ul>';
        //actualizo el token
                $stk->id=$id;
                echo $stk->id;
                $stk->buscartokenxid();
                echo 'Status: '.$stk->status;
                
                if ($stk->status=='E'){
                    echo 'Error en Base de datos';
                }
                if ($stk->status=='NA'){
                    echo 'No Actualizo';
                }
        if ($fechactual>$fechahasta){
            if ($stk->status=='A'){
                    echo 'Actualizo';
                    $stk->id=$id;
                    $stk->token=$token;
                    $stk->sign=$sign;
                    $stk->desde=$fechadesde;
                    $stk->hasta=$fechahasta;
                    $stk->est='VE';
                    //$stk->insertarnvotoken();
                }
            return FALSE;    
        } else {
            if ($stk->status=='A'){
                    echo 'Actualizo';
                    $stk->id=$id;
                    $stk->token=$token;
                    $stk->sign=$sign;
                    $stk->desde=$fechadesde;
                    $stk->hasta=$fechahasta;
                    $stk->est='VI';
                    //$stk->insertarnvotoken();
                }
            return TRUE;    
        }
}

ob_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>WS - AFIP</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="shortcut icon" href="<?php echo RUTA_IMG ; ?>/favicom.ico" />
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo RUTA_CSS; ?>/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo RUTA_CSS; ?>/font-awesome.min.css">
  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body>
    <a href="../index.php">VOLVER</a>
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-12">
            <h3>Fecha: <?php echo $fechactual; ?></h3>
            <h1>WS STOCK DEP FISCALES</h1>
            <?php 
            if ($conexbd->conectar()=='Error') {
                echo '<div class="alert alert-danger">
                <strong>Error!</strong> CONEXION BASE DE DATOS
                </div>';
                exit();
            } else {
                echo '<div class="alert alert-success">
                <strong>OK!</strong> CONEXION BASE DE DATOS
                </div>';
            //Verifico y actualizo token de acceso
            if (DatosTA()==FALSE) {
                $WSAA = new WSAA('wgesstockdepositosfiscales');
                echo '<div class="alert alert-danger">
                <strong>Error!</strong> TOKEN VENCIDO O INCORRECTO
                </div>';
                //$WSAA->getAuth();
                exit();
                
            } else {
                echo '<div class="alert alert-success">
                <strong>OK!</strong> TOKEN 
                </div>';
                exit();
            }
            }
            
            ?>
            
        </div>
      </div><!-- /.container-fluid -->
    </section>
     <!-- Main content -->
    
    
<footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0
    </div>
    <strong>Copyright &copy; 2021 <a href="http://www.siasalogistica.com.ar/">SIASA</a>.</strong> All rights
    reserved.
  </footer>

  
</div>
<!-- ./wrapper -->

<!-- Bootstrap 3.3.7 -->
<script src="<?php echo RUTA_JS;?>/bootstrap.min.js"></script>
</body>
</html>
<?php
ob_end_flush();
exit();
?>
<?php

echo '
        <ul class="list-group">
            <li class="list-group-item">Fecha: '.$fechactual .'</li>
        </ul>';     

//verifico conexion con base de datos
$conexbd=new Basesiasasql();
if ($conexbd->conectar()=='Error') {
    echo '<div class="alert alert-danger">
                <strong>Error!</strong> Conexion con la base de datos
              </div>';
    exit();
} else {
    //Verifico y actualizo token de acceso
    if (DatosTA()==FALSE) {
        echo '<div class="alert alert-danger">
                <strong>Error!</strong> EL TOKEN ESTA VENCIDO
              </div>';
        exit();
    } else {
        echo '<div class="alert alert-success">
                <strong>OK!</strong> EL TOKEN ESTA VIGENTE
              </div>';
        exit();
    }
}
//Verifico y actualizo token de acceso



/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



