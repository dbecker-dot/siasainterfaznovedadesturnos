<?php
    require_once '../clases/vigilooapp.php';
    require_once '../clases/config.inc.php';
    $datvigiloo=new vigilooapp();
    $novedad=json_decode($_POST["json"]);
    var_dump($novedad->{"data"}[0]);
    echo 'Idnovedad '.$novedad->{"data"}[0]->{"Idnovedadturno"};
    echo 'Fecha '.$novedad->{"data"}[0]->{"Fecha"};
    echo 'Estado '.$novedad->{"data"}[0]->{"Estado"};
    $datvigiloo->idnovedadturno=$novedad->{"data"}[0]->{"Idnovedadturno"};
    $datvigiloo->resultadows="true";
    $datvigiloo->estadoenvio=$novedad->{"data"}[0]->{"Estado"};
    $datvigiloo->modificarestadonovedadturnoenbdsiasa();
?>

