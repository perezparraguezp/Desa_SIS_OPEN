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

//rango de meses en dias
$rango_seccion_a = [
    'persona.edad_total_dias>=0 and persona.edad_total_dias<(30)', //MENOR A 1 MES
    'persona.edad_total_dias>=30 and persona.edad_total_dias<(30*2)', //1 MES
    'persona.edad_total_dias>=(30*1) and persona.edad_total_dias<(30*3)', //2 MESES
    'persona.edad_total_dias>=(30*2) and persona.edad_total_dias<(30*4)', //3 MESES
    'persona.edad_total_dias>=(30*3) and persona.edad_total_dias<(30*5)', //4 MESES
    'persona.edad_total_dias>=(30*4) and persona.edad_total_dias<(30*6)', //5 MESES
    'persona.edad_total_dias>=(30*5) and persona.edad_total_dias<(30*7)', //6 MESES
    'persona.edad_total_dias>=(30*6) and persona.edad_total_dias<(30*12)',//7 a 11 meses
    'persona.edad_total_dias>=(30*12) and persona.edad_total_dias<(30*18)',//12 a 17 meses
    'persona.edad_total_dias>=(30*18) and persona.edad_total_dias<(30*24)',//18 a 23 meses
    'persona.edad_total_dias>=(30*24) and persona.edad_total_dias<(30*36)',//24 a 35 meses
    'persona.edad_total_dias>=(30*36) and persona.edad_total_dias<(30*42)',//36 a 41 meses
    'persona.edad_total_dias>=(30*42) and persona.edad_total_dias<(30*48)',//42 a 47 meses
    'persona.edad_total_dias>=(30*48) and persona.edad_total_dias<(30*60)',//48 a 59 meses

    "persona.edad_total_dias>=0 and persona.edad_total_dias<(30*60) and persona.pueblo!='NO'",//PUEBLOS ORIGINARIOS
    "persona.edad_total_dias>=0 and persona.edad_total_dias<(30*60) and persona.migrante!='NO'",//MIGRANTES
];
?>
<section id="seccion_a" style="width: 100%;overflow-y: scroll;">
    <div class="row">
        <div class="col l10">
            <header>SECCION A: POBLACIÓN EN CONTROL, SEGÚN ESTADO NUTRICIONAL PARA NIÑOS MENOR DE UN MES-59 MESES
            </header>
        </div>
    </div>
    <table id="table_seccion_a" style="width: 100%;border: solid 1px black;" border="1">
        <tr>
            <td colspan="2" rowspan="3"
                style="width: 400px;background-color: #fdff8b;position: relative;text-align: center;">
                INDICADOR NUTRICIONAL Y PARAMETROS DE MEDICIÓN
            </td>
            <td rowspan="2" colspan="3">
                TOTAL
            </td>
            <td colspan="28">
                GRUPOS DE EDAD (EN MESES - AÑOS) Y SEXO
            </td>
            <td colspan="2" rowspan="2">
                PUEBLOS ORIGINARIOS
            </td>
            <td colspan="2" rowspan="2">
                POBLACION MIGRANTE
            </td>
        </tr>
        <tr>
            <td colspan="2">MENOR A 1 MES</td>
            <td colspan="2">1 MES</td>
            <td colspan="2">2 MESES</td>
            <td colspan="2">3 MESES</td>
            <td colspan="2">4 MESES</td>
            <td colspan="2">5 MESES</td>
            <td colspan="2">6 MESES</td>
            <td colspan="2">7 A 11 MESES</td>
            <td colspan="2">12 A 17 MESES</td>
            <td colspan="2">18 A 23 MESES</td>
            <td colspan="2">24 A 35 MESES</td>
            <td colspan="2">36 A 41 MESES</td>
            <td colspan="2">42 A 47 MESES</td>
            <td colspan="2">48 A 59 MESES</td>
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

            <td>HOMBRES</td>
            <td>MUJERES</td>
        </tr>
        <tr>
            <td colspan="2">TOTAL DE NIÑOS EN CONTROL</td>
        </tr>
        <tr>
            <td rowspan="6">INDICADOR PESO/EDAD</td>
            <td>+ 2 D.S. (>= +2.0)</td>
            <?php
            $thph = 0;
            $thpm = 0;
            $thm = 0;
            $tmm = 0;
            $tabla = 'antropometria';
            $indicador = 'PE';
            $valor = '2';
            $PE['2']['MUJERES'] = 0;
            $PE['2']['HOMBRES'] = 0;
            $PE['2']['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);
                if ($i <= 13) {
                    $PE['2']['HOMBRES'] = $PE['2']['HOMBRES'] + $total_hombres;
                    $PE['2']['MUJERES'] = $PE['2']['MUJERES'] + $total_mujeres;
                    $PE['2']['AMBOS'] = $PE['2']['AMBOS'] + $total_mujeres + $total_hombres;
                }


                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $PE['2']['AMBOS'] ?></td>
            <td><?php echo $PE['2']['HOMBRES'] ?></td>
            <td><?php echo $PE['2']['MUJERES'] ?></td>
            <?php echo $fila; ?>


        </tr>
        <tr>
            <td>+ 1 D.S. (+1.0 a +1.9)</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'PE';
            $valor = '1';
            $PE['1']['MUJERES'] = 0;
            $PE['1']['HOMBRES'] = 0;
            $PE['1']['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);
                if ($i <= 13) {
                    $PE['1']['HOMBRES'] = $PE['1']['HOMBRES'] + $total_hombres;
                    $PE['1']['MUJERES'] = $PE['1']['MUJERES'] + $total_mujeres;
                    $PE['1']['AMBOS'] = $PE['1']['AMBOS'] + $total_mujeres + $total_hombres;
                }


                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $PE['1']['AMBOS'] ?></td>
            <td><?php echo $PE['1']['HOMBRES'] ?></td>
            <td><?php echo $PE['1']['MUJERES'] ?></td>
            <?php echo $fila; ?>

        </tr>
        <tr style="font-weight: bold;background-color: #d7efff;">
            <td>TOTAL</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'PE';
            $total_mujeres = 0;
            $total_hombres = 0;
            $fila = '';
            foreach ($rango_seccion_a as $i => $rango) {

                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, '1', $rango, $sexo[0], $id_centro);
                $total_hombres += $mysql->getTotal_infancia($tabla, $indicador, '2', $rango, $sexo[0], $id_centro);

                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, '1', $rango, $sexo[1], $id_centro);
                $total_mujeres += $mysql->getTotal_infancia($tabla, $indicador, '2', $rango, $sexo[1], $id_centro);


                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $PE['1']['AMBOS'] + $PE['2']['AMBOS'] ?></td>
            <td><?php echo $PE['1']['HOMBRES'] + $PE['2']['HOMBRES'] ?></td>
            <td><?php echo $PE['1']['MUJERES'] + $PE['2']['MUJERES'] ?></td>
            <?php echo $fila; ?>


        </tr>
        <tr>
            <td>- 1 D.S. (-1.0 a -1.9)</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'PE';
            $valor = '-1';
            $PE['-1']['MUJERES'] = 0;
            $PE['-1']['HOMBRES'] = 0;
            $PE['-1']['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);
                if ($i <= 13) {
                    $PE['-1']['HOMBRES'] = $PE['-1']['HOMBRES'] + $total_hombres;
                    $PE['-1']['MUJERES'] = $PE['-1']['MUJERES'] + $total_mujeres;
                    $PE['-1']['AMBOS'] = $PE['-1']['AMBOS'] + $total_mujeres + $total_hombres;
                }


                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $PE['-1']['AMBOS'] ?></td>
            <td><?php echo $PE['-1']['HOMBRES'] ?></td>
            <td><?php echo $PE['-1']['MUJERES'] ?></td>
            <?php echo $fila; ?>

        </tr>
        <tr>
            <td>- 2 D.S. (<= -2.0)</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'PE';
            $valor = '-2';
            $PE['-2']['MUJERES'] = 0;
            $PE['-2']['HOMBRES'] = 0;
            $PE['-2']['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);
                if ($i <= 13) {
                    $PE['-2']['HOMBRES'] = $PE['-2']['HOMBRES'] + $total_hombres;
                    $PE['-2']['MUJERES'] = $PE['-2']['MUJERES'] + $total_mujeres;
                    $PE['-2']['AMBOS'] = $PE['-2']['AMBOS'] + $total_mujeres + $total_hombres;
                }


                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $PE['-2']['AMBOS'] ?></td>
            <td><?php echo $PE['-2']['HOMBRES'] ?></td>
            <td><?php echo $PE['-2']['MUJERES'] ?></td>
            <?php echo $fila; ?>

        </tr>
        <tr style="font-weight: bold;background-color: #d7efff;">
            <td>TOTAL</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'PE';
            $total_mujeres = 0;
            $total_hombres = 0;
            $fila = '';
            foreach ($rango_seccion_a as $i => $rango) {

                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, '-1', $rango, $sexo[0], $id_centro);
                $total_hombres += $mysql->getTotal_infancia($tabla, $indicador, '-2', $rango, $sexo[0], $id_centro);

                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, '-1', $rango, $sexo[1], $id_centro);
                $total_mujeres += $mysql->getTotal_infancia($tabla, $indicador, '-2', $rango, $sexo[1], $id_centro);


                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $PE['-1']['AMBOS'] + $PE['-2']['AMBOS'] ?></td>
            <td><?php echo $PE['-1']['HOMBRES'] + $PE['-2']['HOMBRES'] ?></td>
            <td><?php echo $PE['-1']['MUJERES'] + $PE['-2']['MUJERES'] ?></td>
            <?php echo $fila; ?>

        </tr>
        <!--PT -->
        <tr>
            <td rowspan="6">INDICADOR PESO/TALLA</td>
            <td>+ 2 D.S. (>= +2.0)</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'PT';
            $valor = '2';
            $PE['2']['MUJERES'] = 0;
            $PE['2']['HOMBRES'] = 0;
            $PE['2']['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);
                if ($i <= 13) {
                    $PE['2']['HOMBRES'] = $PE['2']['HOMBRES'] + $total_hombres;
                    $PE['2']['MUJERES'] = $PE['2']['MUJERES'] + $total_mujeres;
                    $PE['2']['AMBOS'] = $PE['2']['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $PE['2']['AMBOS'] ?></td>
            <td><?php echo $PE['2']['HOMBRES'] ?></td>
            <td><?php echo $PE['2']['MUJERES'] ?></td>
            <?php echo $fila; ?>


        </tr>
        <tr>
            <td>+ 1 D.S. (+1.0 a +1.9)</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'PT';
            $valor = '1';
            $PE['1']['MUJERES'] = 0;
            $PE['1']['HOMBRES'] = 0;
            $PE['1']['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);
                if ($i <= 13) {
                    $PE['1']['HOMBRES'] = $PE['1']['HOMBRES'] + $total_hombres;
                    $PE['1']['MUJERES'] = $PE['1']['MUJERES'] + $total_mujeres;
                    $PE['1']['AMBOS'] = $PE['1']['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $PE['1']['AMBOS'] ?></td>
            <td><?php echo $PE['1']['HOMBRES'] ?></td>
            <td><?php echo $PE['1']['MUJERES'] ?></td>
            <?php echo $fila; ?>

        </tr>
        <tr style="font-weight: bold;background-color: #d7efff;">
            <td>TOTAL</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'PT';
            $total_mujeres = 0;
            $total_hombres = 0;
            $fila = '';
            foreach ($rango_seccion_a as $i => $rango) {

                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, '1', $rango, $sexo[0], $id_centro);
                $total_hombres += $mysql->getTotal_infancia($tabla, $indicador, '2', $rango, $sexo[0], $id_centro);

                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, '1', $rango, $sexo[1], $id_centro);
                $total_mujeres += $mysql->getTotal_infancia($tabla, $indicador, '2', $rango, $sexo[1], $id_centro);


                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $PE['1']['AMBOS'] + $PE['2']['AMBOS'] ?></td>
            <td><?php echo $PE['1']['HOMBRES'] + $PE['2']['HOMBRES'] ?></td>
            <td><?php echo $PE['1']['MUJERES'] + $PE['2']['MUJERES'] ?></td>
            <?php echo $fila; ?>

        </tr>
        <tr>
            <td>- 1 D.S. (-1.0 a -1.9)</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'PT';
            $valor = '-1';
            $PE['-1']['MUJERES'] = 0;
            $PE['-1']['HOMBRES'] = 0;
            $PE['-1']['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);
                if ($i <= 13) {
                    $PE['-1']['HOMBRES'] = $PE['-1']['HOMBRES'] + $total_hombres;
                    $PE['-1']['MUJERES'] = $PE['-1']['MUJERES'] + $total_mujeres;
                    $PE['-1']['AMBOS'] = $PE['-1']['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $PE['-1']['AMBOS'] ?></td>
            <td><?php echo $PE['-1']['HOMBRES'] ?></td>
            <td><?php echo $PE['-1']['MUJERES'] ?></td>
            <?php echo $fila; ?>

        </tr>
        <tr>
            <td>- 2 D.S. (<= -2.0)</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'PT';
            $valor = '-2';
            $PE['-2']['MUJERES'] = 0;
            $PE['-2']['HOMBRES'] = 0;
            $PE['-2']['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);
                if ($i <= 13) {
                    $PE['-2']['HOMBRES'] = $PE['-2']['HOMBRES'] + $total_hombres;
                    $PE['-2']['MUJERES'] = $PE['-2']['MUJERES'] + $total_mujeres;
                    $PE['-2']['AMBOS'] = $PE['-2']['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $PE['-2']['AMBOS'] ?></td>
            <td><?php echo $PE['-2']['HOMBRES'] ?></td>
            <td><?php echo $PE['-2']['MUJERES'] ?></td>
            <?php echo $fila; ?>

        </tr>
        <tr style="font-weight: bold;background-color: #d7efff;">
            <td>TOTAL</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'PT';
            $total_mujeres = 0;
            $total_hombres = 0;
            $fila = '';
            foreach ($rango_seccion_a as $i => $rango) {

                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, '-1', $rango, $sexo[0], $id_centro);
                $total_hombres += $mysql->getTotal_infancia($tabla, $indicador, '-2', $rango, $sexo[0], $id_centro);

                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, '-1', $rango, $sexo[1], $id_centro);
                $total_mujeres += $mysql->getTotal_infancia($tabla, $indicador, '-2', $rango, $sexo[1], $id_centro);


                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $PE['-1']['AMBOS'] + $PE['-2']['AMBOS'] ?></td>
            <td><?php echo $PE['-1']['HOMBRES'] + $PE['-2']['HOMBRES'] ?></td>
            <td><?php echo $PE['-1']['MUJERES'] + $PE['-2']['MUJERES'] ?></td>
            <?php echo $fila; ?>

        </tr>
        <!--TE -->
        <tr>
            <td rowspan="7">INDICADOR TALLA/EDAD</td>
            <td>+ 2 D.S. (>= +2.0)</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'TE';
            $valor = '2';
            $PE['2']['MUJERES'] = 0;
            $PE['2']['HOMBRES'] = 0;
            $PE['2']['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);
                if ($i <= 13) {
                    $PE['2']['HOMBRES'] = $PE['2']['HOMBRES'] + $total_hombres;
                    $PE['2']['MUJERES'] = $PE['2']['MUJERES'] + $total_mujeres;
                    $PE['2']['AMBOS'] = $PE['2']['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $PE['2']['AMBOS'] ?></td>
            <td><?php echo $PE['2']['HOMBRES'] ?></td>
            <td><?php echo $PE['2']['MUJERES'] ?></td>
            <?php echo $fila; ?>


        </tr>
        <tr>
            <td>+ 1 D.S. (+1.0 a +1.9)</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'TE';
            $valor = '1';
            $PE['1']['MUJERES'] = 0;
            $PE['1']['HOMBRES'] = 0;
            $PE['1']['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);
                if ($i <= 13) {
                    $PE['1']['HOMBRES'] = $PE['1']['HOMBRES'] + $total_hombres;
                    $PE['1']['MUJERES'] = $PE['1']['MUJERES'] + $total_mujeres;
                    $PE['1']['AMBOS'] = $PE['1']['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $PE['1']['AMBOS'] ?></td>
            <td><?php echo $PE['1']['HOMBRES'] ?></td>
            <td><?php echo $PE['1']['MUJERES'] ?></td>
            <?php echo $fila; ?>
        </tr>
        <tr style="font-weight: bold;background-color: #d7efff;">
            <td>TOTAL</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'TE';
            $total_mujeres = 0;
            $total_hombres = 0;
            $fila = '';
            foreach ($rango_seccion_a as $i => $rango) {

                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, '1', $rango, $sexo[0], $id_centro);
                $total_hombres += $mysql->getTotal_infancia($tabla, $indicador, '2', $rango, $sexo[0], $id_centro);

                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, '1', $rango, $sexo[1], $id_centro);
                $total_mujeres += $mysql->getTotal_infancia($tabla, $indicador, '2', $rango, $sexo[1], $id_centro);


                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $PE['1']['AMBOS'] + $PE['2']['AMBOS'] ?></td>
            <td><?php echo $PE['1']['HOMBRES'] + $PE['2']['HOMBRES'] ?></td>
            <td><?php echo $PE['1']['MUJERES'] + $PE['2']['MUJERES'] ?></td>
            <?php echo $fila; ?>

        </tr>
        <tr>
            <td>- 1 D.S. (-1.0 a -1.9)</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'TE';
            $valor = '-1';
            $PE['-1']['MUJERES'] = 0;
            $PE['-1']['HOMBRES'] = 0;
            $PE['-1']['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);
                if ($i <= 13) {
                    $PE['-1']['HOMBRES'] = $PE['-1']['HOMBRES'] + $total_hombres;
                    $PE['-1']['MUJERES'] = $PE['-1']['MUJERES'] + $total_mujeres;
                    $PE['-1']['AMBOS'] = $PE['-1']['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $PE['-1']['AMBOS'] ?></td>
            <td><?php echo $PE['-1']['HOMBRES'] ?></td>
            <td><?php echo $PE['-1']['MUJERES'] ?></td>
            <?php echo $fila; ?>

        </tr>
        <tr>
            <td>- 2 D.S. (<= -2.0)</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'TE';
            $valor = '-2';
            $PE['-2']['MUJERES'] = 0;
            $PE['-2']['HOMBRES'] = 0;
            $PE['-2']['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);
                if ($i <= 13) {
                    $PE['-2']['HOMBRES'] = $PE['-2']['HOMBRES'] + $total_hombres;
                    $PE['-2']['MUJERES'] = $PE['-2']['MUJERES'] + $total_mujeres;
                    $PE['-2']['AMBOS'] = $PE['-2']['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $PE['-2']['AMBOS'] ?></td>
            <td><?php echo $PE['-2']['HOMBRES'] ?></td>
            <td><?php echo $PE['-2']['MUJERES'] ?></td>
            <?php echo $fila; ?>

        </tr>
        <tr style="font-weight: bold;background-color: #d7efff;">
            <td>TOTAL</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'TE';
            $total_mujeres = 0;
            $total_hombres = 0;
            $fila = '';
            foreach ($rango_seccion_a as $i => $rango) {

                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, '-1', $rango, $sexo[0], $id_centro);
                $total_hombres += $mysql->getTotal_infancia($tabla, $indicador, '-2', $rango, $sexo[0], $id_centro);

                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, '-1', $rango, $sexo[1], $id_centro);
                $total_mujeres += $mysql->getTotal_infancia($tabla, $indicador, '-2', $rango, $sexo[1], $id_centro);


                $fila .= '<td>' . $total_hombres . '</td>';//hombre
                $fila .= '<td>' . $total_mujeres . '</td>';//mujer
            }
            ?>
            <td><?php echo $PE['-1']['AMBOS'] + $PE['-2']['AMBOS'] ?></td>
            <td><?php echo $PE['-1']['HOMBRES'] + $PE['-2']['HOMBRES'] ?></td>
            <td><?php echo $PE['-1']['MUJERES'] + $PE['-2']['MUJERES'] ?></td>
            <?php echo $fila; ?>
        </tr>
        <td>PROMEDIO</td>
        <?php
        $tabla = 'antropometria';
        $indicador = 'TE';
        $valor = 'N';
        $PE['2']['MUJERES'] = 0;
        $PE['2']['HOMBRES'] = 0;
        $PE['2']['AMBOS'] = 0;
        $fila = '';
        foreach ($rango_seccion_a as $i => $rango) {
            $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
            $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);
            if ($i <= 13) {
                $PE['2']['HOMBRES'] = $PE['2']['HOMBRES'] + $total_hombres;
                $PE['2']['MUJERES'] = $PE['2']['MUJERES'] + $total_mujeres;
                $PE['2']['AMBOS'] = $PE['2']['AMBOS'] + $total_mujeres + $total_hombres;
            }

            $fila .= '<td>' . $total_hombres . '</td>';//hombre
            $fila .= '<td>' . $total_mujeres . '</td>';//mujer
        }
        ?>
        <td><?php echo $PE['2']['AMBOS'] ?></td>
        <td><?php echo $PE['2']['HOMBRES'] ?></td>
        <td><?php echo $PE['2']['MUJERES'] ?></td>
        <?php echo $fila; ?>


        </tr>
        <!--DNI - RI DESNUTRICION -->
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
            foreach ($rango_seccion_a as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);

                $total_dni[$i]['HOMBRES'] += $total_hombres;
                $total_dni[$i]['MUJERES'] += $total_mujeres;
                if($i<=13){
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
            foreach ($rango_seccion_a as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);
                if($i<=13) {
                    $DNI[$valor]['HOMBRES'] = $DNI[$valor]['HOMBRES'] + $total_hombres;
                    $DNI[$valor]['MUJERES'] = $DNI[$valor]['MUJERES'] + $total_mujeres;
                    $DNI[$valor]['AMBOS'] = $DNI[$valor]['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $total_dni[$i]['HOMBRES'] += $total_hombres;
                $total_dni[$i]['MUJERES'] += $total_mujeres;

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
            foreach ($rango_seccion_a as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);
                if($i<=13) {
                    $DNI[$valor]['HOMBRES'] = $DNI[$valor]['HOMBRES'] + $total_hombres;
                    $DNI[$valor]['MUJERES'] = $DNI[$valor]['MUJERES'] + $total_mujeres;
                    $DNI[$valor]['AMBOS'] = $DNI[$valor]['AMBOS'] + $total_mujeres + $total_hombres;
                }


                $total_dni[$i]['HOMBRES'] += $total_hombres;
                $total_dni[$i]['MUJERES'] += $total_mujeres;

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
            foreach ($rango_seccion_a as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);
                if($i<=13) {
                    $DNI[$valor]['HOMBRES'] = $DNI[$valor]['HOMBRES'] + $total_hombres;
                    $DNI[$valor]['MUJERES'] = $DNI[$valor]['MUJERES'] + $total_mujeres;
                    $DNI[$valor]['AMBOS'] = $DNI[$valor]['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $total_dni[$i]['HOMBRES'] += $total_hombres;
                $total_dni[$i]['MUJERES'] += $total_mujeres;

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
        <!--            <tr>-->
        <!--                <td>OBESIDAD SEVERA</td>-->
        <!--                --><?php
        //                $tabla = 'antropometria';
        //                $indicador = 'DNI';
        //                $valor = 'OB SEVERA';
        //                $DNI[$valor]['MUJERES'] =0;
        //                $DNI[$valor]['HOMBRES'] =0;
        //                $DNI[$valor]['AMBOS'] =0;
        //                $fila = '';
        //                foreach ($rango_seccion_a as $i => $rango){
        //                    $total_hombres = $mysql->getTotal_infancia($tabla,$indicador,$valor,$rango,$sexo[0],$id_centro);
        //                    $total_mujeres = $mysql->getTotal_infancia($tabla,$indicador,$valor,$rango,$sexo[1],$id_centro);
        //                    $DNI[$valor]['HOMBRES'] = $DNI[$valor]['HOMBRES'] + $total_hombres;
        //                    $DNI[$valor]['MUJERES'] = $DNI[$valor]['MUJERES'] + $total_mujeres;
        //                    $DNI[$valor]['AMBOS'] = $DNI[$valor]['AMBOS'] + $total_mujeres + $total_hombres;
        //
        //                    $total_dni[$i]['HOMBRES'] += $total_hombres;
        //                    $total_dni[$i]['MUJERES'] += $total_mujeres;
        //
        //                    $fila.= '<td>'.$total_hombres.'</td>';//hombre
        //                    $fila.= '<td>'.$total_mujeres.'</td>';//mujer
        //                }
        //                $DNI['AMBOS'] += $DNI[$valor]['AMBOS'];
        //                $DNI['HOMBRES'] += $DNI[$valor]['HOMBRES'];
        //                $DNI['MUJERES'] += $DNI[$valor]['MUJERES'];
        //                ?>
        <!--                <td>--><?php //echo $DNI[$valor]['AMBOS'] ?><!--</td>-->
        <!--                <td>--><?php //echo $DNI[$valor]['HOMBRES'] ?><!--</td>-->
        <!--                <td>--><?php //echo $DNI[$valor]['MUJERES'] ?><!--</td>-->
        <!--                --><?php //echo $fila; ?>
        <!--            </tr>-->
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
            foreach ($rango_seccion_a as $i => $rango) {

                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);

                if($i<=13) {
                    $DNI[$valor]['HOMBRES'] = $DNI[$valor]['HOMBRES'] + $total_hombres;
                    $DNI[$valor]['MUJERES'] = $DNI[$valor]['MUJERES'] + $total_mujeres;
                    $DNI[$valor]['AMBOS'] = $DNI[$valor]['AMBOS'] + $total_mujeres + $total_hombres;
                }


                $total_dni[$i]['HOMBRES'] += $total_hombres;
                $total_dni[$i]['MUJERES'] += $total_mujeres;


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
            foreach ($rango_seccion_a as $i => $rango) {
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
            foreach ($rango_seccion_a as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);
                if($i<=13) {
                    $DNI[$valor]['HOMBRES'] = $DNI[$valor]['HOMBRES'] + $total_hombres;
                    $DNI[$valor]['MUJERES'] = $DNI[$valor]['MUJERES'] + $total_mujeres;
                    $DNI[$valor]['AMBOS'] = $DNI[$valor]['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $total_dni[$i]['HOMBRES'] += $total_hombres;
                $total_dni[$i]['MUJERES'] += $total_mujeres;

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
            <td>NIÑOS SIN EVALUACIÓN NUTRICIONAL CON CONDICIÓN ESPECIAL DE SALUD</td>
            <?php
            $tabla = 'antropometria';
            $indicador = 'DNI';
            $valor = '';
            $DNI[$valor]['MUJERES'] = 0;
            $DNI[$valor]['HOMBRES'] = 0;
            $DNI[$valor]['AMBOS'] = 0;
            $fila = '';
            foreach ($rango_seccion_a as $i => $rango) {
                $total_hombres = $mysql->getTotal_infancia_naneas($tabla, $indicador, $valor, $rango, $sexo[0], $id_centro);
                $total_mujeres = $mysql->getTotal_infancia_naneas($tabla, $indicador, $valor, $rango, $sexo[1], $id_centro);
                if($i<=13) {
                    $DNI['nanea']['HOMBRES'] = $DNI[$valor]['HOMBRES'] + $total_hombres;
                    $DNI['nanea']['MUJERES'] = $DNI[$valor]['MUJERES'] + $total_mujeres;
                    $DNI['nanea']['AMBOS'] = $DNI[$valor]['AMBOS'] + $total_mujeres + $total_hombres;
                }

                $total_dni[$i]['HOMBRES'] += $total_hombres;
                $total_dni[$i]['MUJERES'] += $total_mujeres;

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
        <tr style="font-weight: bold;background-color: #d7efff;">
            <td>TOTAL</td>
            <?php
            $fila = '';
            foreach ($rango_seccion_a as $i => $rango) {
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
    </table>
</section>
