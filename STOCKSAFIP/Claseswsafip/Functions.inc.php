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

function printSelectParam($param) {
	if (isset($param->Err))
		$output = "Error: ".$param->Err->Msg."<br/>\n";
	else 
	{
		if (count($param) == 1)
		{
			echo "<select><option value='PES'>Pesos Argentinos</option></select><br>";
		}
		else
		{
			$output = "<select>\n";

			foreach ($param as $val)
			{
				$id = (string) $val->Id;
				$valor = (string) $val->Desc;

				$output .= "<option value=" . $id . ">" . $valor . "</option>\n";
			}

			$output .= "</select>\n";
			$output .= "<br/>\n";

			echo $output;
		}
	}
}
?>