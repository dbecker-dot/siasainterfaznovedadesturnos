<?php
/**
 *
 * Copyright (C) 2021 Diego Becker
 *
 * This file is part of phacturaE.
 *
 * phacturaE is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by 
 * the Free Software Foundation, either version 3 of the License, or (at
 * your option) any later version.
 *
 * phacturaE is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with phacturaE. If not, see http://www.gnu.org/licenses/.
 *
 **/

// Datos de conexion a base de datos SQL
// SIASA ;

define('SERVIDOR', 'http://localhost/siasapp');
//define('DB_HOST', '192.168.1.100');
//define('DB_USUARIO', 'siasa');
//define('DB_PASSWORD', 's14s4_2021');
//define('DB_BD', 'SIASA');

define('DB_HOST', 'ZA-TLP-WST092N\SQLEXPRESS');
define('DB_USUARIO', 'siasa');
define('DB_PASSWORD', 's14s4_2021');
define('DB_BD', 'SIASA');

// Server status: "dev" | "prod" --> Develop | Produccion
// $STATUS = "dev";
$STATUS = "prod";

// Certificates path
$CERT_DEV = "CERTSIASA_13bc755aaf8903dc.crt";
$PRIV_KEY_DEV = "ClavePrivadaSIASA.key";

// WSAA URLs
$WSAA_PROD = "https://wsaa.afip.gov.ar/ws/services/LoginCms";
$WSAA_DEV  = "https://wsaahomo.afip.gov.ar/ws/services/LoginCms";

// WSFE URLs
$WSFE_PROD ="https://servicios1.afip.gov.ar/wsfev1/service.asmx";
$WSFE_DEV = "https://wswhomo.afip.gov.ar/wsfev1/service.asmx";

// WSDL addresses
$WSFE_WSDL_PROD = "https://servicios1.afip.gov.ar/wsfev1/service.asmx?WSDL";
$WSFE_WSDL_DEV  = "https://wswhomo.afip.gov.ar/wsfev1/service.asmx?WSDL";

$WSAA_WSDL_PROD = "https://wsaa.afip.gov.ar/ws/services/LoginCms?WSDL";
$WSAA_WSDL_DEV  = "https://wsaahomo.afip.gov.ar/ws/services/LoginCms?WSDL";

// Taken from WSDL
$SOAP_ACTION = "http://ar.gov.afip.dif.facturaelectronica/";

/***********Ruta datos Token******************/

define ("TA", SERVIDOR.'/STOCKSAFIP/loginCms.xml');
define ("WService", "wgesStockDepositosFiscales");
define('RUTA_CSS', SERVIDOR.'/assets/css');
define('RUTA_IMG', SERVIDOR.'/assets/img');
define('RUTA_JS', SERVIDOR.'/assets/js');
/******** END CONFIG ********/
/**** DO NOT TOUCH BELOW ****/

# The following constants are related to remote web server verification
# If REMVERIFY is FALSE, then the other three constants don't matter.
define ("REMVERIFY", FALSE); # If FALSE, no remote Web Server verification done
define ("REMSELFSIGN",FALSE); # Do we accept self-signed certificates?

if ($STATUS == "prod") 
{
	define('WSAA_WSDL_URL', $WSAA_WSDL_PROD);
	define('WSFE_WSDL_URL', $WSFE_WSDL_PROD);
	define('WSFE_URL', $WSFE_PROD);
	define('WSAA_URL', $WSAA_PROD);
	define('PRIV_KEY', $PRIV_KEY_DEV);
	define('CERT', $CERT_DEV);
	define('PASSPHRASE', '');
} 
else 
{
	define('WSAA_WSDL_URL', $WSAA_WSDL_DEV);
	define('WSFE_WSDL_URL', $WSFE_WSDL_DEV);
	define('WSAA_URL', $WSAA_DEV);
	define('WSFE_URL', $WSFE_DEV);
	define('PRIV_KEY', $PRIV_KEY_DEV);
	define('CERT', $CERT_DEV);
	define('PASSPHRASE', '');
}
 echo '<div class="alert alert-success">
                <strong>Config loaded</strong>
              </div><br/>';
?>