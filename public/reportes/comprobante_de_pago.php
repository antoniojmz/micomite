<?php
//============================================================+
// File name   : example_001.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 001 for TCPDF class
//               Default Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Default Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('../TCPDF-master/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Ana Zambrano');
$pdf->SetTitle('Comprobante de Electrónico de Transacciones');
//$pdf->SetSubject('TCPDF Tutorial');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
//$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
  require_once(dirname(__FILE__).'/lang/eng.php');
  $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
//$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();
$propietario       = $_POST['propietario'];
$estatus_pago       = $_POST['estatus_pago'];
$codigo_verificacion       = $_POST['codigo_verificacion'];
$fecha_pago  = $_POST['fecha_pago'];
$fecha_registro = $_POST['fecha_registro'];
$monto = $_POST['monto'];
$numero = $_POST['numero'];
$id_pago_propietario =  $_POST['id_pago_propietario'];
// set text shadow effect
//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
$html ='
<style type="text/css">
.tg  {border-spacing:0px; border-style:solid;}
.tg td{font-family:Arial, sans-serif;font-size:12px;padding:10px 10px;border-style:solid;border-width:1px;word-break:normal;  }
.tg th{font-family:Arial, sans-serif;font-size:12px;font-weight:normal;padding:10px 10px;border-style:solid;border-width:1px;word-break:normal;}
.tg .tg-s6z2{text-align:center}
.tg .tg-lqy6{text-align:right;vertical-align:top}
.tg .tg-hgcj{font-weight:bold;text-align:center}
.tg .tg-b1r0{font-size:16px;font-family:Verdana, Geneva, sans-serif !important;;background-color:#c0c0c0;color:#000000;text-align:center}
.tg .tg-l2oz{font-weight:bold;text-align:right;vertical-align:top}
.tg .tg-yw4l{vertical-align:top}
.icons {
width: 170px;
height: 150px;
border-radius: 150px;
border: 5px solid #999999;
}

@media screen and (max-width: 767px) {.tg {width: auto !important;}.tg col {width: auto !important;}.tg-wrap {overflow-x: auto;-webkit-overflow-scrolling: touch;}}
</style>

<div class="tg-wrap">

<table class="tg" style="table-layout: fixed; width: 100%" border="1">
<colgroup>
<col style="width: 100%">
<col style="width: 100%">
</colgroup>

  <tr>
    <td class="tg-hgcj"><br><h1>Recibo # '.$id_pago_propietario.'</h1><br><h3>Nombre del Condominio</h3><br>Fecha: '.date("d/m/Y").'</td>
    <td class="tg-031e"  style="text-align:center;"><br><br><img src="../img/logo_comite.png" class="icons"><br></td>
  </tr>

  <tr>
    <td class="tg-b1r0" colspan="2">Comprobante de Transacción</td>
  </tr>
  <tr>
    <td class="tg-l2oz">ESTATUS DE LA TRANSACCIÓN</td>
    <td class="tg-yw4l">'.$estatus_pago.'</td>
  </tr>
  <tr>
    <td class="tg-l2oz">DATOS DEL PROPIETARIO</td>
    <td class="tg-yw4l">'.$propietario.'</td>
  </tr>
  <tr>
    <td class="tg-l2oz">NÚMERO DE APARTAMENTO</td>
    <td class="tg-yw4l">'.$numero.'</td>
  </tr>
  <tr>
    <td class="tg-l2oz">FECHA DE REGISTRO</td>
    <td class="tg-yw4l">'.$fecha_registro.'</td>
  </tr>
  <tr>
    <td class="tg-l2oz">NUMERO DE REFERENCIA</td>
    <td class="tg-yw4l">'.$numero.'</td>
  </tr>
  <tr>
    <td class="tg-l2oz">MÉTODO DE PAGO</td>
    <td class="tg-yw4l">'.$numero.'</td>
  </tr>
  <tr>
    <td class="tg-l2oz">MONTO</td>
    <td class="tg-yw4l">'.$monto.'</td>
  </tr>
  <tr>
    <td class="tg-l2oz">FECHA DE PAGO</td>
    <td class="tg-yw4l">'.$fecha_pago.'</td>
  </tr>
  <tr>
    <td class="tg-lqy6" colspan="2"></td>
  </tr>
</table></div>
';

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
