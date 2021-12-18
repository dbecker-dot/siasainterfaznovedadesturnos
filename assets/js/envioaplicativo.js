function traerdatosaplicativo (){
    const xhttp = new XMLHttpRequest();
    xhttp.open('GET','jsonorigenaplicativo.php',true);
    xhttp.send();
    //defino variables para informar
    const token="E*DllH7XXxB6+_ajF$oRh0pMoU$1W4aH*5$+PzmlOv3G*W5TVJLCAy*kCWtz";
    var turno;
    var Idnovedadturno;
    xhttp.onreadystatechange=function(){
        if (this.readyState==4 && this.status==200){
            console.log(this.responseText);
            let datos = JSON.parse(this.responseText);
            turno=datos.turno;
            Idnovedadturno=datos.Idnovedadturno;
            ShipmentRefId=datos.ShipmentRefId;
            let res= document.querySelector('#res');
            $('#res').text(datos.turno);
            if (Idnovedadturno>0){
                //envio la novedad a vigiloo
                //preparo el json
                var jsonrequest={"turno":turno};
                //console.log(jsonrequest);
                // Ejemplo implementando el metodo POST:
                async function postData(url = '', data = {}) {
                    // Opciones por defecto estan marcadas con un *
                    const response = await fetch(url, {
                        method: 'POST', // *GET, POST, PUT, DELETE, etc.
                        headers: {
                            "Content-type": "application/json",
                            "token": token
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
                
                postData('http://192.168.2.166:8080/api/siasatest/api/v1.1/notification', jsonrequest)
                    .then(data => {
                        //console.log(data.Idnovedadturno); // JSON data parsed by `data.json()` call
                        //console.log(data.Resultado);
                        if (data.Resultado=="OK"){
                            var data=[];
                            data.push(
                                {"Idnovedadturno":Idnovedadturno,"Estado":"OK"}
                            );
                            var novedad={"data": data};
                            var json = JSON.stringify(novedad);
                            console.log(json);
                            _ajax("actualizaregaplicativo.php",{"json": json})
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




function listarovedades (){
    _ajax("jsonorigenaplicativo.php","")
    .done(function(info){
        console.log(info);
        
        
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
    
    
    