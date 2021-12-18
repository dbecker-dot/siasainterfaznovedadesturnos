<?php
require_once 'clases/config.inc.php';
//capturo la app que se quiere acceder pasada por get en la URL
header('Location: '.SERVIDOR.'/views/registrodenovedades.php');
if (isset($_GET['app'])){
    $app=$_GET['app'];
} else {
    $app=0;
}
date_default_timezone_set("America/Argentina/Buenos_Aires" ) ;
$fechactual=date('d-m-Y H:i');

require_once './clases/Basesiasasql.php';
//require_once './clases/config.inc.php';
$chbd = new Basesiasasql();

ob_start();
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
         <h3><?php echo $fechactual; ?></h3>
      <!-- Content Header (Page header) -->
       <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">SIASAPP V 1.0</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">HOME</a></li>
      <li><a href="#">HELPDESK IT</a></li>
      <li><a href="#">INTERFAZ RDS - BAYER</a></li>
      <li><a href="<?php echo SERVIDOR.'?app=1'; ?>">WS STK AFIP</a></li>
      <li><a href="<?php echo SERVIDOR.'?app=2'; ?>">WS VIGILOO</a></li>
      <li><a href="#">WS APLICATIVO</a></li>
    </ul>
      <ul class="nav navbar-nav navbar-right">
      <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
      <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
    </ul>
    
  </div>
</nav>
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-12">
            <h3>HOME</h3>
            <img src="assets/img/logosiasa.jpg" class="img-circle" alt="Cinque Terre" width="304" height="236">
             <?php 
            if ($chbd->conectar()=='Error') {
                echo '<div class="alert alert-danger">
                <strong>Error!</strong> CONEXION BASE DE DATOS
                </div>';
                exit();
            } else {
                /*
                echo '<div class="alert alert-success">
                <strong>OK!</strong> CONEXION BASE DE DATOS
                </div>';
                 * 
                 */
            }
            if ($app==0){
                
            }
       
            if ($app==1){
                header('Location: '.SERVIDOR.'/views/ws_stocksafip.php');
            }
            
            if ($app==2){
                header('Location: '.SERVIDOR.'/views/ws_vigiloo.php');
            }
            
            if ($app==3){
                header('Location: '.SERVIDOR.'/views/ws_aplicativo.php');
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
<?php
ob_end_flush();
exit();
?>


