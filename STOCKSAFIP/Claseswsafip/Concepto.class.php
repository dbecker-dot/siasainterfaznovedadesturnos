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

class Concepto {
	protected $conceptoTipo;
	protected $impNeto;
	protected $impNoGravado;
	protected $impExento;
	protected $impIva;
	protected $tipoIva;

	public function __construct($conceptoTipo = 1, $impNeto = 0, $impNoGravado = 0, $impExento = 0, $impIva = 0, $tipoIva = 3) {
		$this->set($conceptoTipo, $impNeto, $impNoGravado, $impExento, $impIva, $tipoIva);
	}

	public function set($conceptoTipo, $impNeto, $impNoGravado, $impExento, $impIva, $tipoIva) {
		$this->conceptoTipo = $conceptoTipo;
		$this->impNeto = $impNeto;
		$this->impNoGravado = $impNoGravado;
		$this->impIva = $impIva;
		$this->tipoIva = $tipoIva;
	}
	public function getTipo() {
		return $this->conceptoTipo;
	}

	public function getTotal() {
		$total = $this->impNeto + $this->impNoGravado + $this->impExento + $this->impIva;
		return $total;
	}

	public function getImpNeto() {
		return $this->impNeto;
	}

	public function getImpIva() {
		return $this->impIva;
	}

	public function getTipoIva() {
		return $this->tipoIva;
	}

	public function sumarImporte($arrConceptos, $tipoImp) {
		$total = 0;
		foreach ($arrConceptos as $concepto)
			$total += $concepto->$tipoImp;

		return $total;
	}
}

?>