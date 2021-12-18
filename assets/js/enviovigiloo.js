function traerdatos (){
    console.log('estoy en la funcion traer datos');
    const xhttp = new XMLHttpRequest();
    xhttp.open('GET','jsonorigen.php',true);
    xhttp.send();
    //defino variables para informar
    const LogisticGroupId="b5f0d86e-dd9e-49c7-a55e-f3b0ce3300b4";
    const SiteCode="7756";
    const EventCode="";
    const EventData="";
    const StatusGroupCode="Centro Logistico";
    const StatusData="";
    const ChangeScheduleStatus=true;
    var Idnovedadturno;
    var ShipmentRefId;
    var Date;
    xhttp.onreadystatechange=function(){
        if (this.readyState==4 && this.status==200){
            console.log(this.responseText);
            let datos = JSON.parse(this.responseText);
            Idnovedadturno=datos.Idnovedadturno;
            ShipmentRefId=datos.ShipmentRefId;
            Date=datos.Date;
            StatusCode=datos.StatusCode;
            switch (StatusCode) {
               case 'AR': StatusCode = 'ADC';
               break;
            
               case 'CC': StatusCode = 'CAC';
               break;
            
               case 'SC': StatusCode = 'DSP';
               break;
                default:  StatusCode = 'ERR'
            }
            console.log(Date);
            let res= document.querySelector('#res');
            var ShipmentRefId;
            var Date;
            $('#res').text(datos.ShipmentRefId);
            if (Idnovedadturno>0){
                //envio la novedad a vigiloo
                //preparo el json
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
                        if (data.Resultado=="OK"){
                            var data=[];
                            data.push(
                                {"Idnovedadturno":Idnovedadturno,"Fecha":Date,"Estado":"OK"}
                            );
                            var novedad={"data": data};
                            var json = JSON.stringify(novedad);
                            console.log(json);
                            _ajax("actualizareg.php",{"json": json})
                            .done(function(info){
                                console.log(info);
                                console.log("INFORMADO");
                });
                        }
                    // El JSON a enviar
                        var myjson = { "Idnovedadturno" : data.Idnovedadturno, "Resultado" : data.Resultado };
                
                console.log(myjson);
                
            });
       
                
                
            }
            //res.innerHTML='';
            
        }
    }
   
}

//funcion que determina el intervalo de actualizacion segun el horario de SIASA desde 06:45 a 19:15 cada 4 segundos sino cada 1 hora 
function actualizardatos(){
    var hoy= new Date();
    var intervalo;
    intervalo=(1000*60)*60;
    location.reload(true);
    if (hoy.getHours()>=6 && hoy.getMinutes()>45){
        if (hoy.getHours()>=19 && hoy.getMinutes()<15){
            intervalo=4000;
        } 
    } 
    setInterval("actualizardatos()",intervalo);
    console.log(intervalo);
}


function listarovedades (){
    _ajax("jsonorigen.php","")
    .done(function(info){
        console.log(info);
        return Json.parse(info);
        
    });
}

function datos(){
    var data=[];
    data.push(
        {"Idnovedadturno":Idnovedadturno,"precio":33}
    );
    var productos={"data": data};
    return productos;
}

function guardar (){
    var json = JSON.stringify(datos());
    console.log(json);
    _ajax("actualizareg.php",{"json": json})
    .done(function(info){
        console.log(info);
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

//funcionalidad botones de pagina ws_vigiloo
document.querySelector('#btn_novnoinf').addEventListener('click',novedadesnoinformadas());
document.querySelector('#btn_novnoinf').addEventListener('click',novedadesinformadas());
document.querySelector('#btn_novnoinf').addEventListener('click',statusgralhoy());
    
function novedadesnoinformadas(){
        console.log('novedades no informadas');
    }
    
    function novedadesinformadas(){
        console.log('novedades informadas');
    }
    
    function statusgralhoy(){
        console.log('status');
    }
    
    
    