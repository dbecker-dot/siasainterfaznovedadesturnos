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

class WSFE extends SoapClient 
{
	private $scOpts = array(
		'soap_version'   => SOAP_1_2,
		'location'       => WSFE_URL,
		'trace'          => 1,
		'exceptions'     => true);

	private $Auth;
	private $Cuit;

	function __construct($Cuit, $WSAA) 
	{
		$this->Auth = $WSAA->getAuth(); 
		$this->Cuit = $Cuit;
				
		parent::SoapClient(WSFE_WSDL_URL, $this->scOpts);
	}

	function getEstadoServidores() 
	{
		$results = $this->FEDummy();
		return array('App' => $results->FEDummyResult->AppServer, 'DB' => $results->FEDummyResult->DbServer, 'Auth' => $results->FEDummyResult->AuthServer);
	}
	
	private function sendRequest($method, $options) 
	{
		$optArr['Auth'] = $this->Auth;
		$optArr['Auth']['Cuit'] = $this->Cuit;

		if (is_array($options))
			foreach ($options as $key => $value) 
				$optArr[$key] = $value;

		$results = $this->$method($optArr);

		return $results;
	}
	
	private function sendRequestParam($method) 
	{
		//$options = array('Cuit' => $this->Cuit);
		$results = $this->sendRequest($method, '');
		$resultMethod = $method.'Result';
		$vars = get_object_vars($results->$resultMethod);
		$keys = array_keys($vars);

		if ($keys[0] == 'Errors') 
		{
			$param = $results->$resultMethod->Errors;
		} 
		else 
		{
			$resultVars = get_object_vars($results->$resultMethod->ResultGet);
			$resultKeys = array_keys($resultVars);
			$param = $results->$resultMethod->ResultGet->$resultKeys[0];
		}
		
		return $param;
	}
	public function getUltCbte($poSale, $type) 
	{
		$options = array('PtoVta' => $poSale, 'CbteTipo'=>$type);
		$results = $this->sendRequest('FECompUltimoAutorizado',$options);

		return $results->FECompUltimoAutorizadoResult->CbteNro;
	}

	public function getTiposCbte() 
	{
		return $this->sendRequestParam('FEParamGetTiposCbte');
	}

	public function getTiposConcepto() 
	{
		return $this->sendRequestParam('FEParamGetTiposConcepto');
	}

	public function getTiposDoc() 
	{
		return $this->sendRequestParam('FEParamGetTiposDoc');
	}

	public function getTiposIva() 
	{
		return $this->sendRequestParam('FEParamGetTiposIva');
	}

	public function getTiposMonedas() 
	{
		return $this->sendRequestParam('FEParamGetTiposMonedas');
	}

	public function getTiposTributos() 
	{
		return $this->sendRequestParam('FEParamGetTiposTributos');
	}

	public function getPtosVenta() 
	{
		return $this->sendRequestParam('FEParamGetPtosVenta');
	}

	public function SolicitarCAE($request) 
	{
		$response = $this->sendRequest('FECAESolicitar', $request);
		$ptoVta = $response->FECAESolicitarResult->FeCabResp->PtoVta;
		$cbteTipo = $response->FECAESolicitarResult->FeCabResp->CbteTipo;

		foreach ($response->FECAESolicitarResult->FeDetResp as $detalle) 
		{
			$datosCAE = array('CbteNro' => $detalle->CbteDesde, 'CAE' => $detalle->CAE, 'FechaVto' => $detalle->CAEFchVto);
		}
		
		return $datosCAE;
	}

	function CallWSAA($WS)
	{
  		# Now we create a context to specify remote web server certificate checking
		# If you don want to check remote server, you may set verify_peer to FALSE.

		$ctx = stream_context_create( array('ssl'=>array(
    			'capath'            => "",
    			'localcert'         => CERT,
    			'passphrase'        => "",
     			#'CN_match'          => REMCN,
     			#'cafile'            => CERT,
     			#'allow_self_signed' => REMSELFSIGN,
     			'verify_peer'       => REMVERIFY)));

  		$client=new SoapClient(WSDL, array(
          		'proxy_host'     => "proxy",
          		'proxy_port'     => 80,
          		'stream_context' => $ctx,
          		'soap_version'   => SOAP_1_2,
          		'location'       => WSAA_WSDL_URL,
          		'exceptions'     => 0)); 

  		$results = $client->loginCms(array('in0'=>$WS));

  		if (is_soap_fault($results)) 
    		{
			exit("SOAP Fault: ".$results->faultcode."\n".$results->faultstring."\n");
		}

  		return $results->loginCmsReturn;
	}
}
?>