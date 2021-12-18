<!doctype html>

<?php
$CUIT = 20165420501;
$tipo = 1;

//ini_set('display_errors', true);

include_once('Claseswsafip/WSAA.class.php');
include_once('Claseswsafip/WSFE.class.php');
include_once('Claseswsafip/Concepto.class.php');
include_once('Claseswsafip/Comprobante.class.php');
include_once('Claseswsafip/LoteComprobantes.class.php');
include_once('Claseswsafip/Functions.inc.php');

$ptoVta= 1;
$WSAA = new WSAA('wgesstockdepositosfiscales');
$WSAA->getAuth();
exit();
$WSFE = new WSFE($CUIT, $WSAA);

$estadoServidores = $WSFE->getEstadoServidores();
foreach ($estadoServidores as $nombre => $estado)
	echo "$nombre: $estado <br/>";

/* Consulta todos los parametros */
$tiposCbte = $WSFE->getTiposCbte();
printSelectParam($tiposCbte);

$tiposConcepto = $WSFE->getTiposConcepto();
printSelectParam($tiposConcepto);

$tiposDoc= $WSFE->getTiposDoc();
printSelectParam($tiposDoc);

$tiposIva= $WSFE->getTiposIva();
printSelectParam($tiposIva);

$tiposMonedas= $WSFE->getTiposMonedas();
printSelectParam($tiposMonedas);

$tiposTributos= $WSFE->getTiposTributos();
printSelectParam($tiposTributos);

$ptosVenta= $WSFE->getPtosVenta();
printSelectParam($ptosVenta);

if ($tipo = 1)
{
/************************ 
 *
 * Factura A
 *
 ************************/ 

echo '<h1>EJEMPLO Factura A</h1>';

$cbteTipo = 1; //Factura A

/* Muestra informacion del ultimo comprobante */
$ultCbte = $WSFE->getUltCbte($ptoVta, $cbteTipo);
$proxCbte = $ultCbte + 1;
echo "Anterior: ".$ultCbte."<br/>";
echo "Actual:   ".$proxCbte."<br/>";

/* Crea una factura A - Param --> $cbteNro, $cbteTipo, $ptoVta, $docTipo, $docNro, $fecha, $monId, $monCotizacion, $srvDesde = '', $srvHasta = '', $vtoPago = ''*/
$facturaA = new Comprobante($proxCbte, $cbteTipo, $ptoVta, 80, $CUIT, 20150808, 'PES', 1, '20150801', '20150830', 20150901);

/* Crea dos conceptos (un producto y un servicio) */
// Parametros $conceptoTipo = 1, $impNeto = 0, $impNoGravado = 0, $impExento = 0, $impIva = 0, $tipoIva = 3
$producto0 = new Concepto(1, 2.5, 0, 0, 21, 5);
$servicio0 = new Concepto(2, 1.5, 0, 0, 21, 5);

/* Agrega conceptos a la factura */
$facturaA->addConcepto($producto0);
$facturaA->addConcepto($servicio0);

/* Muestra el total de los distintos importes de la factura */
echo "Total Neto Factura A: ".$facturaA->getTotalNeto().'<br/>';
echo "Total No Gravado Factura A: ".$facturaA->getTotalNoGravado().'<br/>';
echo "Total Exento Factura A: ".$facturaA->getTotalExento().'<br/>';
echo "Total IVA Factura A: ".$facturaA->getTotalIva().'<br/>';
echo "<b>Total Factura A: ".$facturaA->getTotal().'</b><br/>';

/* Crea un lote de comprobantes */
$loteA = new LoteComprobantes($ptoVta);
$loteA->addComprobante($facturaA);

/* Genera el request y lo envia al web service de Factura Electronica */
$reqLote = $loteA->getRequestCAE();
$resCAE = $WSFE->SolicitarCAE($reqLote);
echo 'CAE: "'.$resCAE['CAE'].'"<br/>';
echo 'Fecha Vto. CAE: "'.$resCAE['FechaVto'].'"<br/>';
}
else
{
echo "<br/> <br/>";

/************************ 
 *
 * Factura B
 *
 ************************/ 
echo '<h1>EJEMPLO Factura B</h1>';

/* Muestra informacion del ultimo comprobante */
$cbteTipo = 4; // Factura B
$ultCbte = $WSFE->getUltCbte($ptoVta, $cbteTipo);
$proxCbte = $ultCbte + 1;
echo "Anterior: ".$ultCbte."<br/>";
echo "Actual:   ".$proxCbte."<br/>";


$facturaB = new Comprobante($proxCbte, $cbteTipo, $ptoVta, 80, 20111111115, 20110808, 'PES', 1, 20110808, 20110812, 20110808);

/* Crea dos conceptos (productos) */
$producto1 = new Concepto(1, 100, 10, 0, 21, 5);
$producto2 = new Concepto(1, 200, 5, 0, 21, 4);

/* Agrega conceptos a la factura */
$facturaB->addConcepto($producto1);
$facturaB->addConcepto($producto2);

/* Muestra el total de los distintos importes de la factura */
echo "Total Neto Factura B: ".$facturaB->getTotalNeto().'<br/>';
echo "Total No Gravado Factura B: ".$facturaB->getTotalNoGravado().'<br/>';
echo "Total Exento Factura B: ".$facturaB->getTotalExento().'<br/>';
echo "Total IVA Factura B: ".$facturaB->getTotalIva().'<br/>';
echo "<b>Total Factura B: ".$facturaB->getTotal().'</b><br/>';

/* Crea un lote de comprobantes */
$loteB = new LoteComprobantes($ptoVta);
$loteB->addComprobante($facturaB);

/* Genera el request y lo envia al web service de Factura Electronica */
$reqLote = $loteB->getRequestCAE();
$resCAE = $WSFE->solicitarCAE($reqLote);
echo 'CAE: '.$resCAE['CAE'].'<br/>';
echo 'Fecha Vto. CAE: '.$resCAE['FechaVto'].'<br/>';
}
?>