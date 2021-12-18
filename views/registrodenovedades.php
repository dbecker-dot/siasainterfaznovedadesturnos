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
                <p class="text-primary"><strong>Ultima Novedad Registrada:</strong><?php echo $novedades->fechahoraultimanovedadregistrada; ?></p>
                <p class="text-secondary"><strong>CANTIDAD PENDIENTE DE REGISTRAR ALTA DE TURNOS: </strong><?php echo $novedades->CantNovedadesNoRegistradasGT(); ?></p>
                <?php
                    if ($novedades->CantNovedadesNoRegistradasGT()!=0){
                        $novedades->insertarnovedadGT();
                        ?>
                        <p class="text-success"><strong>SE REGISTRARON NVOS TURNOS</strong></p>
                    <?php
                    }
                ?>
                <p class="text-secondary"><strong>CANTIDAD PENDIENTE DE REGISTRAR ARRIBO CAMION: </strong><?php echo $novedades->CantNovedadesNoRegistradasAC(); ?></p>
                    <?php
                    if ($novedades->CantNovedadesNoRegistradasAC()!=0){
                        $novedades->insertarnovedadAC();
                        ?>
                        <p class="text-success"><strong>SE REGISTRARON NUEVAS NOVEDADES</strong></p>
                    <?php
                    }
                ?>
                <p class="text-secondary"><strong>CANTIDAD PENDIENTE DE REGISTRAR CREACION DE PAPELES: </strong><?php echo $novedades->CantNovedadesNoRegistradasCP(); ?></p>
                    <?php
                    if ($novedades->CantNovedadesNoRegistradasCP()!=0){
                        $novedades->insertarnovedadCP();
                        ?>
                        <p class="text-success"><strong>SE REGISTRARON NUEVAS NOVEDADES</strong></p>
                    <?php
                    }
                ?>
                <p class="text-secondary"><strong>CANTIDAD PENDIENTE DE REGISTRAR INGRESO A PLANTA: </strong><?php echo $novedades->CantNovedadesNoRegistradasIC(); ?></p>
                    <?php
                    if ($novedades->CantNovedadesNoRegistradasIC()!=0){
                        $novedades->insertarnovedadIC();
                        ?>
                        <p class="text-success"><strong>SE REGISTRARON NUEVAS NOVEDADES</strong></p>
                    <?php
                    }
                ?>
                <p class="text-secondary"><strong>CANTIDAD PENDIENTE DE REGISTRAR COMIENZO CARGA / DESCARGA CAMION: </strong><?php echo $novedades->CantNovedadesNoRegistradasCCI(); ?></p>
                    <?php
                    if ($novedades->CantNovedadesNoRegistradasCCI()!=0){
                        $novedades->insertarnovedadCCI();
                        ?>
                        <p class="text-success"><strong>SE REGISTRARON NUEVAS NOVEDADES</strong></p>
                    <?php
                    }
                ?>
                <p class="text-secondary"><strong>CANTIDAD PENDIENTE DE REGISTRAR FIN CARGA / DESCARGA CAMION: </strong><?php echo $novedades->CantNovedadesNoRegistradasCCF(); ?></p>
                    <?php
                    if ($novedades->CantNovedadesNoRegistradasCCF()!=0){
                        $novedades->insertarnovedadCCF();
                        ?>
                        <p class="text-success"><strong>SE REGISTRARON NUEVAS NOVEDADES</strong></p>
                    <?php
                    }
                ?>
                <p class="text-secondary"><strong>CANTIDAD PENDIENTE DE REGISTRAR INICIO ADMINISTRACION: </strong><?php echo $novedades->CantNovedadesNoRegistradasADMI(); ?></p>
                    <?php
                    if ($novedades->CantNovedadesNoRegistradasADMI()!=0){
                        $novedades->insertarnovedadADMI();
                        ?>
                        <p class="text-success"><strong>SE REGISTRARON NUEVAS NOVEDADES</strong></p>
                    <?php
                    }
                ?>
                <p class="text-secondary"><strong>CANTIDAD PENDIENTE DE REGISTRAR FIN ADMINISTRACION: </strong><?php echo $novedades->CantNovedadesNoRegistradasADMF(); ?></p>
                    <?php
                    if ($novedades->CantNovedadesNoRegistradasADMF()!=0){
                        $novedades->insertarnovedadADMF();
                        ?>
                        <p class="text-success"><strong>SE REGISTRARON NUEVAS NOVEDADES</strong></p>
                    <?php
                    }
                ?>
                <p class="text-secondary"><strong>CANTIDAD PENDIENTE DE REGISTRAR SALIDA CAMION: </strong><?php echo $novedades->CantNovedadesNoRegistradasSC(); ?></p>
                    <?php
                    if ($novedades->CantNovedadesNoRegistradasSC()!=0){
                        $novedades->insertarnovedadSC();
                        ?>
                        <p class="text-success"><strong>SE REGISTRARON NUEVAS NOVEDADES</strong></p>
                    <?php
                    }
                ?>
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










