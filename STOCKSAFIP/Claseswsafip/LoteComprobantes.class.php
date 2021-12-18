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

class LoteComprobantes {

	/* Cabecera */
	protected $cantReg;
	protected $cbteTipo;
	protected $comprobantes = array();

	/* Detalle */
	protected $impTotal; /* Se calcula? */
	protected $impNoGravado;
	protected $impNeto;
	protected $impExento;
	protected $impIva; /* Se calcula? */

	/* Objetos asociados */
	protected $cbtesAsoc;
	protected $tributos;
	protected $iva;

	public function __construct($ptoVenta) 
	{
		$this->ptoVenta = $ptoVenta;
	}

	public function addComprobante($comprobante) 
	{
		if ($this->cbteTipo != $comprobante->getTipo()) 
		{
			$this->cantReg = 0;
			$this->comprobantes = array();
		}

		$this->cbteTipo = $comprobante->getTipo();
		$this->cantReg++;
		$this->comprobantes[] = $comprobante;
	}

	public function getRequestCAE() 
	{
			$feCabReq = array('CantReg' => $this->cantReg, 'PtoVta' => $this->ptoVenta, 'CbteTipo' => $this->cbteTipo);

			for ($i = 0; $i < $this->cantReg; $i++) 
			{
				$feDetReq['FECAEDetRequest'][] = $this->comprobantes[$i]->getRequest();
			}

		$request['FeCAEReq'] = array( 'FeCabReq' => $feCabReq, 'FeDetReq' => $feDetReq);
		
		return $request;
	}
}

?>