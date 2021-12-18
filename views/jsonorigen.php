<?php
date_default_timezone_set("America/Argentina/Buenos_Aires" ) ;

require_once '../clases/vigilooapp.php';

require_once '../clases/config.inc.php';

header("Access-Control-Allow-Origin: *");
$datvigiloo=new vigilooapp();

if ($datvigiloo->cantnovedadesnoinformadas()>0){
    $novedades= $datvigiloo->listarnovedadespendientesdeinformar();
    foreach ($novedades as $row) :
        $data=array(
            "Date"=>$row['fechahoranovedad']->format('Y-m-d H:i'),
            "ShipmentRefId"=>$row['nroembarque'],
            "StatusCode"=>$row['tipo'],
            "Idnovedadturno"=>$row['idnovedadturno'],
        );
        $jsonsend = json_encode($data);
        echo $jsonsend;
        exit();
    endforeach;
} else {
    $data=array(
        "Date"=>date('Y-m-d H:i'),
        "ShipmentRefId"=>0,
        "StatusCode"=>'NA',
        "Idnovedadturno"=>0,
    );
    echo $jsonsend;
    exit();
}
$data = array("Idnovedadturno"=>1, "Date"=>"2021-06-11 08:10","ShipmentRefId"=>"168629","StatusCode"=>"SC");
            $jsonsend = json_encode($data);
   
