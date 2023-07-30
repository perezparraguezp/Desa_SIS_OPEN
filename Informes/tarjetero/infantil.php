<?php

include("../../php/config.php");
require_once('../config/lang/cat.php');
require_once('../tcpdf.php');

include '../../php/objetos/persona.php';
include '../../php/objetos/establecimiento.php';
session_start();
error_reporting(0);

$id_establecimiento = $_SESSION['id_establecimiento'];
$rut = $_GET['rut'];
$p = new persona($rut);
$e = new establecimiento($id_establecimiento);




// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'iso-8859-1', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Eh-Open -Sistema Integral de Salud Infantil (SIS INFANTIL) ');
$pdf->SetTitle('Tarjetero Infantil');
$pdf->SetSubject('Tarjetero Infantil');

$p->psicomotor();;

$info_centro_medico = '<table style="border: solid 1px black;" border="1px">
        <tr>
            <td style="width: 20%;background-color: #cffcff;">CENTRO MEDICO</td>
            <td style="width: 80%;font-weight: bold;;">'.$p->getCentroMedico().'</td>
        </tr>
</table>';


$pagina2 = '<table border="1px" style="border: solid 1px black;">
                <tr style="background-color: #cffcff;width: 100%;">
                    <td colspan="4" style="text-align: center;font-weight: bold;">TARJETERO INFANIL</td>
                </tr>
                <tr>
                    <td style="width: 20%;background-color: #cffcff;">RUT</td>
                    <td style="width: 30%;font-weight: bold;">'.strtoupper($p->rut).'</td>
                    <td style="width: 20%;background-color: #cffcff;">NACIMIENTO</td>
                    <td style="width: 30%;font-weight: bold;">'.fechaNormal($p->fecha_nacimiento).'</td>
                </tr>
                <tr>
                    <td colspan="2" style="background-color: #cffcff;">NOMBRE</td>
                    <td style="background-color: #cffcff;">EDAD</td>
                    <td style="font-weight: bold;">'.strtoupper($p->edad_anios).' años</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;" colspan="4">'.strtoupper($p->nombre).'</td>
                </tr>
                <tr>
                    <td style="width: 20%;background-color: #cffcff;">DIRECCIÓN</td>
                    <td style="width: 80%;font-weight: bold;">'.strtoupper($p->direccion).'</td>
                </tr>
                <tr>
                    <td style="width: 20%;background-color: #cffcff;">TELÉFONO</td>
                    <td style="width: 80%;font-weight: bold;">'.strtoupper($p->telefono).'</td>
                </tr>
                <tr>
                    <td style="width: 20%;background-color: #cffcff;">E-MAIL</td>
                    <td style="width: 80%;font-weight: bold;">'.strtoupper($p->email).'</td>
                </tr>
                <tr>
                    <td style="width: 20%;background-color: #cffcff;">SECTOR</td>
                    <td style="width: 80%;font-weight: bold;">'.strtoupper($p->nombre_sector_comunal).'</td>
                </tr>
                <tr>
                    <td style="width: 20%;background-color: #cffcff;">CENTRO MEDICO</td>
                    <td style="width: 80%;font-weight: bold;">'.strtoupper($p->nombre_centro_medico).'</td>
                </tr>
                <tr>
                    <td style="width: 20%;background-color: #cffcff;">SECTOR INTERNO</td>
                    <td style="width: 80%;font-weight: bold;">'.strtoupper($p->nombre_sector_interno).'</td>
                </tr>
                <tr style="background-color: #cffcff;">
                    <td style="text-align: center;font-weight: bold;width: 100%;">DATOS DE NACIMIENTO</td>
                </tr>
                <tr>
                    <td style="width: 25%;background-color: #cffcff;">EOA</td>
                    <td style="width: 25%;font-weight: bold;">'.strtoupper($p->getDatosNacimiento('EOA')).'</td>
                    <td style="width: 25%;background-color: #cffcff;">PKU</td>
                    <td style="width: 25%;font-weight: bold;">'.strtoupper($p->getDatosNacimiento('PKU')).'</td>
                </tr>
                <tr>
                    <td style="width: 25%;background-color: #cffcff;">HC</td>
                    <td style="width: 25%;font-weight: bold;">'.strtoupper($p->getDatosNacimiento('HC')).'</td>
                    <td style="width: 25%;background-color: #cffcff;">APEGO INMEDIATO</td>
                    <td style="width: 25%;font-weight: bold;">'.strtoupper($p->getDatosNacimiento('APEGO_INMEDIATO')).'</td>
                </tr>
                <tr>
                    <td style="width: 25%;background-color: #cffcff;">VACUNA BCG</td>
                    <td style="width: 25%;font-weight: bold;">'.strtoupper($p->getDatosNacimiento('VACUNA_BCG')).'</td>
                    <td style="width: 25%;background-color: #cffcff;">VACUNA HEPATITIS B</td>
                    <td style="width: 25%;font-weight: bold;">'.strtoupper($p->getDatosNacimiento('VACUNA_HP')).'</td>
                </tr>
                <tr style="background-color: #cffcff;">
                    <td colspan="4" style="text-align: center;font-weight: bold;">REGISTRO DE VACUNAS</td>
                </tr>
                <tr>
                    <td style="width: 25%;background-color: #cffcff;">2 MESES</td>
                    <td style="width: 25%;font-weight: bold;">'.strtoupper($p->vacuna2M()).'</td>
                    <td style="width: 25%;background-color: #cffcff;">4 MESES</td>
                    <td style="width: 25%;font-weight: bold;">'.strtoupper($p->vacuna4M()).'</td>
                </tr>
                <tr>
                    <td style="width: 25%;background-color: #cffcff;">6 MESES</td>
                    <td style="width: 25%;font-weight: bold;">'.strtoupper($p->vacuna6M()).'</td>
                    <td style="width: 25%;background-color: #cffcff;">12 MESES</td>
                    <td style="width: 25%;font-weight: bold;">'.strtoupper($p->vacuna12M()).'</td>
                </tr>
                <tr>
                    <td style="width: 25%;background-color: #cffcff;">18 MESES</td>
                    <td style="width: 25%;font-weight: bold;">'.strtoupper($p->vacuna18M()).'</td>
                    <td style="width: 25%;background-color: #cffcff;">5 AÑOS</td>
                    <td style="width: 25%;font-weight: bold;">'.strtoupper($p->vacuna5Anios()).'</td>
                </tr>
                <tr style="background-color: #cffcff;">
                    <td style="text-align: center;font-weight: bold;width: 100%;">ANTROPOMETRIA</td>
                </tr>
                <tr>
                    <td style="width: 16%;background-color: #cffcff;">PE</td>
                    <td style="width: 16%;font-weight: bold;">'.strtoupper($p->getAntropometria('PE')).'</td>
                    <td style="width: 16%;background-color: #cffcff;">TE</td>
                    <td style="width: 16%;font-weight: bold;">'.strtoupper($p->getAntropometria('TE')).'</td>
                    <td style="width: 16%;background-color: #cffcff;">PT</td>
                    <td style="width: 20%;font-weight: bold;">'.strtoupper($p->getAntropometria('PT')).'</td>
                    
                </tr>
                <tr>
                    <td style="width: 16%;background-color: #cffcff;">LME</td>
                    <td style="width: 16%;font-weight: bold;">'.strtoupper($p->getAntropometria('LME')).'</td>
                    <td style="width: 16%;background-color: #cffcff;">Ri MALN</td>
                    <td style="width: 16%;font-weight: bold;">'.strtoupper($p->getAntropometria('RIMALN')).'</td>
                    <td style="width: 16%;background-color: #cffcff;">PERIMETRO CRANEAL</td>
                    <td style="width: 20%;font-weight: bold;">'.strtoupper($p->getAntropometria('perimetro_craneal')).'</td>
                    
                </tr>
                <tr>
                    <td style="width: 16%;background-color: #cffcff;">PCINT</td>
                    <td style="width: 16%;font-weight: bold;">'.strtoupper($p->getAntropometria('PCINT')).'</td>
                    <td style="width: 16%;background-color: #cffcff;">IMC</td>
                    <td style="width: 16%;font-weight: bold;">'.strtoupper($p->getAntropometria('IMC')).'</td>
                    <td style="width: 16%;background-color: #cffcff;">DNI</td>
                    <td style="width: 20%;font-weight: bold;">'.strtoupper($p->getAntropometria('DNI')).'</td>
                   
                </tr>
                 <tr>
                    <td style="width: 16%;background-color: #cffcff;">PRESION ARTERIAL</td>
                    <td style="width: 16%;font-weight: bold;">'.strtoupper($p->getAntropometria('presion_arterial')).'</td>
                    <td style="width: 16%;background-color: #cffcff;">AGUDEZA VISUAL</td>
                    <td style="width: 16%;font-weight: bold;">'.strtoupper($p->getAntropometria('agudeza_visual')).'</td>
                    <td style="width: 16%;background-color: #cffcff;">EVAL. AUDITIVA</td>
                    <td style="width: 20%;font-weight: bold;">'.strtoupper($p->getAntropometria('evaluacion_auditiva')).'</td>
                </tr>
                <tr style="background-color: #cffcff;">
                    <td style="text-align: center;font-weight: bold;width: 100%;">DESARROLLO PSICOMOTOR</td>
                </tr>
                 <tr>
                    <td style="width: 25%;background-color: #cffcff;">EV NEUROSENSORIAL</td>
                    <td style="width: 25%;font-weight: bold;">'.strtoupper($p->ev_neurosensorial).'</td>
                    <td style="width: 25%;background-color: #cffcff;">RX PELVIS</td>
                    <td style="width: 25%;font-weight: bold;">'.strtoupper($p->rx_pelvis).'</td>
                </tr>
                <tr>
                    <td style="width: 25%;background-color: #cffcff;">PAUTA BREVE</td>
                    <td style="width: 25%;font-weight: bold;">'.strtoupper($p->getPsicomotor('pauta_breve')).'</td>
                    <td style="width: 25%;background-color: #cffcff;">OTRA VULNERABILIDAD</td>
                    <td style="width: 25%;font-weight: bold;">'.strtoupper($p->getPsicomotor('otra_vulnerabilidad')).'</td>
                </tr>
                <tr>
                    <td style="width: 25%;background-color: #cffcff;">EEDP</td>
                    <td style="width: 25%;font-weight: bold;">'.strtoupper($p->getPsicomotor('eedp')).'</td>
                    <td style="width: 25%;background-color: #cffcff;">TEPSI</td>
                    <td style="width: 25%;font-weight: bold;">'.strtoupper($p->getPsicomotor('tepsi')).'</td>
                </tr>
                <tr>
                    <td style="width: 25%;background-color: #cffcff;">EEDP LENGUAJE</td>
                    <td style="width: 25%;font-weight: bold;">'.strtoupper($p->getPsicomotor('eedp_lenguaje')).'</td>
                    <td style="width: 25%;background-color: #cffcff;">TEPSI LENGUAJE</td>
                    <td style="width: 25%;font-weight: bold;">'.strtoupper($p->getPsicomotor('tepsi_lenguaje')).'</td>
                </tr>
                <tr>
                    <td style="width: 25%;background-color: #cffcff;">EEDP MOTRICIDAD</td>
                    <td style="width: 25%;font-weight: bold;">'.strtoupper($p->getPsicomotor('eedp_motrocidad')).'</td>
                    <td style="width: 25%;background-color: #cffcff;">TEPSI MOTRICIDAD</td>
                    <td style="width: 25%;font-weight: bold;">'.strtoupper($p->getPsicomotor('tepsi_motrocidad')).'</td>
                </tr>
                <tr>
                    <td style="width: 25%;background-color: #cffcff;">EEDP COORDINACION</td>
                    <td style="width: 25%;font-weight: bold;">'.strtoupper($p->getPsicomotor('eedp_coordinacion')).'</td>
                    <td style="width: 25%;background-color: #cffcff;">TEPSI COORDINACION</td>
                    <td style="width: 25%;font-weight: bold;">'.strtoupper($p->getPsicomotor('tepsi_coordinacion')).'</td>
                </tr>
                <tr>
                    <td style="width: 25%;background-color: #cffcff;">EEDP SOCIAL</td>
                    <td style="width: 25%;font-weight: bold;">'.strtoupper($p->getPsicomotor('eedp_social')).'</td>
                    
                </tr>
            </table>';


$pagina2 = str_replace('PENDIENTE','',$pagina2);
$sql1 = "select fecha_registro,tipo_contrato,persona.nombre_completo from historial_paciente
inner join personal_establecimiento pe on historial_paciente.id_profesional = pe.id_profesional
inner join persona on pe.rut=persona.rut
where historial_paciente.rut='$p->rut'
and fecha_registro!=''
group by YEAR(fecha_registro),MONTH(fecha_registro),DAY(fecha_registro)
order by id_historial asc limit 30;";
$res1 = mysql_query($sql1);
$fila = '';
while($row1 = mysql_fetch_array($res1)){
    list($fecha,$hora) = explode(" ",$row1['fecha_registro']);
    $fila .= '<tr>
                <td STYLE="text-align: center">'.fechaNormal($fecha).'</td>
                <td>'.$row1['tipo_contrato'].'</td>
                <td>'.$row1['nombre_completo'].'</td>
            </tr>';
}
$pagina1 = '<table border="1px" style="border: solid 1px black;">
                <tr style="background-color: #cffcff;width: 100%;">
                    <td colspan="3" style="text-align: center;font-weight: bold;">HISTORIAL DE ATENCIONES</td>
                </tr>
                <tr style="background-color: #cffcff;width: 100%;">
                    <td colspan="1" style="text-align: center;font-weight: bold;width: 15%;">FECHA</td>
                    <td colspan="1" style="text-align: center;font-weight: bold;width: 30%;">PROFESIONAL</td>
                    <td colspan="1" style="text-align: center;font-weight: bold;width: 55%;">NOMBRE COMPLETO</td>
                </tr>'.$fila.'</table>';

$html ='<style type="text/css">
            table{
            font-size: 0.8em;;
            }
            table tr{
            line-height: 2em;;
            }
        </style>';
$html .= '<table style="width: 100%;">

            <tr>
                <td>'.$pagina1.'</td>
                <td>'.$pagina2.'</td>
            </tr>
        </table>
        ';

$title_pdf = $e->nombre;
$sub_title_pdf = $p->nombre_centro_medico;
// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title_pdf, $sub_title_pdf, array(0, 0, 0), array(0, 0, 0));
$pdf->setFooterData($tc = array(0, 0, 0), $lc = array(0, 0, 0));

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(2, 2, 0);
//$pdf->SetHeaderMargin(0);
//$pdf->SetFooterMargin(0);

//set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings


// ---------------------------------------------------------
// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 12, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
//$pdf->AddPage();
$pdf->AddPage('L', 'A4');
// set text shadow effect
//$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
// Set some content to print


// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);

// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('Tarjetero_'.$rut.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
