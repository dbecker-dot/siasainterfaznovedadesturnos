<?php
$str_json = file_get_contents('php://input'); //($_POST doesn't work here)
$response = json_decode($str_json, true); // decoding received JSON to array
var_dump($response);
date_default_timezone_set("America/Argentina/Buenos_Aires" ) ;
$fechactual=date('d-m-Y H:i');
require_once '../clases/vigilooapp.php';
require_once '../clases/config.inc.php';
$datvigiloo=new vigilooapp();

$datvigiloo->buscarcredencialesvalidas();


define('TOKEN', $datvigiloo->token);
define('SIGNATURE', $datvigiloo->signature);

echo $response[0].'</br>';
echo SIGNATURE;



function JSON2Array($data){
    return  (array) json_decode(stripslashes($data));
}

function request_envio(){
    $url='https://rtv-b2b-api.vigiloo.net/api/ShipmentEventBus';
    $httpheader=['token: '.TOKEN.', signature: '.SIGNATURE.'content-type: application/json; charset=utf-8'];
    $data = array("LogisticGroupId"=>"b5f0d86e-dd9e-49c7-a55e-f3b0ce3300b4", "SiteCode"=>"7756", 
                "Date"=>"2021-06-10 09:08","ShipmentRefId"=>"168576",
                "EventCode"=>"","EventData"=>"","StatusCode"=>"CAC",
                "StatusGroupCode"=>"Centro Logistico","StatusData"=>"","ChangeScheduleStatus"=>true);
            $jsonsend = json_encode($data);
    //$arr= array("Body"=>$data);
    //$jsonsend = json_encode($arr);
    echo $jsonsend;
    /*
    $data["LogisticGroupId"]="b5f0d86e-dd9e-49c7-a55e-f3b0ce3300b4";
    $data["SiteCode"]="7756";
    //$data["Date"]=date('Y-m-d H:i');
    $data["Date"]= "2021-05-31 07:50";
    $data["ShipmentRefId"]="168202";
    $data["EventCode"]="";
    $data["EventData"]="";
    $data["StatusCode"]="ADC";
    $data["StatusGroupCode"]="Centro Logistico";
    $data["StatusData"]="";
    $data["ChangeScheduleStatus"]=true;
    $datos = json_encode($data);
    echo $datos;
     * 
     */
    //echo $jsonsend;
    $conexionapi= curl_init();
    curl_setopt($conexionapi, CURLOPT_URL, $url);
    curl_setopt($conexionapi, CURLOPT_HTTPGET, false);
    curl_setopt($conexionapi, CURLOPT_POST, TRUE);
    curl_setopt($conexionapi, CURLOPT_HTTPHEADER, $httpheader);
    curl_setopt($conexionapi, CURLOPT_POSTFIELDS, $data);
    //curl_setopt($conexionapi, CURLOPT_RETURNTRANSFER, true); 
    // Comprobar si occurió algún error
    if(curl_errno($conexionapi))
    {
        echo '</br> Curl error: ' . curl_error($conexionapi);
    } else {
        //echo '</br> No se registraron Errores: ';
    }
    $response= curl_exec($conexionapi);
    curl_close($conexionapi);
    //print_r($response);
    $dat = json_decode(file_get_contents('php://input'), true);
    var_dump($dat);
    /*
    echo '</br>';
    $arr = JSON2Array($response);
    header('Content-Type: text/html; charset=utf-8');
    echo print_r($arr);
    
    //echo json.parse($response);
    echo '</br>';
    $jsdata= json_decode($response, true);
    //echo '</br>'. $jsdata['response']['Error'];
    //var_dump($jsonsend);
    if ($jsdata['AccessGranted']==false ){
        echo '</br> Se registraron Errores: Error Code: ';
        echo $jsdata['ErrorCode'];
    } 
    if ($jsdata['AccessGranted']==true ){
        echo '</br> No se registraron Errores: ';
        echo $jsdata['ErrorCode'];
    }
    print_r('AG '.$jsdata[0]);
    if ($jsdata['Error']==false ){
        //echo 'Token '.$datcredenciales['Token'].'<br/>';
        //echo 'Signature '.$datcredenciales['Signature'].'<br/>';
        //$actcredencialesvigiloo->token=$datcredenciales['Token'];
        //$actcredencialesvigiloo->signature=$datcredenciales['Signature'];
        //$actcredencialesvigiloo->insertarcredencialesvigiloo();
        echo '</br> No se registraron Errores: ';
        echo $jsdata['AccessGranted'];
        echo $jsdata['Error'];
        echo $jsdata['ErrorCode'];
        echo $jsdata['ErrorDescription'];
    } else {
        echo '</br> Se registraron Errores: ';
         echo $jsdata['AccessGranted'];
        echo $jsdata['Error'];
        echo $jsdata['ErrorCode'];
        echo $jsdata['ErrorDescription'];
    }
    
//$datos = file_get_contents($url);
    /*
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
    
     * 
     */
}

request_envio();


?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<body>
<div align="center">
    <label for="LName">Last Name</label>
    <input type="text" class="form-control" name="LName" id="LName" maxlength="15"
           placeholder="Last name"/>
</div>
<br/>

<div align="center">
    <label for="Age">Age</label>
    <input type="text" class="form-control" name="Age" id="Age" maxlength="3"
           placeholder="Age"/>
</div>
<br/>

<div align="center">
    <button type="submit" name="submit_show" id="submit_show" value="show" onclick="actionSend()">Show
    </button>
</div>

<div id="result">
</div>
<button id="boton"> PRUEBA </button>


<script>
    const button = document.getElementById('boton')

   //fetch('https://jsonplaceholder.typicode.com/users')
    //  .then(response => response.json())
    //  .then(json => console.log(json))
   
   fetch('https://rtv-b2b-api.vigiloo.net/api/ShipmentEventBus', {
            method: 'POST',
            body: JSON.stringify({
                LogisticGroupId: "b5f0d86e-dd9e-49c7-a55e-f3b0ce3300b4",
                SiteCode: "7756",
                Date:"2021-06-10 14:01",
                ShipmentRefId:"168583",
                EventCode:"",
                EventData:"",
                StatusCode:"DSP",
                StatusGroupCode:"Centro Logistico",
                StatusData:"",
                ChangeScheduleStatus:true
            }),
            headers: {
                "Content-type": "application/json",
                "token": "edd90bbf-7ae2-4d66-a892-077ed4482fb2",
                "signature": "e2Wg3iBQXRG/ZqjrTpKnoScQvor4DxB2R5lEFpU4yj4="
            }})
        .then(response => response.json())
        .then(json => console.log(json))
        var respuesta=json;
        request= new XMLHttpRequest()
        request.open("POST", "enviovigiloo.php", true)
        request.setRequestHeader("Content-type", "application/json")
        request.send(respuesta)
        console.log(respuesta)
</script>