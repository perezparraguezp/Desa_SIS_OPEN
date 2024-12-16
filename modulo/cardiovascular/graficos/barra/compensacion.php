<?php
include "../../../../php/config.php";
include "../../../../php/objetos/persona.php";

//session_start();

$id_establecimiento = $_SESSION['id_establecimiento'];


$sector_comunal = explode(",", $_POST['sector_comunal']);
$centro_interno = explode(",", $_POST['centro_interno']);
$sector_interno = explode(",", $_POST['sector_interno']);

$comunal = $establecimientos = $sectores = false;

if (in_array('TODOS', $sector_comunal)) {
    $comunal = true;
} else {
    if (in_array('TODOS', $centro_interno)) {
        $establecimientos = true;
    } else {
        if (in_array('TODOS', $sector_interno)) {
            $sectores = true;
        }
    }
}
if ($comunal == true) {
    //todos los pacientes del modulo
    $sql = "select * from paciente_establecimiento
                where id_establecimiento='$id_establecimiento'
                and m_cardiovascular='SI' and rut!='' 
                group by rut";
} else {
    if ($establecimientos == true) {
        //todos los pacientes que pertenescan al sector comunal
        $filtro = '';
        $i = 0;
        foreach ($sector_comunal as $sc => $id_sector_comunal) {
            $sql1 = "select * from centros_internos
                            inner join sector_comunal sc on centros_internos.id_sector_comunal = sc.id_sector_comunal
                            inner join sectores_centros_internos sci on centros_internos.id_centro_interno = sci.id_centro_interno
                        where sc.id_sector_comunal='$id_sector_comunal' ";
            $res1 = mysql_query($sql1);
            while ($row1 = mysql_fetch_array($res1)) {
                if ($i > 0) {
                    $filtro .= " or ";
                }
                $filtro .= " id_sector='" . $row1['id_sector_centro_interno'] . "' ";
                $i++;
            }
            $i++;
        }

        $sql = "select * from paciente_establecimiento
                where id_establecimiento='$id_establecimiento'
                and m_cardiovascular='SI'  and rut!='' 
                and (" . $filtro . ")
                group by rut;";
    } else {
        if ($sectores == true) {
            //todos los pacientes que pertenescan al centro interno
            $filtro = '';
            $i = 0;
            foreach ($centro_interno as $sc => $id_centro_interno) {
                $sql1 = "select * from centros_internos
                            inner join sector_comunal sc on centros_internos.id_sector_comunal = sc.id_sector_comunal
                            inner join sectores_centros_internos sci on centros_internos.id_centro_interno = sci.id_centro_interno
                        where centros_internos.id_centro_interno='$id_centro_interno' ";
                $res1 = mysql_query($sql1);
                while ($row1 = mysql_fetch_array($res1)) {
                    if ($i > 0) {
                        $filtro .= " or ";
                    }
                    $filtro .= " id_sector='" . $row1['id_sector_centro_interno'] . "' ";
                    $i++;
                }
                $i++;
            }

            $sql = "select * from paciente_establecimiento
                where id_establecimiento='$id_establecimiento'
                and m_cardiovascular='SI'  and rut!='' 
                and (" . $filtro . ")
                group by rut;";
        } else {
            //todos los pacientes que pertenescan al centro interno
            $filtro = '';
            $i = 0;
            foreach ($sector_interno as $sc => $id_sector) {
                if ($i > 0) {
                    $filtro .= " or ";
                }
                $filtro .= " id_sector='" . $id_sector . "' ";
                $i++;
            }

            $sql = "select * from paciente_establecimiento
                where id_establecimiento='$id_establecimiento'
                and m_cardiovascular='SI'  and rut!='' 
                and (" . $filtro . ")
                group by rut;";
        }
    }
}
$res = mysql_query($sql);
$pacientes = array();
$filtro_pacientes = '';
$i = 0;
while ($row = mysql_fetch_array($res)) {
    if($i>0){
        $filtro_pacientes .= ' or ';
    }
    $filtro_pacientes .= "paciente_establecimiento.rut='".$row['rut']."' ";
    $i++;
}
//print_r($pacientes);


list($atributo, $tabla, $tabla_historial) = explode("|", $_POST['atributo']);

if ($atributo == 'patologia_dm') {
    if ($_POST['edad']) {
        list($rango_edad, $estado) = explode("#", $_POST['edad']);
    } else {
        list($rango_edad, $estado) = explode("#", '<(80*12)#< 7%');

    }
} else {
    if ($atributo == 'patologia_hta') {
        if ($_POST['edad']) {
            list($rango_edad, $estado) = explode("#", $_POST['edad']);
        } else {
            list($rango_edad, $estado) = explode("#", ">(12*15) #%/90 MMHG%");

        }

    }
}


$filtro_edad = '';
if ($rango_edad != '') {
    if (strpos($rango_edad, '@')) {
        $rango_edad_array = explode("@", $rango_edad);
        foreach ($rango_edad_array as $aa => $rango_edad) {
            if ($rango_edad != '') {
                $filtro_edad .= ' and persona.edad_total ' . $rango_edad;
                if ($atributo == 'patologia_dm') {
                    $estado_sql = "'%> %'";
                } else {
                    $estado_sql = "like '%/90 MMHG%'";
                }

            }
        }
    } else {
        $filtro_edad = ' and persona.edad_total ' . $rango_edad;
        $estado_sql = " '$estado' ";
    }
} else {
    $filtro_edad = '';
}


$TITULO_GRAFICO = 'COMPENSACIÓN';

$filtro = '';


$comunal = $establecimientos = $sectores = false;

if (in_array('TODOS', $sector_comunal)) {
    $comunal = true;
} else {
    if (in_array('TODOS', $centro_interno)) {
        $establecimientos = true;
    } else {
        if (in_array('TODOS', $sector_interno)) {
            $sectores = true;
        }
    }
}

$rango = '';
$series = '';
$json = '';
$json_coma = 0;


if ($atributo == 'patologia_dm') {
    $sql_0 = "select *  from persona 
                                    inner join paciente_establecimiento using(rut) 
                                    inner join paciente_pscv on paciente_pscv.rut=persona.rut
                                    where m_cardiovascular='SI' and persona.rut!='' 
                                    and paciente_establecimiento.id_establecimiento='$id_establecimiento'
                                    and patologia_dm='SI'
                                          and ($filtro_pacientes) 
                                    $filtro_edad  

                                     ";

} else {
    if ($atributo == 'patologia_hta') {
        $sql_0 = "select *  from persona 
                                    inner join paciente_establecimiento using(rut) 
                                    inner join paciente_pscv on paciente_pscv.rut=persona.rut
                                    where m_cardiovascular='SI' and persona.rut!='' 
                                    and paciente_establecimiento.id_establecimiento='$id_establecimiento'
                                    and patologia_hta='SI'
                                          and ($filtro_pacientes) 
                                    $filtro_edad  

                                     ";
    }
}


$res_0 = mysql_query($sql_0);
$total_pacientes = 0;
$total_pendiente = 0;
$total_indicador = 0;
$total_vigente = 0;
$hombres_pendientes = 0;
$mujeres_pendientes = 0;
$hombres = 0;
$mujeres = 0;
$i = 0;
while ($row_0 = mysql_fetch_array($res_0)) {
    $persona = new persona($row_0['rut']);
    if ($json_coma > 0) {
        $json .= ',';
    }
    if ($atributo == 'patologia_dm') {
        $sql_1 = "select *,indicador,hba1c as valor_json,historial_diabetes_mellitus.fecha_registro as fecha_registro 
                        from pscv_diabetes_mellitus
                        inner join persona on pscv_diabetes_mellitus.rut=persona.rut
                        inner join historial_diabetes_mellitus on historial_diabetes_mellitus.rut=pscv_diabetes_mellitus.rut
                  where persona.rut='$persona->rut' and indicador='hba1c'
                  and TIMESTAMPDIFF(DAY,fecha_registro,CURRENT_DATE)<=365
                  order by historial_diabetes_mellitus.fecha_registro desc
                  limit 1";

    } else {
        $sql_1 = "select *,pa as valor_json,pa_fecha as fecha_registro from parametros_pscv
                        inner join persona on parametros_pscv.rut=persona.rut
                  where persona.rut='$persona->rut' 
                  and pa like $estado_sql
                  and TIMESTAMPDIFF(DAY,parametros_pscv.pa_fecha,CURRENT_DATE)<=365 
                  limit 1";
//            echo $sql_1;

    }
    //conocemos si tiene evaluacion durante el ultimo año
//        if($json_coma==0){
//            echo $sql_1."<br /><br />";
//        }


    $row_1 = mysql_fetch_array(mysql_query($sql_1));
    $fecha_json = '';
    if ($row_1) {
        //califica segun edad indicador y valor
        $valor = $estado;
        $valor_json = $row_1['valor_json'];
        $fecha_json = $row_1['fecha_registro'];
        $fecha_json = $persona->buscarUltimoHisotiralPSCV('pa');

        if ($fecha_json == '') {
            $valor_json = 'PENDIENTE';
        } else {
            $date1 = new DateTime($fecha_json);
            $date2 = new DateTime(date('Y-m-d'));
            $diff = $date1->diff($date2);

            if($diff->days>365){
                $estado_json = 'NO VIGENTE';
                $valor_json = $row_1['valor_json'];
            }else{
                $total_indicador++;
                if ($persona->sexo == 'M') {
                    $hombres++;
                } else {
                    $mujeres++;
                }
                $estado_json = 'VIGENTE';
                $valor_json = $row_1['valor_json'];
            }


        }



    } else {

        $estado_json = 'PENDIENTE';
        $valor_json = '';
    }

    $json .= '{"IR":"' . $persona->rut . '","RUT":"' . $persona->rut . '","NOMBRE":"' . $persona->nombre . '","EDAD":"' . $persona->edad . '","COMUNAL":"' . $persona->nombre_sector_comunal . '","ESTABLECIMIENTO":"' . $persona->nombre_centro_medico . '","SECTOR_INTERNO":"' . $persona->nombre_sector_interno . '","INDICADOR":"' . $atributo . '","FECHA":"' . $fecha_json . '","VALOR":"' . $valor_json . '","ESTADO":"' . $estado_json . '","anios":"' . $persona->edad_anios . '","meses":"' . $persona->edad_meses . '","dias":"' . $persona->edad_dias . '"}';
    $total_pacientes++;
    $json_coma++;
}


$porcentaje_indicador = number_format(($total_indicador * 100 / $total_pacientes), 0, '.', '');

$rango .= "\n{ Rango:'GENERAL',GENERAL: " . $porcentaje_indicador . "},";
$series .= " \n{ dataField: 'GENERAL', displayText: '$estado',labels: {visible: true,verticalAlignment: 'top',offset: { x: 0, y: -20 } },formatFunction: function (value) {return value + ' %';} ,total_general:$total_pacientes,total_indicador:$total_indicador,hombres:$hombres,mujeres:$mujeres},";


$estado = $estado == '' ? 'PENDIENTE' : $estado;

?>
<script type="text/javascript">
    $(document).ready(function () {
        // prepare chart data as an array
        var sampleData = [
            <?php echo $rango; ?>
        ];
        var toolTips_DNI = function (value, itemIndex, serie, group, categoryValue, categoryAxis) {
            var dataItem = sampleData[itemIndex];

            return '<DIV style="text-align:left">' +
                '<b>' + serie.displayText + '</b><br />' +
                'Porcentaje: <b>' + value + '%</b><br />' +
                'Datos: <b>' + serie.total_indicador + '/' + serie.total_general + '</b><br />' +
                'Hombres: <b>' + serie.hombres + ' (' + parseInt(serie.hombres * 100 / serie.total_general) + '%)</b><br />' +
                'Mujeres: <b>' + serie.mujeres + ' (' + parseInt(serie.mujeres * 100 / serie.total_general) + '%)</b><br />' +
                '</DIV>';
        };
        var setting = {
            title: 'COMPENSACIÓN',
            description: '<?php echo strtoupper(str_replace("_", " ", $atributo)); ?>',
            enableAnimations: true,
            showLegend: true,
            padding: {left: 5, top: 5, right: 5, bottom: 5},
            titlePadding: {left: 90, top: 0, right: 0, bottom: 10},
            source: sampleData,
            xAxis:
                {
                    dataField: 'Rango',
                    showGridLines: true
                },
            colorScheme: 'scheme01',
            seriesGroups:
                [
                    {
                        type: 'column',
                        toolTipFormatFunction: toolTips_DNI,
                        valueAxis:
                            {
                                unitInterval: 10,
                                minValue: 0,
                                maxValue: 100,
                                displayValueAxis: true,
                                description: 'Porcentaje',
                                axisSize: 'auto',
                                tickMarksColor: '#888888'
                            },
                        series: [
                            <?php echo $series; ?>
                        ]
                    }
                ]
        };
        // setup the chart
        $('#pscv_cobertura').jqxChart(setting);

        function myEventHandler(event) {
            var eventData = '<div><b>Total General: </b>' + event.args.serie.total_general + '<b>, Total Indicador: </b>' + event.args.serie.total_indicador + "</div>";

            //$('#eventText').html(eventData);
            alertaLateral(eventData);
        };


        //grid
        var data = '[<?php echo $json; ?>]';
        var source =
            {
                datatype: "json",
                datafields: [

                    {name: 'IR', type: 'string'},
                    {name: 'RUT', type: 'string'},
                    {name: 'NOMBRE', type: 'string'},
                    {name: 'EDAD', type: 'string'},
                    {name: 'anios', type: 'string'},
                    {name: 'meses', type: 'string'},
                    {name: 'dias', type: 'string'},
                    {name: 'COMUNAL', type: 'string'},
                    {name: 'ESTABLECIMIENTO', type: 'string'},
                    {name: 'ESTADO', type: 'string'},
                    {name: 'SECTOR_INTERNO', type: 'string'},
                    {name: 'CONTACTO', type: 'string'},
                    {name: 'FECHA', type: 'string'},
                    {name: 'INDICADOR', type: 'string'},
                    {name: 'VALOR', type: 'string'},

                ],
                localdata: data
            };
        var cellLinkRegistroTarjetero = function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            return '' +
                '<a onclick="loadMenu_CardioVascular(\'menu_1\',\'registro_atencion\',\'' + value + '\')"  style="color: black;" >' +
                '<i class="mdi-hardware-keyboard-return"></i> IR' +
                '</a>';
        }
        var cellIrClass = function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            return "green center-align cursor_cell_link black-text";

        }

        var dataAdapter = new $.jqx.dataAdapter(source);

        $("#table_grid").jqxGrid(
            {
                width: '95%',
                height: 400,
                source: dataAdapter,
                columnsresize: true,
                sortable: true,
                filterable: true,
                autoshowfiltericon: true,
                showfilterrow: true,
                showstatusbar: true,
                statusbarheight: 30,
                showaggregates: true,
                selectionmode: 'multiplecellsextended',
                columns: [
                    {
                        text: 'IR', dataField: 'IR',
                        cellclassname: cellIrClass,
                        cellsrenderer: cellLinkRegistroTarjetero,
                        cellsalign: 'center', width: 100
                    },
                    {text: 'RUT', dataField: 'RUT', cellsalign: 'right', width: 150},
                    {
                        text: 'NOMBRE COMPLETO', dataField: 'NOMBRE',
                        width: 350,
                        aggregates: ['count'], aggregatesrenderer: function (aggregates, column, element, summaryData) {
                            var renderstring = "<div  style='float: left; width: 100%; height: 100%;'>";
                            $.each(aggregates, function (key, value) {
                                var name = 'Total Pacientes';
                                renderstring += '<div style="; position: relative; margin: 6px; text-align: right; overflow: hidden;">' + name + ': ' + value + '</div>';
                            });
                            renderstring += "</div>";
                            return renderstring;
                        }
                    },
                    {text: 'AÑO', datafield: 'anios', width: 80, filtertype: 'checkedlist', cellsalign: 'center'},
                    {text: 'MES', datafield: 'meses', width: 80, filtertype: 'checkedlist', cellsalign: 'center'},
                    {text: 'DIA', datafield: 'dias', width: 80, filtertype: 'checkedlist', cellsalign: 'center'},
                    {
                        text: '<?php echo $TITULO_GRAFICO; ?>',
                        dataField: 'INDICADOR',
                        cellsalign: 'center',
                        width: 250,
                        filtertype: 'checkedlist'
                    },
                    {text: 'ESTADO', dataField: 'ESTADO', cellsalign: 'center', width: 150, filtertype: 'checkedlist'},
                    {text: 'VALOR', dataField: 'VALOR', cellsalign: 'center', width: 150, filtertype: 'checkedlist'},
                    {text: 'FECHA', dataField: 'FECHA', cellsalign: 'center', width: 110},
                    {
                        text: 'S. COMUNAL',
                        dataField: 'COMUNAL',
                        cellsalign: 'left',
                        width: 250,
                        filtertype: 'checkedlist'
                    },
                    {
                        text: 'ESTABLECIMIENTO',
                        dataField: 'ESTABLECIMIENTO',
                        cellsalign: 'left',
                        width: 250,
                        filtertype: 'checkedlist'
                    },
                    {
                        text: 'SECTOR_INTERNO',
                        dataField: 'SECTOR_INTERNO',
                        cellsalign: 'left',
                        width: 250,
                        filtertype: 'checkedlist'
                    },
                    {text: 'CONTACTO', dataField: 'CONTACTO', cellsalign: 'left', width: 250},

                ]
            });
        $("#excelExport").click(function () {
            $("#table_grid").jqxGrid('exportdata', 'xls', 'Comensacion', true, null, true, 'https://carahue.eh-open.com/exportar/save-file.php');
        });
        $("#print").click(function () {
            var content = $('#pscv_cobertura')[0].outerHTML;
            var newWindow = window.open('', '', 'width=900, height=600'),
                document = newWindow.document.open(),
                pageContent =
                    '<!DOCTYPE html>' +
                    '<html>' +
                    '<head>' +
                    '<meta charset="utf-8" />' +
                    '</head>' +
                    '<body>' + content + '</body></html>';
            try {
                document.write(pageContent);
                document.close();
                newWindow.print();
                newWindow.close();
            } catch (error) {
            }
        });

        $('#edad').jqxDropDownList({
            width: '100%',
            height: '25px'
        });
        $('#edad').on('select', function (event) {
            loadGraficoCompensacion1();
        });

    });

    function loadGraficoCompensacion1() {
        loadGif_graficos('pscv_cobertura');
        $.post('graficos/barra/compensacion.php',
            $("#form_compensacion").serialize(), function (data) {
                $("#header_graficos").html(data);
            });
    }

    function loadGrafico_PSCV_filtro() {

        var sector_comunal = $("#sector_comunal").val();
        var sector_comunal = $("#sector_comunal").val();
        var centro_interno = $("#centro_interno").val();
        var sector_interno = $("#sector_interno").val();
        var edad = $("#edad").val();
        var indicador = $("#indicador").val();
        var atributo = $("#atributo").val();
        var estado = $("#estado").val();
        if (indicador != '') {
            $("#indicador").css({'border': 'none'});
            if (atributo != '') {
                $("#atributo").css({'border': 'none'});
                $("#estado").css({'border': 'none'});
                loadGif_graficos('header_graficos');
                $.post('graficos/barra/' + indicador + '.php', {
                    sector_comunal: sector_comunal,
                    centro_interno: centro_interno,
                    sector_interno: sector_interno,
                    indicador: indicador,
                    atributo: atributo,
                    estado: estado,
                    edad: edad
                }, function (data) {
                    $("#header_graficos").html(data);
                });
            } else {
                alertaLateral('DEBE SELECCIONAR QUE ATRIBUTO DESEA VISUALIZAR');
                $("#atributo").focus();
                $("#atributo").css({'border': 'red solid 2px'});
            }
        } else {
            alertaLateral('DEBE SELECCIONAR QUE TIPO DE INDICADOR DESEA GRAFICAR');
            $("#indicador").focus();
            $("#indicador").css({'border': 'red solid 2px'});
        }

    }

</script>
<style type="text/css">
    @media only screen
    and (min-device-width: 320px)
    and (max-device-width: 800px) {
        /* Aquí van los estilos */
        #tabla_grilla {
            display: none;;
        }
    }
</style>
<div id="div_imprimir">
    <form class="card-panel" id="form_compensacion">
        <input type="hidden" name="atributo" value="<?php echo str_replace('>', '', $_POST['atributo']); ?>"/>
        <input type="hidden" name="sector_comunal" value="<?php echo $_POST['sector_comunal']; ?>"/>
        <input type="hidden" name="centro_interno" value="<?php echo $_POST['centro_interno']; ?>"/>
        <input type="hidden" name="sector_interno" value="<?php echo $_POST['sector_interno']; ?>"/>
        <input type="hidden" name="estado" value="<?php echo $_POST['estado']; ?>"/>
        <div class="row right-align">
            <div class="col l8 m8 s8">
                <select name="edad" id="edad">
                    <?php
                    if ($atributo == 'patologia_dm') {
                        if ($rango_edad == '<(80*12)') {
                            ?>
                            <option value="<(80*12)#< 7%" selected>15 a 79 AÑOS</option>
                            <option value=">=(80*12)#< 8%">DESDE 80 AÑOS</option>
                            <option value=">(15*12)#>= 9%">HBA1C >= 9%</option>
                            <option value=">(12*15)#<%">TODOS COMPENSADOS</option>
                            <?php
                        } else {
                            if ($rango_edad == '>=(80*12)') {
                                ?>
                                <option value="<(80*12)#< 7%">15 a 79 AÑOS</option>
                                <option value=">=(80*12)#< 8%" selected>DESDE 80 AÑOS</option>
                                <option value=">(15*12)#>= 9%">HBA1C >= 9%</option>
                                <option value=">(12*15)#<%">TODOS COMPENSADOS</option>
                                <?php
                            } else {
                                if ($rango_edad == '>(15*12)') {
                                    ?>
                                    <option value="<(80*12)#< 7%">15 a 79 AÑOS</option>
                                    <option value=">=(80*12)#< 8%">DESDE 80 AÑOS</option>
                                    <option value=">(15*12)#>= 9%" selected>HBA1C >= 9%</option>
                                    <option value=">(12*15)#<%">TODOS COMPENSADOS</option>
                                    <?php
                                } else {
                                    ?>
                                    <option value="<(80*12)#< 7%">15 a 79 AÑOS</option>
                                    <option value=">=(80*12)#< 8%">DESDE 80 AÑOS</option>
                                    <option value=">(15*12)#>= 9%">HBA1C >= 9%</option>
                                    <option value=">(12*15) #<%" selected>TODOS COMPENSADOS</option>
                                    <?php
                                }

                            }

                        }
                    } else {
                        if ($rango_edad == '<(80*12)') {
                            ?>
                            <option value="<(80*12)#<140/90 MMHG" selected>15 a 79 AÑOS</option>
                            <option value=">=(80*12)#<150/90 MMHG">DESDE 80 AÑOS</option>
                            <option value=">(15*12)#>=160/100 MMHG">PA >= 160/100 MMHG</option>
                            <option value=">(12*15)#%/90 MMHG%">TODOS COMPENSADOS</option>
                            <?php
                        } else {
                            if ($rango_edad == '>=(80*12)') {
                                ?>
                                <option value="<(80*12)#<140/90 MMHG">15 a 79 AÑOS</option>
                                <option value=">=(80*12)#<150/90 MMHG" selected>DESDE 80 AÑOS</option>
                                <option value=">(15*12)#>=160/100 MMHG">PA >= 160/100 MMHG</option>
                                <option value=">(12*15)#%/90 MMHG%">TODOS COMPENSADOS</option>
                                <?php
                            } else {
                                if ($rango_edad == '>(15*12)') {
                                    ?>
                                    <option value="<(80*12)#<140/90 MMHG">15 a 79 AÑOS</option>
                                    <option value=">=(80*12)#<150/90 MMHG">DESDE 80 AÑOS</option>
                                    <option value=">(15*12)#>=160/100 MMHG" selected>PA >= 160/100 MMHG</option>
                                    <option value=">(12*15)#%/90 MMHG%">TODOS COMPENSADOS</option>
                                    <?php
                                } else {
                                    ?>
                                    <option value="<(80*12)#<140/90 MMHG">15 a 79 AÑOS</option>
                                    <option value=">=(80*12)#<150/90 MMHG">DESDE 80 AÑOS</option>
                                    <option value=">(15*12)#>=160/100 MMHG">PA >= 160/100 MMHG</option>
                                    <option value=">(12*15)#%/90 MMHG%" selected>TODOS COMPENSADOS</option>
                                    <?php
                                }

                            }

                        }
                    }

                    ?>


                </select>
            </div>
            <div class="col l4 m4 s4">

            </div>
        </div>
        <div class="row">
            <div class="col l12 m12 s12">
                <div id='pscv_cobertura' style="width: 100%;height: 500px;"></div>
            </div>
            <div class="col l12 m12 s12">
                <button class="btn" id="print">
                    <i class="mdi-action-print left"></i>
                    IMPRIMIR GRAFICO
                </button>
            </div>
        </div>
    </form>
    <div class="card-panel" style="display: none;">
        <div class="row">
            <div class="col l4 m4 s12">
                <label for="desde">DESDE</label>
                <input type="date" name="desde" id="desde"
                       value="<?php echo (date('Y') - 1) . '-' . date('m') . '-' . date('d'); ?>"/>
            </div>
            <div class="col l4 m4 s12">
                <label for="hasta">HASTA</label>
                <input type="date" name="hasta" id="hasta" value="<?php echo date('Y-m-d'); ?>"/>
            </div>
        </div>
        <div class="row">
            <div class="col l12 m12 s12">
                <div id='pscv_tiempo' style="width: 100%;height: 500px;"></div>
            </div>
        </div>

    </div>
    <div class="card-panel" id="tabla_grilla">
        <div class="row">
            <div class="col l6 m12 s12">
                <button class="btn" id="print_grid">
                    <i class="mdi-action-print left"></i>
                    IMPRIMIR TABLA
                </button>
                <button class="btn" id="excelExport">
                    <i class="mdi-action-open-in-new left"></i>
                    EXPORTAR EXCEL
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col l12 m12 s12">
                <div id="table_grid"></div>
            </div>
        </div>
    </div>
</div>
