<?php
require_once '../clases/vigilooapp.php';
require_once '../clases/config.inc.php';
$datvigiloo=new vigilooapp();
$datvigiloo->idnovedadturno= 0;
$datvigiloo->resultadows='true';
$datvigiloo->estadoenvio='OK';
$datvigiloo->modificarestadonovedadturnoenbdsiasa();
try {
    $response = json_decode($_POST["json"]); // decoding received JSON to array
    var_dump($response);
} catch (Exception $ex) {
    echo $ex->getMessage();
}
echo 'OK'.$_POST['json'];
$response = json_decode($_POST['json'],true); // decoding received JSON to array
var_dump($response);
$datvigiloo->idnovedadturno= $response[0];
if ($response[1]=='OK'){
    $datvigiloo->resultadows='true';
    $datvigiloo->estadoenvio=$response[1];
} else {
    $datvigiloo->resultadows='false';
    $datvigiloo->estadoenvio=$response[1];
}
$datvigiloo->modificarestadonovedadturnoenbdsiasa();
echo 'OK';
?>

