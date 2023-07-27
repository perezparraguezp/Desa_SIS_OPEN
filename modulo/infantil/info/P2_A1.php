<?php
include "../../../php/config.php";
include '../../../php/objetos/mysql.php';

$mysql = new mysql($_SESSION['id_usuario']);

$sql_1 = "UPDATE persona set edad_total_dias=TIMESTAMPDIFF(DAY, fecha_nacimiento, current_date) 
            where fecha_update_dias!=CURRENT_DATE() ";


$id_establecimiento = $_SESSION['id_establecimiento'];

$id_centro = $_POST['id'];
if ($id_centro != '') {
    $filtro_centro = " and id_centro_interno='$id_centro' ";
    $sql0 = "select * from centros_internos 
                              WHERE id_centro_interno='$id_centro' limit 1";
    $row0 = mysql_fetch_array(mysql_query($sql0));
    $nombre_centro = $row0['nombre_centro_interno'];
} else {
    $nombre_centro = 'TODOS LOS CENTROS';
    $filtro_centro = '';
}

$sexo = [
    "persona.sexo='M' ",
    "persona.sexo='F' "
];
$rango_seccion_a1 = [
    'persona.edad_total_dias>=(60*30) and persona.edad_total_dias<(72*30)', //entre 60 meses a 71 meses
    'persona.edad_total_dias>=(30*12*6) and persona.edad_total_dias<(30*12*7)',//desde los 6 años y 11 MESES
    'persona.edad_total_dias>=(30*12*7) and persona.edad_total_dias<(30*12*8)',//desde los 7 años y 11 MESES
    'persona.edad_total_dias>=(30*12*8) and persona.edad_total_dias<(30*12*9)',//desde los 8 años y 11 MESES
    'persona.edad_total_dias>=(30*12*9) and persona.edad_total_dias<(30*12*10)',//desde los 9 años A 11 MESES

    "persona.edad_total_dias>=(60*30) and persona.edad_total_dias<(30*12*10) and persona.pueblo='SI'",//PUEBLOS ORIGINARIOS
    "persona.edad_total_dias>=(60*30) and persona.edad_total_dias<(30*12*10) and persona.migrante='SI'",//MIGRANTES
];
?>
<section id="seccion_a1" style="width: 100%;overflow-y: scroll;">
    <header>SECCION A.1: POBLACIÓN EN CONTROL, SEGÚN ESTADO NUTRICIONAL PARA NIÑOS DE 60 MESES-9 AÑOS 11 MESES
    </header>
    <table id="table_seccion_a1" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td colspan="2" rowspan="3">INDICADOR NUTRICIONAL Y PARÁMETROS DE MEDICIÓN</td>
            <td colspan="3" rowspan="2">TOTAL</td>
            <td colspan="10">GRUPOS DE EDAD (MESES Y AÑOS) Y SEXO</td>
        </tr>
        <tr>
            <td colspan="2">60 A 71 meses</td>
            <td colspan="2">6 AÑOS A 6 AÑOS Y 11 meses</td>
            <td colspan="2">7 AÑOS A 7 AÑOS Y 11 meses</td>
            <td colspan="2">8 AÑOS A 8 AÑOS Y 11 meses</td>
            <td colspan="2">9 AÑOS A 9 AÑOS Y 11 meses</td>
            <td colspan="2">PUEBLOS ORIGINARIOS</td>
            <td colspan="2">POBLACION MIGRANTES</td>
        </tr>
        <tr>
            <td>AMBOS SEXOS</td>
            <td>HOMBRES</td>
            <td>MUJERES</td>

            <td>HOMBRES</td>
            <td>MUJERES</td>
            <td>HOMBRES</td>
            <td>MUJERES</td>
            <td>HOMBRES</td>
            <td>MUJERES</td>
            <td>HOMBRES</td>
            <td>MUJERES</td>

            <td>HOMBRES</td>
            <td>MUJERES</td>

            <td>HOMBRES</td>
            <td>MUJERES</td>

            <td>HOMBRES</td>
            <td>MUJERES</td>
        </tr>
        <tr id="primera_a1" style="font-weight: bold;">
            <td colspan="2">TOTAL DE NIÑOS EN CONTROL</td>
        </tr>
        <tr>
            <td rowspan="9">INDICADOR IMC / EDAD</td>
            <td>+ 3 D.S. (>= 3 )</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'IMCE';
            $valor = '3';
            $IMCE[$valor]['MUJERES'] = 0;
            $IMCE[$valor]['HOMBRES'] = 0;
            $IMCE[$valor]['AMBOS'] = 0;

            $fila = '';
            foreach ($rango_seccion_a1 as $i => $rango) {

                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);

                $total_dni[$i]['HOMBRES'] += $total_hombres;
                $total_dni[$i]['MUJERES'] += $total_mujeres;

                if($i<=4){
                    $IMCE[$valor]['HOMBRES'] = $IMCE[$valor]['HOMBRES'] + $total_hombres;
                    $IMCE[$valor]['MUJERES'] = $IMCE[$valor]['MUJERES'] + $total_mujeres;
                    $IMCE[$valor]['AMBOS'] = $IMCE[$valor]['AMBOS'] + $total_mujeres + $total_hombres;
                }


                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $IMCE[$valor]['AMBOS'] ?></td>
            <td><?php echo $IMCE[$valor]['HOMBRES'] ?></td>
            <td><?php echo $IMCE[$valor]['MUJERES'] ?></td>
            <?php echo $fila; ?>
        </tr>
        <tr>
            <td>+ 2 D.S. (>= +2.0 a +2.9)</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'IMCE';
            $valor = '2';
            $IMCE[$valor]['MUJERES'] = 0;
            $IMCE[$valor]['HOMBRES'] = 0;
            $IMCE[$valor]['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a1 as $i => $rango) {
                $indicador = 'IMCE';
                $valor = '2';
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);
                $indicador = 'PT';
                $valor = '2';
                $total_hombres += $mysql->getTotal_infancia_pt($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro,'IMCE');
                $total_mujeres += $mysql->getTotal_infancia_pt($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro,'IMCE');
                $total_dni[$i]['HOMBRES'] += $total_hombres;
                $total_dni[$i]['MUJERES'] += $total_mujeres;

                $indicador = 'IMCE';

                if($i<=4){
                    $IMCE[$valor]['HOMBRES'] = $IMCE[$valor]['HOMBRES'] + $total_hombres;
                    $IMCE[$valor]['MUJERES'] = $IMCE[$valor]['MUJERES'] + $total_mujeres;
                    $IMCE[$valor]['AMBOS'] = $IMCE[$valor]['AMBOS'] + $total_mujeres + $total_hombres;
                }


                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $IMCE[$valor]['AMBOS'] ?></td>
            <td><?php echo $IMCE[$valor]['HOMBRES'] ?></td>
            <td><?php echo $IMCE[$valor]['MUJERES'] ?></td>
            <?php echo $fila; ?>

        </tr>
        <tr>
            <td>+ 2 D.S. (>= +2.0 a +2.9)</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'IMCE';
            $valor = '1';
            $IMCE[$valor]['MUJERES'] = 0;
            $IMCE[$valor]['HOMBRES'] = 0;
            $IMCE[$valor]['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a1 as $i => $rango) {
                $indicador = 'IMCE';
                $valor = '1';
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);

                $indicador = 'PT';
                $valor = '1';
                $total_hombres += $mysql->getTotal_infancia_pt($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro,'IMCE');
                $total_mujeres += $mysql->getTotal_infancia_pt($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro,'IMCE');

                $indicador = 'IMCE';
                $total_dni[$i]['HOMBRES'] += $total_hombres;
                $total_dni[$i]['MUJERES'] += $total_mujeres;

                if($i<=4){
                    $IMCE[$valor]['HOMBRES'] = $IMCE[$valor]['HOMBRES'] + $total_hombres;
                    $IMCE[$valor]['MUJERES'] = $IMCE[$valor]['MUJERES'] + $total_mujeres;
                    $IMCE[$valor]['AMBOS'] = $IMCE[$valor]['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $IMCE[$valor]['AMBOS'] ?></td>
            <td><?php echo $IMCE[$valor]['HOMBRES'] ?></td>
            <td><?php echo $IMCE[$valor]['MUJERES'] ?></td>
            <?php echo $fila; ?>

        </tr>
        <tr style="font-weight: bold;background-color: #d7efff;">
            <td>TOTAL</td>
            <?php
            $fila = '';

            foreach ($rango_seccion_a1 as $i => $rango) {
                $total_hombres = $total_dni[$i]['HOMBRES'];
                $total_mujeres = $total_dni[$i]['MUJERES'];

                if($i<=4){
                    $IMCE['HOMBRES'] = $IMCE['HOMBRES'] + $total_hombres;
                    $IMCE['MUJERES'] = $IMCE['MUJERES'] + $total_mujeres;
                    $IMCE['AMBOS'] = $IMCE['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer


            }
            ?>
            <td><?php echo $IMCE['AMBOS'] ?></td>
            <td><?php echo $IMCE['HOMBRES'] ?></td>
            <td><?php echo $IMCE['MUJERES'] ?></td>
            <?php echo $fila; ?>

        </tr>
        <tr>
            <td>- 1 D.S. (<= -1.0 a -1.9)</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'IMCE';
            $valor = '-1';
            $IMCE[$valor]['MUJERES'] = 0;
            $IMCE[$valor]['HOMBRES'] = 0;
            $IMCE[$valor]['AMBOS'] = 0;
            $fila = '';
            unset($total_dni);
            foreach ($rango_seccion_a1 as $i => $rango) {
                $indicador = 'IMCE';
                $valor = '-1';
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);


                $indicador = 'PT';
                $valor = '-1';
                $total_hombres += $mysql->getTotal_infancia_pt($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro,'IMCE');
                $total_mujeres += $mysql->getTotal_infancia_pt($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro,'IMCE');


                $indicador = 'IMCE';
                $total_dni[$i]['HOMBRES'] += $total_hombres;
                $total_dni[$i]['MUJERES'] += $total_mujeres;

                if($i<=4){
                    $IMCE[$valor]['HOMBRES'] = $IMCE[$valor]['HOMBRES'] + $total_hombres;
                    $IMCE[$valor]['MUJERES'] = $IMCE[$valor]['MUJERES'] + $total_mujeres;
                    $IMCE[$valor]['AMBOS'] = $IMCE[$valor]['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $IMCE[$valor]['AMBOS'] ?></td>
            <td><?php echo $IMCE[$valor]['HOMBRES'] ?></td>
            <td><?php echo $IMCE[$valor]['MUJERES'] ?></td>
            <?php echo $fila; ?>

        </tr>
        <tr>
            <td>- 2 D.S. (<= -2.0)</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'IMCE';
            $valor = '-2';
            $IMCE[$valor]['MUJERES'] = 0;
            $IMCE[$valor]['HOMBRES'] = 0;
            $IMCE[$valor]['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a1 as $i => $rango) {
                $indicador = 'IMCE';
                $valor = '-2';
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);
                $indicador = 'PT';
                $valor = '-2';
                $total_hombres += $mysql->getTotal_infancia_pt($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro,'IMCE');
                $total_mujeres += $mysql->getTotal_infancia_pt($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro,'IMCE');

                $indicador = 'IMCE';
                $total_dni[$i]['HOMBRES'] += $total_hombres;
                $total_dni[$i]['MUJERES'] += $total_mujeres;

                if($i<=4){
                    $IMCE[$valor]['HOMBRES'] = $IMCE[$valor]['HOMBRES'] + $total_hombres;
                    $IMCE[$valor]['MUJERES'] = $IMCE[$valor]['MUJERES'] + $total_mujeres;
                    $IMCE[$valor]['AMBOS'] = $IMCE[$valor]['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $IMCE[$valor]['AMBOS'] ?></td>
            <td><?php echo $IMCE[$valor]['HOMBRES'] ?></td>
            <td><?php echo $IMCE[$valor]['MUJERES'] ?></td>
            <?php echo $fila; ?>

        </tr>
        <tr style="font-weight: bold;background-color: #d7efff;">
            <td>TOTAL</td>
            <?php
            $fila = '';
            $IMCE['HOMBRES'] = 0;
            $IMCE['MUJERES'] = 0;
            $IMCE['AMBOS'] = 0;

            foreach ($rango_seccion_a1 as $i => $rango) {
                $total_hombres = $total_dni[$i]['HOMBRES'];
                $total_mujeres = $total_dni[$i]['MUJERES'];

                if($i<=4){
                    $IMCE['HOMBRES'] = $IMCE['HOMBRES'] + $total_hombres;
                    $IMCE['MUJERES'] = $IMCE['MUJERES'] + $total_mujeres;
                    $IMCE['AMBOS'] = $IMCE['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer


            }
            ?>
            <td><?php echo $IMCE['AMBOS'] ?></td>
            <td><?php echo $IMCE['HOMBRES'] ?></td>
            <td><?php echo $IMCE['MUJERES'] ?></td>
            <?php echo $fila; ?>

        </tr>
        <tr>
        <tr>
            <td>PROMEDIO</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'IMCE';
            $valor = 'N';
            $IMCE[$valor]['MUJERES'] = 0;
            $IMCE[$valor]['HOMBRES'] = 0;
            $IMCE[$valor]['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a1 as $i => $rango) {
                $indicador = 'IMCE';
                $valor = 'N';
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);
                $indicador = 'PT';
                $valor = 'N';
                $total_hombres += $mysql->getTotal_infancia_pt($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro,'IMCE');
                $total_mujeres += $mysql->getTotal_infancia_pt($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro,'IMCE');

                $indicador = 'IMCE';
                if($i<=4){
                    $IMCE[$valor]['HOMBRES'] = $IMCE[$valor]['HOMBRES'] + $total_hombres;
                    $IMCE[$valor]['MUJERES'] = $IMCE[$valor]['MUJERES'] + $total_mujeres;
                    $IMCE[$valor]['AMBOS'] = $IMCE[$valor]['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $IMCE[$valor]['AMBOS'] ?></td>
            <td><?php echo $IMCE[$valor]['HOMBRES'] ?></td>
            <td><?php echo $IMCE[$valor]['MUJERES'] ?></td>
            <?php echo $fila; ?>

        </tr>
        </tr>
        <tr>
            <td rowspan="7">INDICADOR TALLA/EDAD</td>
            <td>+ 2 D.S. (>= +2.0)</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'TE';
            $valor = '2';
            $IMCE[$valor]['MUJERES'] = 0;
            $IMCE[$valor]['HOMBRES'] = 0;
            $IMCE[$valor]['AMBOS'] = 0;
            $fila = '';
            unset($total_dni);
            foreach ($rango_seccion_a1 as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);

                $total_dni[$i]['HOMBRES'] += $total_hombres;
                $total_dni[$i]['MUJERES'] += $total_mujeres;
                if($i<=4){
                    $IMCE[$valor]['HOMBRES'] = $IMCE[$valor]['HOMBRES'] + $total_hombres;
                    $IMCE[$valor]['MUJERES'] = $IMCE[$valor]['MUJERES'] + $total_mujeres;
                    $IMCE[$valor]['AMBOS'] = $IMCE[$valor]['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $IMCE[$valor]['AMBOS'] ?></td>
            <td><?php echo $IMCE[$valor]['HOMBRES'] ?></td>
            <td><?php echo $IMCE[$valor]['MUJERES'] ?></td>
            <?php echo $fila; ?>

        </tr>
        <tr>
            <td>+ 1 D.S. (+1.0 a +1.9)</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'TE';
            $valor = '1';
            $IMCE[$valor]['MUJERES'] = 0;
            $IMCE[$valor]['HOMBRES'] = 0;
            $IMCE[$valor]['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a1 as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);

                $total_dni[$i]['HOMBRES'] += $total_hombres;
                $total_dni[$i]['MUJERES'] += $total_mujeres;
                if($i<=4){
                    $IMCE[$valor]['HOMBRES'] = $IMCE[$valor]['HOMBRES'] + $total_hombres;
                    $IMCE[$valor]['MUJERES'] = $IMCE[$valor]['MUJERES'] + $total_mujeres;
                    $IMCE[$valor]['AMBOS'] = $IMCE[$valor]['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $IMCE[$valor]['AMBOS'] ?></td>
            <td><?php echo $IMCE[$valor]['HOMBRES'] ?></td>
            <td><?php echo $IMCE[$valor]['MUJERES'] ?></td>
            <?php echo $fila; ?>
        </tr>
        <tr style="font-weight: bold;background-color: #d7efff;">
            <td>TOTAL</td>
            <?php
            $fila = '';
            $IMCE['HOMBRES'] = 0;
            $IMCE['MUJERES'] = 0;
            $IMCE['AMBOS'] = 0;

            foreach ($rango_seccion_a1 as $i => $rango) {
                $total_hombres = $total_dni[$i]['HOMBRES'];
                $total_mujeres = $total_dni[$i]['MUJERES'];

                if($i<=4){
                    $IMCE['HOMBRES'] = $IMCE['HOMBRES'] + $total_hombres;
                    $IMCE['MUJERES'] = $IMCE['MUJERES'] + $total_mujeres;
                    $IMCE['AMBOS'] = $IMCE['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer


            }
            ?>
            <td><?php echo $IMCE['AMBOS'] ?></td>
            <td><?php echo $IMCE['HOMBRES'] ?></td>
            <td><?php echo $IMCE['MUJERES'] ?></td>
            <?php echo $fila; ?>

        </tr>
        <tr>
            <td>- 1 D.S. (-1.0 a -1.9)</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'TE';
            $valor = '-1';
            $IMCE[$valor]['MUJERES'] = 0;
            $IMCE[$valor]['HOMBRES'] = 0;
            $IMCE[$valor]['AMBOS'] = 0;
            $fila = '';
            unset($total_dni);
            foreach ($rango_seccion_a1 as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);

                $total_dni[$i]['HOMBRES'] += $total_hombres;
                $total_dni[$i]['MUJERES'] += $total_mujeres;
                if($i<=4){
                    $IMCE[$valor]['HOMBRES'] = $IMCE[$valor]['HOMBRES'] + $total_hombres;
                    $IMCE[$valor]['MUJERES'] = $IMCE[$valor]['MUJERES'] + $total_mujeres;
                    $IMCE[$valor]['AMBOS'] = $IMCE[$valor]['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $IMCE[$valor]['AMBOS'] ?></td>
            <td><?php echo $IMCE[$valor]['HOMBRES'] ?></td>
            <td><?php echo $IMCE[$valor]['MUJERES'] ?></td>
            <?php echo $fila; ?>

        </tr>
        <tr>
            <td>- 2 D.S. (<= -2.0)</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'TE';
            $valor = '-2';
            $IMCE[$valor]['MUJERES'] = 0;
            $IMCE[$valor]['HOMBRES'] = 0;
            $IMCE[$valor]['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a1 as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);

                $total_dni[$i]['HOMBRES'] += $total_hombres;
                $total_dni[$i]['MUJERES'] += $total_mujeres;
                if($i<=4){
                    $IMCE[$valor]['HOMBRES'] = $IMCE[$valor]['HOMBRES'] + $total_hombres;
                    $IMCE[$valor]['MUJERES'] = $IMCE[$valor]['MUJERES'] + $total_mujeres;
                    $IMCE[$valor]['AMBOS'] = $IMCE[$valor]['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $IMCE[$valor]['AMBOS'] ?></td>
            <td><?php echo $IMCE[$valor]['HOMBRES'] ?></td>
            <td><?php echo $IMCE[$valor]['MUJERES'] ?></td>
            <?php echo $fila; ?>

        </tr>
        <tr style="font-weight: bold;background-color: #d7efff;">
            <td>TOTAL</td>
            <?php
            $fila = '';
            $IMCE['HOMBRES'] = 0;
            $IMCE['MUJERES'] = 0;
            $IMCE['AMBOS'] = 0;

            foreach ($rango_seccion_a1 as $i => $rango) {
                $total_hombres = $total_dni[$i]['HOMBRES'];
                $total_mujeres = $total_dni[$i]['MUJERES'];

                if($i<=4){
                    $IMCE['HOMBRES'] = $IMCE['HOMBRES'] + $total_hombres;
                    $IMCE['MUJERES'] = $IMCE['MUJERES'] + $total_mujeres;
                    $IMCE['AMBOS'] = $IMCE['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer


            }
            ?>
            <td><?php echo $IMCE['AMBOS'] ?></td>
            <td><?php echo $IMCE['HOMBRES'] ?></td>
            <td><?php echo $IMCE['MUJERES'] ?></td>
            <?php echo $fila; ?>
        </tr>
        <tr>
            <td>PROMEDIO (-0,9 A + 0,9)</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'TE';
            $valor = 'N';
            $IMCE[$valor]['MUJERES'] = 0;
            $IMCE[$valor]['HOMBRES'] = 0;
            $IMCE[$valor]['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a1 as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);

                if($i<=4){
                    $IMCE[$valor]['HOMBRES'] = $IMCE[$valor]['HOMBRES'] + $total_hombres;
                    $IMCE[$valor]['MUJERES'] = $IMCE[$valor]['MUJERES'] + $total_mujeres;
                    $IMCE[$valor]['AMBOS'] = $IMCE[$valor]['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $IMCE[$valor]['AMBOS'] ?></td>
            <td><?php echo $IMCE[$valor]['HOMBRES'] ?></td>
            <td><?php echo $IMCE[$valor]['MUJERES'] ?></td>
            <?php echo $fila; ?>
        </tr>
        <tr>
            <td rowspan="4">INDICADOR PERIMETRO DE CINTURA / EDAD</td>
            <td>NORMAL (
                <p75
                    )
            </td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'PCINT';
            $valor = 'NORMAL';
            $IMCE[$valor]['MUJERES'] = 0;
            $IMCE[$valor]['HOMBRES'] = 0;
            $IMCE[$valor]['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a1 as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);

                if($i<=4){
                    $IMCE[$valor]['HOMBRES'] = $IMCE[$valor]['HOMBRES'] + $total_hombres;
                    $IMCE[$valor]['MUJERES'] = $IMCE[$valor]['MUJERES'] + $total_mujeres;
                    $IMCE[$valor]['AMBOS'] = $IMCE[$valor]['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $IMCE[$valor]['AMBOS'] ?></td>
            <td><?php echo $IMCE[$valor]['HOMBRES'] ?></td>
            <td><?php echo $IMCE[$valor]['MUJERES'] ?></td>
            <?php echo $fila; ?>

        </tr>
        <tr>
            <td>RIESGO DE OBESIDAD ABDOMINAL (75<p<90)</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'PCINT';
            $valor = 'RIESGO OBESIDAD';
            $IMCE[$valor]['MUJERES'] = 0;
            $IMCE[$valor]['HOMBRES'] = 0;
            $IMCE[$valor]['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a1 as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);

                if($i<=4){
                    $IMCE[$valor]['HOMBRES'] = $IMCE[$valor]['HOMBRES'] + $total_hombres;
                    $IMCE[$valor]['MUJERES'] = $IMCE[$valor]['MUJERES'] + $total_mujeres;
                    $IMCE[$valor]['AMBOS'] = $IMCE[$valor]['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $IMCE[$valor]['AMBOS'] ?></td>
            <td><?php echo $IMCE[$valor]['HOMBRES'] ?></td>
            <td><?php echo $IMCE[$valor]['MUJERES'] ?></td>
            <?php echo $fila; ?>

        </tr>
        <tr>
            <td>OBESIDAD ABDOMINAL (>p90)</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'PCINT';
            $valor = 'OBESIDAD ABDOMINAL';
            $IMCE[$valor]['MUJERES'] = 0;
            $IMCE[$valor]['HOMBRES'] = 0;
            $IMCE[$valor]['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a1 as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);

                if($i<=4){
                    $IMCE[$valor]['HOMBRES'] = $IMCE[$valor]['HOMBRES'] + $total_hombres;
                    $IMCE[$valor]['MUJERES'] = $IMCE[$valor]['MUJERES'] + $total_mujeres;
                    $IMCE[$valor]['AMBOS'] = $IMCE[$valor]['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $IMCE[$valor]['AMBOS'] ?></td>
            <td><?php echo $IMCE[$valor]['HOMBRES'] ?></td>
            <td><?php echo $IMCE[$valor]['MUJERES'] ?></td>
            <?php echo $fila; ?>

        </tr>
        <tr style="font-weight: bold;background-color: #d7efff;">
            <td>TOTAL</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'PCINT';
            $fila = '';
            $total_hombres = 0;
            $total_mujeres = 0;
            foreach ($rango_seccion_a1 as $i => $rango) {
                $total_hombres =
                    +$mysql->getTotal_infancia($tabla, $indicador, 'OBESIDAD ABDOMINAL', $rango, $sexo[0])
                    + $mysql->getTotal_infancia($tabla, $indicador, 'RIESGO OBESIDAD', $rango, $sexo[0])
                    + $mysql->getTotal_infancia($tabla, $indicador, 'NORMAL', $rango, $sexo[0], $id_centro);
                $total_mujeres =
                    +$mysql->getTotal_infancia($tabla, $indicador, 'OBESIDAD ABDOMINAL', $rango, $sexo[1])
                    + $mysql->getTotal_infancia($tabla, $indicador, 'RIESGO OBESIDAD', $rango, $sexo[1])
                    + $mysql->getTotal_infancia($tabla, $indicador, 'NORMAL', $rango, $sexo[1]);

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer


            }


            ?>
            <td><?php echo $IMCE['OBESIDAD ABDOMINAL']['AMBOS'] + $IMCE['RIESGO OBESIDAD']['AMBOS'] + $IMCE['NORMAL']['AMBOS']; ?></td>
            <td><?php echo $IMCE['OBESIDAD ABDOMINAL']['HOMBRES'] + $IMCE['RIESGO OBESIDAD']['HOMBRES'] + $IMCE['NORMAL']['HOMBRES']; ?></td>
            <td><?php echo $IMCE['OBESIDAD ABDOMINAL']['MUJERES'] + $IMCE['RIESGO OBESIDAD']['MUJERES'] + $IMCE['NORMAL']['MUJERES']; ?></td>

            <?php echo $fila; ?>

        </tr>
        <!-- DNI -->
        <tr>
            <td rowspan="9">DIAGNOSTICO NUTRICIONAL INTEGRADO</td>
            <td>RIESGO DE DESNUTRIR/ DEFICIT PONDERAL</td>
            <?php
            //
            $DNI['AMBOS'] = 0;
            $DNI['HOMBRES'] = 0;
            $DNI['MUJERES'] = 0;

            //
            $tabla = 'antropometria';
            $indicador = 'DNI';
            $valor = 'RI DESNUTRICION';
            $DNI[$valor]['MUJERES'] = 0;
            $DNI[$valor]['HOMBRES'] = 0;
            $DNI[$valor]['AMBOS'] = 0;
            $fila = '';
            $total_dni = Array();
            foreach ($rango_seccion_a1 as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);

                $total_dni[$i]['HOMBRES'] += $total_hombres;
                $total_dni[$i]['MUJERES'] += $total_mujeres;
                if($i<=4){
                    $DNI[$valor]['HOMBRES'] = $DNI[$valor]['HOMBRES'] + $total_hombres;
                    $DNI[$valor]['MUJERES'] = $DNI[$valor]['MUJERES'] + $total_mujeres;
                    $DNI[$valor]['AMBOS'] = $DNI[$valor]['AMBOS'] + $total_mujeres + $total_hombres;
                }


                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer

            }
            $DNI['AMBOS'] += $DNI[$valor]['AMBOS'];
            $DNI['HOMBRES'] += $DNI[$valor]['HOMBRES'];
            $DNI['MUJERES'] += $DNI[$valor]['MUJERES'];
            ?>
            <td><?php echo $DNI[$valor]['AMBOS'] ?></td>
            <td><?php echo $DNI[$valor]['HOMBRES'] ?></td>
            <td><?php echo $DNI[$valor]['MUJERES'] ?></td>
            <?php echo $fila; ?>

        </tr>
        <tr>
            <td>DESNUTRICIÓN</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'DNI';
            $valor = 'DESNUTRICION';
            $DNI[$valor]['MUJERES'] = 0;
            $DNI[$valor]['HOMBRES'] = 0;
            $DNI[$valor]['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a1 as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);

                $total_dni[$i]['HOMBRES'] += $total_hombres;
                $total_dni[$i]['MUJERES'] += $total_mujeres;
                if($i<=4){
                    $DNI[$valor]['HOMBRES'] = $DNI[$valor]['HOMBRES'] + $total_hombres;
                    $DNI[$valor]['MUJERES'] = $DNI[$valor]['MUJERES'] + $total_mujeres;
                    $DNI[$valor]['AMBOS'] = $DNI[$valor]['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }

            $DNI['AMBOS'] += $DNI[$valor]['AMBOS'];
            $DNI['HOMBRES'] += $DNI[$valor]['HOMBRES'];
            $DNI['MUJERES'] += $DNI[$valor]['MUJERES'];
            ?>
            <td><?php echo $DNI[$valor]['AMBOS'] ?></td>
            <td><?php echo $DNI[$valor]['HOMBRES'] ?></td>
            <td><?php echo $DNI[$valor]['MUJERES'] ?></td>
            <?php echo $fila; ?>
        </tr>
        <tr>
            <td>SOBRE PESO / RIESGO OBESIDAD</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'DNI';
            $valor = 'SOBREPESO';
            $DNI[$valor]['MUJERES'] = 0;
            $DNI[$valor]['HOMBRES'] = 0;
            $DNI[$valor]['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a1 as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);

                $total_dni[$i]['HOMBRES'] += $total_hombres;
                $total_dni[$i]['MUJERES'] += $total_mujeres;
                if($i<=4){
                    $DNI[$valor]['HOMBRES'] = $DNI[$valor]['HOMBRES'] + $total_hombres;
                    $DNI[$valor]['MUJERES'] = $DNI[$valor]['MUJERES'] + $total_mujeres;
                    $DNI[$valor]['AMBOS'] = $DNI[$valor]['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            $DNI['AMBOS'] += $DNI[$valor]['AMBOS'];
            $DNI['HOMBRES'] += $DNI[$valor]['HOMBRES'];
            $DNI['MUJERES'] += $DNI[$valor]['MUJERES'];
            ?>
            <td><?php echo $DNI[$valor]['AMBOS'] ?></td>
            <td><?php echo $DNI[$valor]['HOMBRES'] ?></td>
            <td><?php echo $DNI[$valor]['MUJERES'] ?></td>
            <?php echo $fila; ?>
        </tr>
        <tr>
            <td>OBESIDAD</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'DNI';
            $valor = 'OBESIDAD';
            $DNI[$valor]['MUJERES'] = 0;
            $DNI[$valor]['HOMBRES'] = 0;
            $DNI[$valor]['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a1 as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);

                $total_dni[$i]['HOMBRES'] += $total_hombres;
                $total_dni[$i]['MUJERES'] += $total_mujeres;
                if($i<=4){
                    $DNI[$valor]['HOMBRES'] = $DNI[$valor]['HOMBRES'] + $total_hombres;
                    $DNI[$valor]['MUJERES'] = $DNI[$valor]['MUJERES'] + $total_mujeres;
                    $DNI[$valor]['AMBOS'] = $DNI[$valor]['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            $DNI['AMBOS'] += $DNI[$valor]['AMBOS'];
            $DNI['HOMBRES'] += $DNI[$valor]['HOMBRES'];
            $DNI['MUJERES'] += $DNI[$valor]['MUJERES'];
            ?>
            <td><?php echo $DNI[$valor]['AMBOS'] ?></td>
            <td><?php echo $DNI[$valor]['HOMBRES'] ?></td>
            <td><?php echo $DNI[$valor]['MUJERES'] ?></td>
            <?php echo $fila; ?>
        </tr>
        <tr>
            <td>OBESIDAD SEVERA</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'DNI';
            $valor = 'OB SEVERA';
            $DNI[$valor]['MUJERES'] = 0;
            $DNI[$valor]['HOMBRES'] = 0;
            $DNI[$valor]['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a1 as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);

                $total_dni[$i]['HOMBRES'] += $total_hombres;
                $total_dni[$i]['MUJERES'] += $total_mujeres;
                if($i<=4){
                    $DNI[$valor]['HOMBRES'] = $DNI[$valor]['HOMBRES'] + $total_hombres;
                    $DNI[$valor]['MUJERES'] = $DNI[$valor]['MUJERES'] + $total_mujeres;
                    $DNI[$valor]['AMBOS'] = $DNI[$valor]['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            $DNI['AMBOS'] += $DNI[$valor]['AMBOS'];
            $DNI['HOMBRES'] += $DNI[$valor]['HOMBRES'];
            $DNI['MUJERES'] += $DNI[$valor]['MUJERES'];
            ?>
            <td><?php echo $DNI[$valor]['AMBOS'] ?></td>
            <td><?php echo $DNI[$valor]['HOMBRES'] ?></td>
            <td><?php echo $DNI[$valor]['MUJERES'] ?></td>
            <?php echo $fila; ?>
        </tr>
        <tr>
            <td>NORMAL</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'DNI';
            $valor = 'NORMAL';
            $DNI[$valor]['MUJERES'] = 0;
            $DNI[$valor]['HOMBRES'] = 0;
            $DNI[$valor]['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a1 as $i => $rango) {

                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);

                $total_dni[$i]['HOMBRES'] += $total_hombres;
                $total_dni[$i]['MUJERES'] += $total_mujeres;
                if($i<=4){


                    $DNI[$valor]['HOMBRES'] = $DNI[$valor]['HOMBRES'] + $total_hombres;
                    $DNI[$valor]['MUJERES'] = $DNI[$valor]['MUJERES'] + $total_mujeres;
                    $DNI[$valor]['AMBOS'] = $DNI[$valor]['AMBOS'] + $total_mujeres + $total_hombres;
                }


                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer


            }
            $DNI['AMBOS'] += $DNI[$valor]['AMBOS'];
            $DNI['HOMBRES'] += $DNI[$valor]['HOMBRES'];
            $DNI['MUJERES'] += $DNI[$valor]['MUJERES'];
            ?>
            <td><?php echo $DNI[$valor]['AMBOS'] ?></td>
            <td><?php echo $DNI[$valor]['HOMBRES'] ?></td>
            <td><?php echo $DNI[$valor]['MUJERES'] ?></td>
            <?php echo $fila; ?>
        </tr>
        <tr style="font-weight: bold;background-color: #d7efff;">
            <td>SUB-TOTAL</td>
            <?php
            $fila = '';
            $total_hombres = 0;
            $total_mujeresahor = 0;
            foreach ($rango_seccion_a1 as $i => $rango) {
                $total_hombres = $total_dni[$i]['HOMBRES'];
                $total_mujeres = $total_dni[$i]['MUJERES'];

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $DNI['AMBOS'] ?></td>
            <td><?php echo $DNI['HOMBRES'] ?></td>
            <td><?php echo $DNI['MUJERES'] ?></td>
            <?php echo $fila; ?>
        </tr>
        <tr>
            <td>DESNUTRICION SECUNDARIA</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'DNI';
            $valor = 'DESNUTRICION SECUNDARIA';
            $DNI[$valor]['MUJERES'] = 0;
            $DNI[$valor]['HOMBRES'] = 0;
            $DNI[$valor]['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a1 as $i => $rango) {

                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);

                $total_dni[$i]['HOMBRES'] += $total_hombres;
                $total_dni[$i]['MUJERES'] += $total_mujeres;
                if($i<=4){
                    $DNI[$valor]['HOMBRES'] = $DNI[$valor]['HOMBRES'] + $total_hombres;
                    $DNI[$valor]['MUJERES'] = $DNI[$valor]['MUJERES'] + $total_mujeres;
                    $DNI[$valor]['AMBOS'] = $DNI[$valor]['AMBOS'] + $total_mujeres + $total_hombres;
                }


                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer


            }
            $DNI['AMBOS'] += $DNI[$valor]['AMBOS'];
            $DNI['HOMBRES'] += $DNI[$valor]['HOMBRES'];
            $DNI['MUJERES'] += $DNI[$valor]['MUJERES'];
            ?>
            <td><?php echo $DNI[$valor]['AMBOS'] ?></td>
            <td><?php echo $DNI[$valor]['HOMBRES'] ?></td>
            <td><?php echo $DNI[$valor]['MUJERES'] ?></td>
            <?php echo $fila; ?>
        </tr>
        <tr style="font-weight: bold;background-color: #d7efff;">
            <td>TOTAL</td>
            <?php
            $fila = '';
            foreach ($rango_seccion_a1 as $i => $rango) {
                $total_hombres = $total_dni[$i]['HOMBRES'];
                $total_mujeres = $total_dni[$i]['MUJERES'];

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $DNI['AMBOS'] ?></td>
            <td><?php echo $DNI['HOMBRES'] ?></td>
            <td><?php echo $DNI['MUJERES'] ?></td>
            <?php echo $fila; ?>
        </tr>

        <tr>
            <td COLSPAN="2">NIÑOS SIN EVALUACIÓN NUTRICIONAL CON CONDICIÓN ESPECIAL DE SALUD</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'DNI';
            $valor = 'CONDICION ESPECIAL DE SALUD';
            $DNI['nanea']['MUJERES'] = 0;
            $DNI['nanea']['HOMBRES'] = 0;
            $DNI['nanea']['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a1 as $i => $rango) {

                $total_hombres = $mysql->getTotal_infancia_naneas($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia_naneas($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);

                $total_dni[$i]['HOMBRES'] += $total_hombres;
                $total_dni[$i]['MUJERES'] += $total_mujeres;
                if($i<=4){


                    $DNI[$valor]['HOMBRES'] = $DNI['nanea']['HOMBRES'] + $total_hombres;
                    $DNI[$valor]['MUJERES'] = $DNI['nanea']['MUJERES'] + $total_mujeres;
                    $DNI[$valor]['AMBOS'] = $DNI['nanea']['AMBOS'] + $total_mujeres + $total_hombres;
                }


                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer


            }
            $DNI['AMBOS'] += $DNI['nanea']['AMBOS'];
            $DNI['HOMBRES'] += $DNI['nanea']['HOMBRES'];
            $DNI['MUJERES'] += $DNI['nanea']['MUJERES'];
            ?>
            <td><?php echo $DNI['nanea']['AMBOS'] ?></td>
            <td><?php echo $DNI['nanea']['HOMBRES'] ?></td>
            <td><?php echo $DNI['nanea']['MUJERES'] ?></td>
            <?php echo $fila; ?>
        </tr>
        <?php
        $fila = '';
        foreach ($rango_seccion_a1 as $i => $rango) {
            $total_hombres = $total_dni[$i]['HOMBRES'];
            $total_mujeres = $total_dni[$i]['MUJERES'];

            $fila .= '<td>' . $total_hombres . '</td>';//hombre
            $fila .= '<td>' . $total_mujeres . '</td>';//mujer
        }

        $primera = '<td colspan="2">TOTAL DE NIÑOS EN CONTROL</td>'.
            '<td>'.$DNI['AMBOS'].'</td>'.
            '<td>'.$DNI['HOMBRES'].'</td>'.
            '<td>'.$DNI['MUJERES'].'</td>'.$fila;
        ?>
    </table>
</section>
</section>
<script type="text/javascript">
    $("#primera_a1").html('<?php echo $primera; ?>');
</script>
