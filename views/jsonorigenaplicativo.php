<?php
date_default_timezone_set("America/Argentina/Buenos_Aires" ) ;
require_once '../clases/novedades.php';
//require_once '../clases/config.inc.php';
$dataplicativo=new novedades();
if ($dataplicativo->cantnovedadesaplicativonoinformadas()!= 0){
    $novedades= $dataplicativo->listarnovedadesaplicativopendientesdeinformar();
    foreach ($novedades as $row) :
        $data=array(
            "turno"=>$row['turno'],
            "Idnovedadturno"=>$row['idnovedadturno'],
        );
        $jsonsend = json_encode($data);
        echo $jsonsend;
        exit();
    endforeach;
} else {
    $data=array(
        "turno"=>0,
        "Idnovedadturno"=>0,
    );
    echo $jsonsend;
    exit();
}
$data = array("Idnovedadturno"=>1, "Date"=>"2021-06-11 08:10","ShipmentRefId"=>"168629","StatusCode"=>"SC");
            $jsonsend = json_encode($data);
   
