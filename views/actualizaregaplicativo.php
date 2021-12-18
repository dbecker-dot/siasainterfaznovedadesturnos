<?php
    require_once '../clases/novedades.php';
    require_once '../clases/config.inc.php';
    $dataplicativo=new novedades();
    $novedad=json_decode($_POST["json"]);
    var_dump($novedad->{"data"}[0]);
    echo 'Idnovedad '.$novedad->{"data"}[0]->{"Idnovedadturno"};
    echo 'Estado '.$novedad->{"data"}[0]->{"Estado"};
    $dataplicativo->idnovedadturno=$novedad->{"data"}[0]->{"Idnovedadturno"};
    $dataplicativo->resultadows="true";
    $dataplicativo->estadoenvio=$novedad->{"data"}[0]->{"Estado"};
    $dataplicativo->modificarestadonovedadturnoenbdsiasa();
?>

