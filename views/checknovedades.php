<?php

date_default_timezone_set("America/Argentina/Buenos_Aires" );
$fechactual=date('d-m-Y H:i');
require_once '../clases/novedades.php';
require_once '../clases/config.inc.php';

$novedades = new novedades();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SIASAPP</title>
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
<body class="hold-transition layout-top-nav">
    <div class="content-wrapper">
        <h3><?php echo 'Fecha Actual: '.$fechactual; ?></h3>
        <section class="content-header">
            <div class="container-fluid">
                
                <div>
                <img src="<?php echo RUTA_IMG ; ?>/logosiasa.jpg" class="img-circle" alt="Cinque Terre" width="304" height="236">
                </div>
                <?php $novedades->ultimonovedadregistrada(); ?>
                <table>
                <thead>
                    <tr>
                        <td>&nbsp;</td>
                        <td>ACCION</td>
                        <td>CANT</td>
                    </tr>
                </thead>
                <tbody>
                    <?php if($novedades->CantNovedadesNoRegistradasGT()==0){
                    ?>
                        <tr>
                            <td class="active"> ALTA DE TURNOS </td>
                            <td class="active">  0 </td>
                        </tr>
                    <?php
                    } else {
                    ?>
                      <tr>
                            <td>ALTA DE TURNOS</td>
                            <td><?php echo $novedades->CantNovedadesNoRegistradasGT(); ?></td>
                        </tr>

                    <?php
                    }?>
                </tbody>
                </table>
                <p class="text-primary"><strong>Ultima Novedad Registrada:</strong><?php echo $novedades->fechahoraultimanovedadregistrada; ?></p>
                <p class="text-secondary"><strong>CANTIDAD PENDIENTE DE REGISTRAR ALTA DE TURNOS: </strong><?php echo $novedades->CantNovedadesNoRegistradasGT(); ?></p>
                
                <p class="text-secondary"><strong>CANTIDAD PENDIENTE DE REGISTRAR ARRIBO CAMION: </strong><?php echo $novedades->CantNovedadesNoRegistradasAC(); ?></p>
                
                <p class="text-secondary"><strong>CANTIDAD PENDIENTE DE REGISTRAR CREACION DE PAPELES: </strong><?php echo $novedades->CantNovedadesNoRegistradasCP(); ?></p>
                
                <p class="text-secondary"><strong>CANTIDAD PENDIENTE DE REGISTRAR INGRESO A PLANTA: </strong><?php echo $novedades->CantNovedadesNoRegistradasIC(); ?></p>
                
                <p class="text-secondary"><strong>CANTIDAD PENDIENTE DE REGISTRAR COMIENZO CARGA / DESCARGA CAMION: </strong><?php echo $novedades->CantNovedadesNoRegistradasCCI(); ?></p>
                
                <p class="text-secondary"><strong>CANTIDAD PENDIENTE DE REGISTRAR FIN CARGA / DESCARGA CAMION: </strong><?php echo $novedades->CantNovedadesNoRegistradasCCF(); ?></p>
                
                <p class="text-secondary"><strong>CANTIDAD PENDIENTE DE REGISTRAR INICIO ADMINISTRACION: </strong><?php echo $novedades->CantNovedadesNoRegistradasADMI(); ?></p>
                
                <p class="text-secondary"><strong>CANTIDAD PENDIENTE DE REGISTRAR FIN ADMINISTRACION: </strong><?php echo $novedades->CantNovedadesNoRegistradasADMF(); ?></p>
                
                <p class="text-secondary"><strong>CANTIDAD PENDIENTE DE REGISTRAR SALIDA CAMION: </strong><?php echo $novedades->CantNovedadesNoRegistradasSC(); ?></p>
                
            </div>
        </section>

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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
</body>
</html>










