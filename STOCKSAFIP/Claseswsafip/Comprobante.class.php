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

class Comprobante 
{
	protected $conceptosTipo;
	protected $cbteTipo;
	protected $docTipo;
	protected $ptoVenta;
	protected $docNro;
	protected $cbteDesde;
	protected $cbteHasta;
	protected $cbteFecha;
	protected $monId;
	protected $monCotizacion;
	protected $srvDesde;
	protected $srvHasta;
	protected $vtoPago;
	protected $conceptos = array();

	public function __construct($cbteNro, $cbteTipo, $ptoVta, $docTipo, $docNro, $fecha, $monId, $monCotizacion, $srvDesde = '', $srvHasta = '', $vtoPago = '') 
	{
		$this->cbteTipo      = $cbteTipo;
		$this->docTipo       = $docTipo;
		$this->ptoVta        = $ptoVta;
		$this->docNro        = $docNro;
		$this->cbteDesde     = $cbteNro;
		$this->cbteHasta     = $cbteNro;
		$this->cbteFecha     = $fecha;
		$this->monId         = $monId;
		$this->monCotizacion = $monCotizacion;
		$this->srvDesde      = $srvDesde;
		$this->srvHasta      = $srvHasta;
		$this->vtoPago       = $vtoPago;
	}
	
	public function addConcepto($concepto) 
	{
		if (($this->conceptosTipo = 0) || ($this->conceptosTipo == $concepto->getTipo()))
			$this->conceptosTipo = $concepto->getTipo();
		else
			$this->conceptosTipo = 3;

		$this->conceptos[] = $concepto;
	}

	public function getTipo() 
	{
		return $this->cbteTipo;
	}

	public function getTotal() 
	{
		$total = 0;
		
		foreach ($this->conceptos as $concepto)
			$total += $concepto->getTotal();

		return $total;
	}

	public function getTotalNeto() 
	{
		return Concepto::sumarImporte($this->conceptos, 'impNeto');
	}

	public function getTotalNoGravado() 
	{
		return Concepto::sumarImporte($this->conceptos, 'impNoGravado');
	}

	public function getTotalExento() 
	{
		return Concepto::sumarImporte($this->conceptos, 'impExento');
	}

	public function getTotalTributos() 
	{
		return 0;
	}

	public function getTotalIva() 
	{
		return Concepto::sumarImporte($this->conceptos, 'impIva');
	}

	public function getRequest() 
	{
		$tiposIva = array();

		foreach( $this->conceptos as $concepto) 
		{
			if (!isset($tiposIva[$concepto->getTipoIva()]['BaseImp'])) 
				$tiposIva[$concepto->getTipoIva()]['BaseImp'] = 0;
			if (!isset($tiposIva[$concepto->getTipoIva()]['Importe'])) 
				$tiposIva[$concepto->getTipoIva()]['Importe'] = 0;

			$tiposIva[$concepto->getTipoIva()]['BaseImp'] += $concepto->getImpNeto();
			$tiposIva[$concepto->getTipoIva()]['Importe'] += $concepto->getImpIva();
		}
		
		foreach ($tiposIva as $tipoIva => $datos) 
		{
			$IVA['AlicIva'][] = array( 'Id' => $tipoIva, 'BaseImp' => $datos['BaseImp'], 'Importe' => $datos['Importe']);
		}

		$request = array('Concepto'     => $this->conceptosTipo,
				 'DocTipo'      => $this->docTipo,
				 'DocNro'       => $this->docNro,
				 'CbteDesde'    => $this->cbteDesde,
				 'CbteHasta'    => $this->cbteHasta,
				 'CbteFch'      => $this->cbteFecha,
				 'ImpTotal'     => $this->getTotal(),
				 'ImpTotConc' 	=> $this->getTotalNoGravado(),
				 'ImpNeto'      => $this->getTotalNeto(),
				 'ImpOpEx'      => $this->getTotalExento(),
				 'ImpIVA'       => $this->getTotalIva(),
				 'ImpTrib'      => $this->getTotalTributos(),
				 'FchServDesde' => $this->srvDesde,
				 'FchServHasta' => $this->srvHasta,
				 'FchVtoPago'   => $this->vtoPago,
				 'MonId'        => $this->monId,
				 'MonCotiz'     => $this->monCotizacion,
				 'Iva'          => $IVA);

		return $request;
	}
}
?>