<?php

define("WSDLA", "wsaa.wsdl");     # The WSDL corresponding to WSAA
define("WSDL", "wsdl.wsdl");     # The WSDL corresponding to WSAA
define("CERT", "C:/xampp/htdocs/SPGestion/ClasesFAE/Certificados/20165420501.crt");       # The X.509 certificate in PEM format - el del paso 3.. empieza el archivo con -----BEGIN CERTIFICATE-----
define("PRIVATEKEY", "C:/xampp/htdocs/SPGestion/ClasesFAE/Certificados/20165420501.key"); # The private key correspoding to CERT (PEM) .. paso 1, empieza archivo con -----BEGIN RSA PRIVATE KEY-----
define("PASSPHRASE", ""); # The passphrase (if any) to sign .. clave que se coloco en paso 1 y 2
define("PROXY_HOST", "10.20.152.113"); # Proxy IP, to reach the Internet
define("PROXY_PORT", "80");            # Proxy TCP port
define("URL", "https://wsaahomo.afip.gov.ar/ws/services/LoginCms");  # ambiente de prueba

ini_set("soap.wsdl_cache_enabled", "0");
ini_set('soap.wsdl_cache_ttl', "0");

function getCAE() 
{
    
}

function CreateTRA($SERVICE) {
    $TRA = new SimpleXMLElement(
                    '<?xml version="1.0" encoding="UTF-8"?>' .
                    '<loginTicketRequest version="1.0">' .
                    '</loginTicketRequest>');
    $TRA->addChild('header');
    $TRA->header->addChild('uniqueId', date('U'));

    $TRA->header->addChild('generationTime', date('c', date('U') - 60));
    $TRA->header->addChild('expirationTime', date('c', date('U') + 60));
    $TRA->addChild('service', $SERVICE);
    $TRA->asXML('C:/xampp/htdocs/SPGestion/ClasesFAE/TRA.xml');
}

function SignTRA() 
{
    	$STATUS = openssl_pkcs7_sign(realpath('.') . '/' . "TRA.xml", realpath('.') . '/' . "TRA.tmp", "file://" . realpath('.') . '/Certificados/' . CERT,
    			array("file://" . realpath('.') . '/Certificados/' . PRIVATEKEY, PASSPHRASE),
    			array(),
    			!PKCS7_DETACHED);

    	if (!$STATUS) 
 	{
        	exit("ERROR generating PKCS#7 signature\n");
    	}

    	$inf = fopen(realpath('.') . "TRA.tmp", "r");
    	$i = 0;
    	$CMS = "";
    
	while (!feof($inf)) 
	{
        	$buffer = fgets($inf);
        
		if ($i++ >= 4) 
		{
            		$CMS.=$buffer;
        	}
    	}
    
	fclose($inf);
    	unlink("TRA.tmp");
    
	return $CMS;
}

function CallWSAA($CMS) 
{
    	$client = new SoapClient(WSDLA, array('soap_version' => SOAP_1_2, 'location' => URL, 'trace' => 1, 'exceptions' => 0));

    	$results = $client->loginCms(array('in0' => $CMS));

    	file_put_contents("request-loginCms.xml", $client->__getLastRequest());
    	file_put_contents("response-loginCms.xml", $client->__getLastResponse());
    
	if (is_soap_fault($results)) 
	{
        	exit("SOAP Fault: " . $results->faultcode . "\n" . $results->faultstring . "\n");
    	}

    	return $results->loginCmsReturn;
}

$SERVICE = 'WSFE';
CreateTRA($SERVICE);
$CMS = SignTRA();
$TA = CallWSAA($CMS);


if (!file_put_contents("TA.xml", $TA)) 
{
    exit();
}

$ta_xml = simplexml_load_string($TA);
$TOKEN = $ta_xml->credentials->token;
$SIGN = $ta_xml->credentials->sign;

$opts = array('ssl' => array('ciphers' => 'RC4-SHA'));

$client_wsfe = new SoapClient(WSDL, array(
            'trace' => true,
            'encoding' => 'UTF-8',
            'cache_wsdl' => WSDL_CACHE_BOTH,
            //'ssl_method' => SOAP_SSL_METHOD_SSLv3,
            'stream_context' => stream_context_create($opts),
            "exceptions" => false
        ));



// metodo para probar si se conecta
//$results_AutRequest = $client_wsfe->FEDummy();


/*
//////////////////
$results_AutRequest = $client_wsfe->FECompUltimoAutorizado(
         array(
            'Auth' => array
                (
                'Token' => $TOKEN,
                'Sign' => $SIGN,
                'Cuit' => 20264678014,
                
            ),
             'PtoVta' => 1,
             'CbteTipo' => 6 //1 factura A - 6 factura B
        
        )
        );
 
 */

//////////////////
/*$results_AutRequest = $client_wsfe->FEParamGetTiposTributos(
         array(
            'Auth' => array
                (
                'Token' => $TOKEN,
                'Sign' => $SIGN,
                'Cuit' => 20264678014,
                
            )
        )
        );*/
/*
//////////////////
$results_AutRequest = $client_wsfe->FEParamGetTiposIva(
         array(
            'Auth' => array
                (
                'Token' => $TOKEN,
                'Sign' => $SIGN,
                'Cuit' => 20264678014,
                
            )
        )
        );
 */
 $imp_total = 159.05;
$imp_total_conceptos = 0;
$imp_neto = 125;
$imp_operaciones_exentas = 0;
$imp_iva = 26.25;
$imp_trib = 7.80;



$results_AutRequest = $client_wsfe->FECAESolicitar(
        array(
            'Auth' => array
                (
                'Token' => $TOKEN,
                'Sign' => $SIGN,
                'Cuit' => 20264678014
            ),
            'FeCAEReq' => array
                (
                'FeCabReq' => array
                    (
                    'CantReg' => 1,
                    'PtoVta' => 1,
                    'CbteTipo' => 6 //1 factura A - 6 factura B
                ),
                'FeDetReq' => array
                    (
                    'FECAEDetRequest' => array
                        (
                        'Concepto' => 1, // Productos y servicios
                        'DocTipo' => 96, //80 (CUIT) - 96 DNI
                        'DocNro' => 26467801,
                        'CbteDesde' => 2,
                        'CbteHasta' => 2,
                        'CbteFch' => date('Ymd'),
                        'ImpTotal' => round($imp_total, 2),
                        'ImpTotConc' => round($imp_total_conceptos, 2),
                        'ImpNeto' => round($imp_neto, 2),
                        'ImpOpEx' => round($imp_operaciones_exentas, 2),
                        'ImpTrib' => round($imp_trib, 2),
                        'ImpIVA' => $imp_iva,
                        'FchServDesde' => '',
                        'FchServHasta' => '',
                        'FchVtoPago' => '',
                        'MonId' => 'PES',
                        'MonCotiz' => 1,
                        'Tributos' => array(
                            'Tributo' => array(
                                'Id' => 99,
                                'Desc' => 'Impuesto municipal matanza',
                                'BaseImp' => 150,
                                'Alic' => 5.2,
                                'Importe' => 7.8
                            )
                        ),
                        'Iva' => array(
                            'AlicIva' => array(
                                'Id' => 5,
                                'BaseImp' => 125,
                                'Importe' => 26.25
                            )
                        )
                    )
                )
            )
        )
);

// los resultados los pongo en un archivo
file_put_contents(microtime(true) . '_results_AutRequest.txt', var_export($results_AutRequest, true));
file_put_contents(microtime(true) . '_results_AutRequest_soap.txt', var_export($client_wsfe, true));

?>