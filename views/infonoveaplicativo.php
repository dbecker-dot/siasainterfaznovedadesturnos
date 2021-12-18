<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 */
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>WS - APLICATIVO</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="../assets/js/envioaplicativo.js"></script>
      
  <script>
        //defino variables y constantes para enviar POST a vigiloo 
        
        //leo las novedades
        listarovedades ();
        traerdatosaplicativo ();
        /*
        console.log(json);
        Idnovedadturno=json.Idnovedadturno;
        ShipmentRefId=json.ShipmentRefId;
        Date=json.Date;
        StatusCode = json.StatusCode;
        switch (StatusCode) {
            case 'AR': 
                    StatusCode = 'ADC';
                    break;
            case 'CC': 
                    StatusCode = 'CAC';
                    break;
            case 'SC': 
                    StatusCode = 'DSP';
                    break;
            default:  
                    StatusCode = 'ERR'
            }
        $('#res').text(ShipmentRefId);
        
        function listarovedades (){
            _ajax("jsonorigen.php","")
                .done(function(info){
                    var novedades = JSON.parse(info);
                    for (var i )
                    console.log(novedades);
                    $('#res').text(novedades[0].ShipmentRefId);
            });
        }
        
        function _ajax(url,data){
            var ajax = $.ajax({
                "method": "POST",
                "url": url,
                "data":data
            })
            return ajax;
        }
        
        
        $.getJSON("jsonorigen.php",function(json){
        const LogisticGroupId="b5f0d86e-dd9e-49c7-a55e-f3b0ce3300b4";
        const SiteCode="7756";
        const EventCode="";
        const EventData="";
        const StatusGroupCode="Centro Logistico";
        const StatusData="";
        const ChangeScheduleStatus=true;
        var Idnovedadturno;
        Idnovedadturno=json.Idnovedadturno;
        console.log(Idnovedadturno);
        var ShipmentRefId;
        var Date;
        ShipmentRefId=json.ShipmentRefId;
        Date=json.Date;
        var StatusCode = json.StatusCode;
            switch (StatusCode) {
               case 'AR': StatusCode = 'ADC';
               break;
            
               case 'CC': StatusCode = 'CAC';
               break;
            
               case 'SC': StatusCode = 'DSP';
               break;
                default:  StatusCode = 'ERR'
            }
            
          $('#res').text(json.ShipmentRefId);
          console.log(Date);
        var jsonrequest={"LogisticGroupId":LogisticGroupId,
                         "SiteCode":SiteCode,
                         "Date":Date,
                         "ShipmentRefId":ShipmentRefId,
                         "EventCode":EventCode,
                         "EventData":EventData,
                         "StatusCode":StatusCode,
                         "StatusGroupCode":StatusGroupCode,
                         "StatusData":StatusData,
                         "ChangeScheduleStatus":ChangeScheduleStatus
                        };
        console.log(jsonrequest);
        // Ejemplo implementando el metodo POST:
        async function postData(url = '', data = {}) {
            // Opciones por defecto estan marcadas con un *
            const response = await fetch(url, {
                method: 'POST', // *GET, POST, PUT, DELETE, etc.
                headers: {
                "Content-type": "application/json",
                "token": "edd90bbf-7ae2-4d66-a892-077ed4482fb2",
                "signature": "e2Wg3iBQXRG/ZqjrTpKnoScQvor4DxB2R5lEFpU4yj4="
                },
                body: JSON.stringify(jsonrequest) // body data type must match "Content-Type" header
            });
            var jsonresponse;
            if (response.status==200){
                jsonrequest={"Idnovedadturno":Idnovedadturno,
                             "Resultado":"OK"
                            }
                //return response.json();
                return jsonrequest;
            } else {
                jsonrequest={"Idnovedadturno":Idnovedadturno,
                             "Resultado":"ERROR"
                            }
                //console.log(response.status);
                //return response.status;
                return jsonrequest;
            }
            //console.log(response.status);
            //return response.json(); // parses JSON response into native JavaScript objects
        }

        postData('https://rtv-b2b-api.vigiloo.net/api/ShipmentEventBus', jsonrequest)
            .then(data => {
                console.log(data.Idnovedadturno); // JSON data parsed by `data.json()` call
                console.log(data.Resultado);
                // El JSON a enviar
                var ajax_url = "ajax-test.php";
                var myjson = { "Idnovedadturno" : data.Idnovedadturno, "Resultado" : data.Resultado };
                
               
                function enviar(){
                    __ajax(ajax_url,{"json": JSON.stringify(myjson)})
                    .done(function(info){
                        console.log(info);
                    });
                }
                
                function __ajax(url,data){
                    var ajax = $.ajax({
                        "method":"POST",
                        "url":url,
                        "dataType":'json',
                        "data":data
                    })
                    return ajax;
                }
                console.log(myjson);
                enviar();
            });
        });
        
        function actualizar(){location.reload(true);}
            //Función para actualizar cada 4 segundos(4000 milisegundos)
        setInterval("actualizar()",4000);
        */
        
        
  </script>
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
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body>
    <span id="res">NADA</span>
    <div id="result">
</div>
</body>
</html>