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

<script>
    
    async function Infonovedad(parametro) {
        let url = 'https://pokeapi.co/api/v2/pokemon/' + parametro;
        let response = await fetch('https://rtv-b2b-api.vigiloo.net/api/ShipmentEventBus', {
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
            }});
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
   }

   let myJson = await response.json();

   // Has tus converciones aqui
   //let arregloRespuesda = ....
   //return arregloRespuesta;
 }

 let parametro = document.getElementById("result").value;
 Infonovedad(parametro)
 .then((arreglo) => {
   // Aqui pones lo que pasa despues de esta llamada
 })
 .catch(e => console.log(e));
    
    var xmlhttp;
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
        .then(json => console.log(json));
    function actionSend() {
        if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        var values = $("input").map(function () {
            return $(this).val();
        }).get();
        var myJsonString = JSON.stringify(json);
        xmlhttp.onreadystatechange = respond;
        xmlhttp.open("POST", "ajax-test.php", true);
        xmlhttp.send(myJsonString);
    }

    function respond() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById('result').innerHTML = xmlhttp.responseText;
        }
    }

</script>

</body>
</html>
