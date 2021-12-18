<?php
/**
 *
 * Copyright (C) 2011 Facundo Ameal
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

require_once('config.inc.php');

class WSAA extends SoapClient {
	private $scOpts = array(
		'soap_version'   => SOAP_1_2,
		'location'       => WSAA_URL,
		'trace'          => 1,
		'exceptions'     => true
	);
	
	private $signedTRA;
	private $Service;
	private $Token;
	private $Sign;

	public function __construct($service) {
		parent::SoapClient(WSAA_WSDL_URL, $this->scOpts);
		$this->Service = $service;
                echo $this->Service;
	}
	
	private function createTRA() {
		$TRA = new SimpleXMLElement(
			'<?xml version="1.0" encoding="UTF-8"?>' .
			'<loginTicketRequest version="1.0">'.
			'</loginTicketRequest>');
		$TRA->addChild('header');
		$TRA->header->addChild('uniqueId',date('U'));
		$TRA->header->addChild('generationTime',date('c',date('U')-120));
		$TRA->header->addChild('expirationTime',date('c',date('U')+120));
		$TRA->addChild('service', $this->Service);
		$TRA->asXML('TRA.xml');

	}
	
	private function signTRA() {
            $pathcert=realpath('.') . '/Certificados/' . PRIV_KEY;
            if (realpath($pathcert)){
                echo 'ok';
            } else {
                echo 'Error'.$pathcert;
            }
            $STATUS = openssl_pkcs7_sign(realpath('.') . '/' . "TRA.xml", realpath('.') . '/' . "TRA.tmp", "file://" . realpath('.') . '/Certificados/' . CERT,
    			array("file://" . realpath('.') . '/Certificados/' . PRIV_KEY, PASSPHRASE),
    			array(),
    			!PKCS7_DETACHED);
		echo realpath(CERT);
		if (!$STATUS) exit("ERROR generating PKCS#7 signature\n");
		
		$inf=fopen("TRA.tmp", "r");
		$i=0;
		$CMS="";
		
		while (!feof($inf)) {
			$buffer=fgets($inf);
		
      		if ( $i++ >= 4 ) $CMS.=$buffer;
		}
		
		fclose($inf);
		unlink("TRA.tmp");
		unlink("TRA.xml");

		$this->signedTRA = $CMS;
	}
	
	private function callWSAA() {
		$respFile = 'TA.xml';

		// Si existe el archivo con la respuesta, tomar los datos para evaluar validez
		if( file_exists($respFile) ) {
			$xmlResponse = simplexml_load_file($respFile);
			$respDate = $xmlResponse->header->expirationTime;
			$pattern = "/(\d{4}-\d{2}-\d{2})T(\d{2}:\d{2}:\d{2}\.\d{3})(.*)/";
			preg_match($pattern,$respDate,$arrExpDate);
			$expDate = $arrExpDate[1].' '.$arrExpDate[2].' '.$arrExpDate[3];
			$strExpDate = strtotime($expDate);

			$now = date('Y-m-d H:i:s P');
			$strNow = strtotime($now);
		}
		
		// Si el ticket expiro, generarlo nuevamente
		if ( (! isset($strExpDate)) || (! isset($strNow)) || ($strNow > $strExpDate) ) {

			$results = $this->loginCms(array('in0'=>$this->signedTRA));
			file_put_contents($respFile, $results->loginCmsReturn);
			$xmlResponse = new SimpleXMLElement($results->loginCmsReturn);

			if (is_soap_fault($results)) {
				return ("SOAP Fault: ".$results->faultcode."\n".$results->faultstring."\n");
			}
		
		} else {
			echo "Usando ticket previo<br/>";
		}

		$this->Token = $xmlResponse->credentials->token;
		$this->Sign = $xmlResponse->credentials->sign;
		
		return 0;
	}

	public function getAuth() {
		$this->createTRA();
		$this->signTRA();
		$this->callWSAA();

		return array('Token' => $this->Token, 'Sign' => $this->Sign);
	}

}
?>