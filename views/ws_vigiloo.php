<?php
date_default_timezone_set("America/Argentina/Buenos_Aires" ) ;
$fechactual=date('d-m-Y H:i');
$i=0;
require_once '../clases/Basesiasasql.php';
require_once '../clases/vigilooapp.php';
require_once '../clases/config.inc.php';
//verifico conexion con base de datos
$conexbd=new Basesiasasql();
$datvigiloo=new vigilooapp();
function DATOSTOKEN(){
    
}

function get_http_response_code($theURL) {
    $headers = get_headers($theURL);
    return substr($headers[0], 9, 3);
}

function checkapi(){
    $url='https://rtv-b2b-api.vigiloo.net/api/CheckConnection';
    $conexionapi= curl_init();
    $httpheader=['token: cbe0dcc4-4158-4799-9e22-99fc01b0aa0f, signature: +YqlTyuFyP4Mc//hvzOqQLnl/iaHSVnB7cIdgR5xAQ4='];
    //$httpheader=[signature: +YqlTyuFyP4Mc//hvzOqQLnl/iaHSVnB7cIdgR5xAQ4='];
    
    
    curl_setopt($conexionapi, CURLOPT_URL, $url);
    curl_setopt($conexionapi, CURLOPT_HTTPGET, TRUE);
    curl_setopt($conexionapi, CURLOPT_RETURNTRANSFER, 1);
    //setup request to send json via POST
    curl_setopt($conexionapi, CURLOPT_HTTPHEADER, array('token: cbe0dcc4-4158-4799-9e22-99fc01b0aa0f','signature: +YqlTyuFyP4Mc//hvzOqQLnl/iaHSVnB7cIdgR5xAQ4='));
    $response= curl_exec($conexionapi);
    curl_close($conexionapi);
    $data= json_decode($response,true);
    //print_r($data);
    if (isset($data["UserName"])){
        return 'OK';
    } else {
        return 'Error';    
    }
}

function request_token(){
    $actcredencialesvigiloo=new vigilooapp();
    $url='https://rtv-b2b-api.vigiloo.net/api/Login?username=vigiloo-b2b@siasalogistica.com.ar&password=BAyer$BAPI21';
    $conexionapi= curl_init();
    curl_setopt($conexionapi, CURLOPT_URL, $url);
    curl_setopt($conexionapi, CURLOPT_HTTPGET, TRUE);
    curl_setopt($conexionapi, CURLOPT_HTTPHEADER, array('Content-Type: aplication/json'));
    curl_setopt($conexionapi, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
    curl_setopt($conexionapi, CURLOPT_RETURNTRANSFER, 1);
    $response= curl_exec($conexionapi);
    curl_close($conexionapi);
    $datos = file_get_contents("$url");
    if ($response){
        $datcredenciales = json_decode($datos, true);
    }
    if ($datcredenciales['Error']==FAlSE){
        echo 'Token '.$datcredenciales['Token'].'<br/>';
        echo 'Signature '.$datcredenciales['Signature'].'<br/>';
        $actcredencialesvigiloo->token=$datcredenciales['Token'];
        $actcredencialesvigiloo->signature=$datcredenciales['Signature'];
        //$actcredencialesvigiloo->insertarcredencialesvigiloo();
    }
    //echo var_dump($datcredenciales);
}

function request_poststatusembarques(){
    
}

//request_token();

ob_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>WS - VIGILOO</title>
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
    <div class="content-header">
        <h3><?php echo $fechactual; ?></h3>
        <!-- Content Header (Page header) -->
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">SIASAPP V 1.0</a>
                </div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="../index.php">HOME</a></li>
                    <li><a href="#">CHECK SERVICIO</a></li>
                    <li><a href="#">OBTENER TOKEN</a></li>
                    <li><a href="#">CHECK ENVIO</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <h3>WS SIASA - VIGILOO</h3>
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <h4>REFERENCIAS DE ESTADOS</h4>
            </div>
            <div class="col">
                <span class="label label-success">OK</span>
            </div>
            <div class="col">
                <span class="label label-danger">Error</span>
            </div>
        </div>
    </div>      
    <section class="content-wrapper">
        <div class="container">
            <div class="row align-items-center">
                <div class="col">
                    <h4>CONEXION CON BASE DE DATOS SIASA</h4>
                </div>
            <?php 
            //Verifico conexion base siasa
            if ($conexbd->conectar()=='Error') {
                echo '<span class="label label-danger">Error</span>';
            } else {
                echo '<span class="label label-success">OK</span>';
            }
            ?>
            </div>    
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col">
                    <h4>ESTADO API VIGILOO</h4>
                </div>
            <?php
            //Verifico acceso a api
            if (checkapi()=='Error') {
                ?>
            <script>mostrarMensaje();
                </script>
                <?php
                echo '<span class="label label-danger">Error</span>';
            } else {
                echo '<span class="label label-success">OK</span>';
            }
            ?>
            </div>    
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col">
                    <h4>CREDENCIALES VIGILOO</h4>
                </div>
        <?php
            
            //Verifico y actualizo token de acceso
            $datvigiloo->buscarcredencialesvalidas();
            
            if ($datvigiloo->token==-1) {
                echo '<span class="label label-danger">Error</span>';
            }
            if ($datvigiloo->token==0) {
                echo '<span class="label label-danger">Error</span>';    
            }
            if (strlen($datvigiloo->token)>2) {
                echo '<span class="label label-success">OK</span>';    
            }
            echo '</br>'; 
            ?>
            </div>    
        </div>
        <div class="container">
            <button type="button" class="btn btn-primary" id="btn_novnoinf">Novedades no Informadas</button>
            <button type="button" class="btn btn-success" id="btn_novinf">Novedades informadas</button>
            <button type="button" class="btn btn-info" id="btn_statusgralhoy">Status</button>
            <div class="row align-items-center">
                <div class="col">
                    <h4>NOVEDADES NO INFORMADAS</h4>
                </div>        
        <?php
            if ($datvigiloo->cantnovedadesnoinformadas()>0) {
                echo '<span class="label label-danger">Error</span> ( '.$datvigiloo->cantnovedadesnoinformadas().' )';
            }
            if ($datvigiloo->cantnovedadesnoinformadas()==0) {
                echo '<span class="label label-success">OK</span> ( '.$datvigiloo->cantnovedadesnoinformadas().' )';    
            }
                   
            
            echo '</br>';
            $novedades= $datvigiloo->listarnovedadespendientesdeinformar();
            foreach ($novedades as $row) :
                echo $row['turno'].' - '.$row['nroembarque'].' - '.$row['tipo'].' - '.$row['fechahoranovedad']->format('d/m/Y H:i').' - '.$row['idnovedadturno'].'</br>';
            endforeach
            
            
            ?>
            <div class="table-responsive">
                <table class="table">
                <thead>
                <tr>
                    <th>Turno</th>
                    <th>Embarque</th>
                    <th>Novedad</th>
                    <th>Fecha</th>
                    <th>Id</th>
                </tr>
            </thead>
            <tbody id="cuerpoTabla">
            </tbody>
        </table>    
            </div>
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

  

<!-- ./wrapper -->

<!-- Bootstrap 3.3.7 -->
<script src="../assets/js/enviovigiloo.js"></script>
<script src="<?php echo RUTA_JS;?>/bootstrap.min.js"></script>
<script>
    
    
  function mostrarMensaje()
  {
    document.write("Cuidado<br>");
    document.write("Ingrese su documento correctamente<br>");
  }
  
</script>
</body>
</html>
<?php
ob_end_flush();
exit();
?>
<?php
