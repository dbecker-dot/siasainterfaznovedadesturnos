<?php
date_default_timezone_set("America/Argentina/Buenos_Aires" ) ;
$fechactual=date('d-m-Y H:i');

require_once '../clases/Basesiasasql.php';
require_once '../clases/vigilooapp.php';
require_once '../clases/config.inc.php';
//verifico conexion con base de datos
$conexbd=new Basesiasasql();
$datvigiloo=new vigilooapp();
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="<?php echo RUTA_IMG ; ?>/favicom.ico" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title>WS-VIGILOO</title>
  </head>
  <body >
     <div class="container my-5 text-left">
        <a href="../index.php">VOLVER</a>
    </div>
    <div class="container my-5 text-center" onload="traer()">
         <h3>Fecha: <?php echo $fechactual; ?></h3>
          <h1>WS SIASA - VIGILOO</h1>
          <button class="btn btn-danger w-100" onclick="traer()"> CHECK SERVICIO</button>
    </div>
      <div class="mt-5" id="contenido">
          <p>
              
          </p>
      </div>
      <script>
            var contenido= document.querySelector('#contenido');
            function traer(){
                contenido.innerHTML=`Lo logre`
            }
          }
      </script>
  </body>
</html>