<?php
include "../../../../php/config.php";
include "../../../../php/objetos/familia.php";

//session_start();

$id_establecimiento = $_SESSION['id_establecimiento'];


$sector_comunal = explode(",",$_POST['sector_comunal']);
$centro_interno = explode(",",$_POST['centro_interno']);
$sector_interno = explode(",",$_POST['sector_interno']);

$indicador      = $_POST['indicador'];//funcionalidad
$atributo       = $_POST['atributo'];//parametro columna
$indicador = 'FAMILIAS CON EVALUACION DE RIESGO - '.strtoupper($atributo);

if($atributo=='VIGENTES'){
    $filtro = "and familia.fecha_riesgo!='' and TIMESTAMPDIFF(DAY, fecha_riesgo, current_date)<720 ";
}else{
    if($atributo=='NO VIGENTES'){
        $filtro = "and familia.fecha_riesgo!='' and TIMESTAMPDIFF(DAY, fecha_riesgo, current_date)>=720 ";
    }else{
        $filtro = "and familia.fecha_riesgo=''";
    }
}




$TITULO_GRAFICO = strtoupper(str_replace("_"," ",$indicador));




$sql_column = "";



$comunal = $establecimientos = $sectores = false;

if(in_array('TODOS',$sector_comunal)){
    $comunal = true;
//    echo 4;
}else{
    if(in_array('TODOS',$centro_interno)){
        $establecimientos = true;
        $estado = 'SECTORES COMUNALES';
//        echo 3;
    }else{
        if(in_array('TODOS',$sector_interno)){
            $sectores = true;
//            echo 2;
        }else{
//            echo 1;
        }
    }
}

$sql0 = "select count(*) as total from familia where id_establecimiento=1 ";
$row0 = mysql_fetch_array(mysql_query($sql0));
if($row0){
    $total_general_familias = $row0['total'];
}else{
    $total_general_familias = 1;
}



$rango = '';
$series = '';
$json = '';
$json_coma = 0;
$total_indicador = 0;
$estado = '';
if($comunal==true){
    //total pacientes
    $sql_0 = "select *  from familia
                        inner join sectores_centros_internos on familia.id_sector=sectores_centros_internos.id_sector_centro_interno
                        inner join centros_internos on centros_internos.id_centro_interno=sectores_centros_internos.id_centro_interno
                        inner join sector_comunal on sector_comunal.id_sector_comunal=centros_internos.id_sector_comunal
                        where  familia.id_establecimiento='$id_establecimiento'
                        $filtro ";

    $res_0  = mysql_query($sql_0);
    $total_familias = 0;
    $total_pacientes = 0;
    $total_pendiente = 0;
    $total_hombres = 0;
    $total_mujeres = 0;
    $hombres_pendientes = 0;
    $mujeres_pendientes = 0;
    $hombres = 0;
    $mujeres = 0;
    while ($row_0 = mysql_fetch_array($res_0)){
        $familia = new familia($row_0['id_familia']);
        if($json_coma>0){
            $json.=',';
        }
        $sql1 = "select sum(p.sexo='M') as hombres,
                sum(p.sexo='F') as mujeres
                from integrante_familia
                inner join persona p on integrante_familia.rut = p.rut
                where id_familia='$familia->id_familia'";


        $row1 = mysql_fetch_array(mysql_query($sql1));
        if($row1){
            $hombres = $row1['hombres']==''?0:$row1['hombres'];
            $mujeres = $row1['mujeres']==''?0:$row1['mujeres'];
        }else{
            $hombres = 0;
            $mujeres = 0;
        }
        $total_hombres += $hombres;
        $total_mujeres += $mujeres;
        $total_pacientes += $hombres+$mujeres;





        $json .= '{"IR":"'.$familia->id_familia.'","ESTADO":"RIESGO '.$atributo.'","CODIGO":"'.$familia->codigo_familia.'","NOMBRE":"'.$familia->nombre.'","COMUNAL":"'.$familia->nombre_sector_comunal.'","ESTABLECIMIENTO":"'.$familia->nombre_centro.'","SECTOR_INTERNO":"'.$familia->nombre_establecimiento.'"}';

        $total_familias++;
        $json_coma++;
    }
    //para todos los sectores comunales


    $porcentaje_indicador = $total_familias*100/$total_general_familias;

    $rango .= "\n{ Rango:'GENERAL',GENERAL: ".$porcentaje_indicador."},";
    $series .=" \n{ dataField: 'GENERAL', displayText: '$estado',labels: {visible: true,verticalAlignment: 'top',offset: { x: 0, y: -20 } },formatFunction: function (value) {return value + ' %';} ,total_general:$total_pacientes,hombres:$total_hombres,mujeres:$total_mujeres,total_familias:$total_familias},";


}else{
    if($establecimientos==true){



        //para todos los establecimientos pero segun el sector comunal seleccionado
        $sql1 = "select
                        sector_comunal.nombre_sector_comunal as nombre_base,
                        sector_comunal.id_sector_comunal as id
                        from familia
                        inner join sectores_centros_internos on familia.id_sector=sectores_centros_internos.id_sector_centro_interno
                        inner join centros_internos on centros_internos.id_centro_interno=sectores_centros_internos.id_centro_interno
                        inner join sector_comunal on sector_comunal.id_sector_comunal=centros_internos.id_sector_comunal    
                        where familia.id_establecimiento='1' 
                                    AND (";

        $a = 0;
        foreach ($sector_comunal as $i => $id_sector_comunal){
            $id_sector_comunal = trim($id_sector_comunal);
            if($id_sector_comunal!='' && $id_sector_comunal != null){
                if($a>0){
                    $sql1.=' or ';
                }
                $sql1 .= "centros_internos.id_sector_comunal='$id_sector_comunal' ";
                $a++;
            }

        }
        $sql1.=') 
        group by centros_internos.id_sector_comunal ';


        $res1 = mysql_query($sql1);
        $rango .= "{ Rango:'COMUNAL', ";
        $dato = 0;
        while($row1 = mysql_fetch_array($res1)){
            $nombre_base = $row1['nombre_base'];
            $id = trim($row1['id']); // id_sector_comunal

            if($dato>0){
                $rango.=',';
                $series.=',';
            }

            //total pacientes
            $sql_0 = "select *  from familia
                        inner join sectores_centros_internos on familia.id_sector=sectores_centros_internos.id_sector_centro_interno
                        inner join centros_internos on centros_internos.id_centro_interno=sectores_centros_internos.id_centro_interno
                        inner join sector_comunal on sector_comunal.id_sector_comunal=centros_internos.id_sector_comunal
                        where  familia.id_establecimiento='$id_establecimiento'
                        AND sector_comunal.id_sector_comunal='$id' 
                        $filtro ";

            $res_0  = mysql_query($sql_0);
            $total_familias = 0;
            $total_pacientes = 0;
            $total_pendiente = 0;
            $total_hombres = 0;
            $total_mujeres = 0;
            $hombres_pendientes = 0;
            $mujeres_pendientes = 0;
            $hombres = 0;
            $mujeres = 0;
            while ($row_0 = mysql_fetch_array($res_0)){
                $familia = new familia($row_0['id_familia']);
                if($json_coma>0){
                    $json.=',';
                }
                $sql1 = "select sum(p.sexo='M') as hombres,
                sum(p.sexo='F') as mujeres
                from integrante_familia
                inner join persona p on integrante_familia.rut = p.rut
                where id_familia='$familia->id_familia'";


                $row1 = mysql_fetch_array(mysql_query($sql1));
                if($row1){
                    $hombres = $row1['hombres']==''?0:$row1['hombres'];
                    $mujeres = $row1['mujeres']==''?0:$row1['mujeres'];
                }else{
                    $hombres = 0;
                    $mujeres = 0;
                }
                $total_hombres += $hombres;
                $total_mujeres += $mujeres;
                $total_pacientes += $hombres+$mujeres;

                $json .= '{"IR":"'.$familia->id_familia.'","ESTADO":"RIESGO '.$atributo.'","CODIGO":"'.$familia->codigo_familia.'","NOMBRE":"'.$familia->nombre.'","COMUNAL":"'.$familia->nombre_sector_comunal.'","ESTABLECIMIENTO":"'.$familia->nombre_centro.'","SECTOR_INTERNO":"'.$familia->nombre_establecimiento.'"}';

                $total_familias++;
                $json_coma++;
            }
            //para todos los sectores comunales



//            $series .=" { dataField: '$id', displayText: '$nombre_base',labels: {visible: true,verticalAlignment: 'top',offset: { x: 0, y: -20 } } ,formatFunction: function (value) {return value + ' %';},total_general:$total_pacientes,hombres:$total_hombres,mujeres:$total_mujeres,total_familias:$total_familias},";
//            $rango .= ", $id:$porcentaje_indicador";

            $series .=" \n{ dataField: '$id', displayText: '$nombre_base',
                    labels: {visible: true,verticalAlignment: 'top',offset: { x: 0, y: -20 } },
                    formatFunction: function (value) {return value + ' %';} ,
                    total_general:$total_pacientes,
                    hombres:$total_hombres,
                    mujeres:$total_mujeres,
                    total_familias:$total_familias}";

            $rango .= "\n$id: ".number_format($total_familias*100/$total_general_familias,2,'.',',')."";


            $dato++;

        }
        $rango .= "}";


    }else{
        if($sectores==true){
            //para todos los centros interno
            $sql1 = "select
                        centros_internos.nombre_centro_interno as nombre_base,
                        sector_comunal.nombre_sector_comunal as nombre_establecimiento,
                        centros_internos.id_centro_interno as id
                        from familia
                        inner join sectores_centros_internos on familia.id_sector=sectores_centros_internos.id_sector_centro_interno
                        inner join centros_internos on centros_internos.id_centro_interno=sectores_centros_internos.id_centro_interno
                        inner join sector_comunal on sector_comunal.id_sector_comunal=centros_internos.id_sector_comunal    
                        where familia.id_establecimiento='1' 
                                    AND (";
            $a = 0;
            foreach ($centro_interno as $i => $id_centro_interno){
                $id_centro_interno = trim($id_centro_interno);
                if($id_centro_interno!='' && $id_centro_interno != null){
                    if($a>0){
                        $sql1.=' or ';
                    }
                    $sql1 .= "centros_internos.id_centro_interno='$id_centro_interno' ";
                    $a++;
                }

            }
            $sql1.=') 
                    group by centros_internos.id_centro_interno ';


            $res1 = mysql_query($sql1);

            $rango .= "{ Rango:'CENTRO MEDICO',";

            while($row1 = mysql_fetch_array($res1)){
                $nombre_base = $row1['nombre_base']." [".$row1['nombre_establecimiento']."]";
                $id = trim($row1['id']); // id_sector_comunal
                if($dato>0){
                    $rango.=',';
                    $series.=',';
                }

                //total pacientes
                $sql_0 = "select *  from familia
                        inner join sectores_centros_internos on familia.id_sector=sectores_centros_internos.id_sector_centro_interno
                        inner join centros_internos on centros_internos.id_centro_interno=sectores_centros_internos.id_centro_interno
                        inner join sector_comunal on sector_comunal.id_sector_comunal=centros_internos.id_sector_comunal
                        where  familia.id_establecimiento='$id_establecimiento'
                        AND centros_internos.id_centro_interno='$id' 
                        $filtro ";

                $res_0  = mysql_query($sql_0);
                $total_familias = 0;
                $total_pacientes = 0;
                $total_pendiente = 0;
                $total_hombres = 0;
                $total_mujeres = 0;
                $hombres_pendientes = 0;
                $mujeres_pendientes = 0;
                $hombres = 0;
                $mujeres = 0;
                while ($row_0 = mysql_fetch_array($res_0)){
                    $familia = new familia($row_0['id_familia']);
                    if($json_coma>0){
                        $json.=',';
                    }
                    $sql1 = "select sum(p.sexo='M') as hombres,
                sum(p.sexo='F') as mujeres
                from integrante_familia
                inner join persona p on integrante_familia.rut = p.rut
                where id_familia='$familia->id_familia'";


                    $row1 = mysql_fetch_array(mysql_query($sql1));
                    if($row1){
                        $hombres = $row1['hombres']==''?0:$row1['hombres'];
                        $mujeres = $row1['mujeres']==''?0:$row1['mujeres'];
                    }else{
                        $hombres = 0;
                        $mujeres = 0;
                    }
                    $total_hombres += $hombres;
                    $total_mujeres += $mujeres;
                    $total_pacientes += $hombres+$mujeres;

                    $json .= '{"IR":"'.$familia->id_familia.'","ESTADO":"RIESGO '.$atributo.'","CODIGO":"'.$familia->codigo_familia.'","NOMBRE":"'.$familia->nombre.'","COMUNAL":"'.$familia->nombre_sector_comunal.'","ESTABLECIMIENTO":"'.$familia->nombre_centro.'","SECTOR_INTERNO":"'.$familia->nombre_establecimiento.'"}';

                    $total_familias++;
                    $json_coma++;
                }
                //para todos los sectores comunales



//            $series .=" { dataField: '$id', displayText: '$nombre_base',labels: {visible: true,verticalAlignment: 'top',offset: { x: 0, y: -20 } } ,formatFunction: function (value) {return value + ' %';},total_general:$total_pacientes,hombres:$total_hombres,mujeres:$total_mujeres,total_familias:$total_familias},";
//            $rango .= ", $id:$porcentaje_indicador";

                $series .=" \n{ dataField: '$id', displayText: '$nombre_base',
                    labels: {visible: true,verticalAlignment: 'top',offset: { x: 0, y: -20 } },
                    formatFunction: function (value) {return value + ' %';} ,
                    total_general:$total_pacientes,
                    hombres:$total_hombres,
                    mujeres:$total_mujeres,
                    total_familias:$total_familias}";

                $rango .= "\n$id: ".number_format($total_familias*100/$total_general_familias,2,'.',',')."";


                $dato++;

            }
            $rango .= "}";





        }else{
            //para todos los sectores internos seleccionados
            $sql1 = "select 
                                    sectores_centros_internos.nombre_sector_interno as nombre_base,
                                    sectores_centros_internos.id_sector_centro_interno as id,
                                    centros_internos.nombre_centro_interno as nombre_establecimiento
                                    from familia
                                    inner join sectores_centros_internos on familia.id_sector=sectores_centros_internos.id_sector_centro_interno
                                    inner join centros_internos on centros_internos.id_centro_interno=sectores_centros_internos.id_centro_interno
                                    inner join sector_comunal on sector_comunal.id_sector_comunal=centros_internos.id_sector_comunal    
                                    where  familia.id_establecimiento=1 
                                    and (";
            $a = 0;
            foreach ($sector_interno as $i => $id_sector_interno){
                $id_sector_interno = trim($id_sector_interno);
                if($id_sector_interno!='' && $id_sector_interno != null){
                    if($a>0){
                        $sql1.=' or ';
                    }
                    $sql1 .= "sectores_centros_internos.id_sector_centro_interno='$id_sector_interno' ";
                    $a++;
                }

            }
            $sql1.=') 
        group by sectores_centros_internos.id_sector_centro_interno';



            $res1 = mysql_query($sql1);

            $rango .= "{ Rango:'".$estado."', ";
            while($row1 = mysql_fetch_array($res1)){
                $nombre_base = $row1['nombre_base']." [".$row1['nombre_establecimiento']."]";
                $id = trim($row1['id']); // id_sector_comunal

                if($dato>0){
                    $rango.=',';
                    $series.=',';
                }

                //total pacientes
                $sql_0 = "select *  from familia
                        inner join sectores_centros_internos on familia.id_sector=sectores_centros_internos.id_sector_centro_interno
                        inner join centros_internos on centros_internos.id_centro_interno=sectores_centros_internos.id_centro_interno
                        inner join sector_comunal on sector_comunal.id_sector_comunal=centros_internos.id_sector_comunal
                        where  familia.id_establecimiento='$id_establecimiento'
                        AND sectores_centros_internos.id_sector_centro_interno='$id' 
                        $filtro ";

                $res_0  = mysql_query($sql_0);
                $total_familias = 0;
                $total_pacientes = 0;
                $total_pendiente = 0;
                $total_hombres = 0;
                $total_mujeres = 0;
                $hombres_pendientes = 0;
                $mujeres_pendientes = 0;
                $hombres = 0;
                $mujeres = 0;
                while ($row_0 = mysql_fetch_array($res_0)){
                    $familia = new familia($row_0['id_familia']);
                    if($json_coma>0){
                        $json.=',';
                    }
                    $sql1 = "select sum(p.sexo='M') as hombres,
                sum(p.sexo='F') as mujeres
                from integrante_familia
                inner join persona p on integrante_familia.rut = p.rut
                where id_familia='$familia->id_familia'";


                    $row1 = mysql_fetch_array(mysql_query($sql1));
                    if($row1){
                        $hombres = $row1['hombres']==''?0:$row1['hombres'];
                        $mujeres = $row1['mujeres']==''?0:$row1['mujeres'];
                    }else{
                        $hombres = 0;
                        $mujeres = 0;
                    }
                    $total_hombres += $hombres;
                    $total_mujeres += $mujeres;
                    $total_pacientes += $hombres+$mujeres;

                    $json .= '{"IR":"'.$familia->id_familia.'","ESTADO":"RIESGO '.$atributo.'","CODIGO":"'.$familia->codigo_familia.'","NOMBRE":"'.$familia->nombre.'","COMUNAL":"'.$familia->nombre_sector_comunal.'","ESTABLECIMIENTO":"'.$familia->nombre_centro.'","SECTOR_INTERNO":"'.$familia->nombre_establecimiento.'"}';

                    $total_familias++;
                    $json_coma++;
                }
                //para todos los sectores comunales



//            $series .=" { dataField: '$id', displayText: '$nombre_base',labels: {visible: true,verticalAlignment: 'top',offset: { x: 0, y: -20 } } ,formatFunction: function (value) {return value + ' %';},total_general:$total_pacientes,hombres:$total_hombres,mujeres:$total_mujeres,total_familias:$total_familias},";
//            $rango .= ", $id:$porcentaje_indicador";

                $series .=" \n{ dataField: '$id', displayText: '$nombre_base',
                    labels: {visible: true,verticalAlignment: 'top',offset: { x: 0, y: -20 } },
                    formatFunction: function (value) {return value + ' %';} ,
                    total_general:$total_pacientes,
                    hombres:$total_hombres,
                    mujeres:$total_mujeres,
                    total_familias:$total_familias}";

                $rango .= "\n$id: ".number_format($total_familias*100/$total_general_familias,2,'.',',')."";


                $dato++;

            }
            $rango .= "}";


        }
    }
}

$estado = $estado=='' ? 'PENDIENTE':$estado;

?>
<script type="text/javascript">
    $(document).ready(function () {
        // prepare chart data as an array
        var  sampleData = [
            <?php echo $rango; ?>
        ];
        var toolTips_DNI = function (value, itemIndex, serie, group, categoryValue, categoryAxis) {
            var dataItem = sampleData[itemIndex];

            return '<DIV style="text-align:left">' +
                '<b>RESUMEN</b><br />'+
                'Total Familias: <b>' +serie.total_familias+'</b><br />'+
                'Total Integrantes: <b>' +serie.total_general+'</b><br />'+
                'Hombres: <b>' +serie.hombres+' ('+parseInt(serie.hombres*100/serie.total_general) +'%)</b><br />'+
                'Mujeres: <b>' +serie.mujeres+' ('+parseInt(serie.mujeres*100/serie.total_general) +'%)</b><br />'+
                '</DIV>';
        };
        var setting = {
            title: '<?php echo $TITULO_GRAFICO; ?>',
            description: '<?php echo ''; ?>',
            enableAnimations: true,
            showLegend: true,
            padding: { left: 5, top: 5, right: 5, bottom: 5 },
            titlePadding: { left: 90, top: 0, right: 0, bottom: 10 },
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

                    { name: 'IR', type: 'string' },
                    { name: 'CODIGO', type: 'string' },
                    { name: 'NOMBRE', type: 'string' },
                    { name: 'ESTADO', type: 'string' },
                    { name: 'COMUNAL', type: 'string' },
                    { name: 'ESTABLECIMIENTO', type: 'string' },
                    { name: 'SECTOR_INTERNO', type: 'string' },
                    { name: 'CONTACTO', type: 'string' },
                    { name: 'INDICADOR', type: 'string' },

                ],
                localdata: data
            };
        var cellLinkRegistroTarjetero = function(row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            return '<i onclick="loadMenu_M(\'menu_3\',\'registro_familia\',\''+value+'\')" ' +
                '   class="mdi-hardware-keyboard-return"></i> ' +
                '<span onclick="loadMenu_M(\'menu_3\',\'registro_familia\',\''+value+'\')">IR</span>';
        }
        var cellIrClass = function(row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            return  "eh-open_principal white-text cursor_cell_link center";

        }

        var dataAdapter = new $.jqx.dataAdapter(source);

        $("#table_grid").jqxGrid(
            {
                width: '95%',
                height:400,
                theme: 'eh-open',
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
                    { text: 'IR', dataField: 'IR',
                        cellclassname:cellIrClass,
                        cellsrenderer:cellLinkRegistroTarjetero,
                        cellsalign: 'center', width: 100 },
                    { text: 'CODIGO', dataField: 'CODIGO', cellsalign: 'right', width: 150 },
                    { text: 'NOMBRE COMPLETO', dataField: 'NOMBRE' ,
                        width: 350,
                        aggregates: ['count'],aggregatesrenderer: function (aggregates, column, element, summaryData) {
                            var renderstring = "<div  style='float: left; width: 100%; height: 100%;'>";
                            $.each(aggregates, function (key, value) {
                                var name = 'Total Pacientes';
                                renderstring += '<div style="; position: relative; margin: 6px; text-align: right; overflow: hidden;">' + name + ': ' + value + '</div>';
                            });
                            renderstring += "</div>";
                            return renderstring;
                        }},

                    { text: 'PARAMETRO', dataField: 'ESTADO', cellsalign: 'left', width: 250,filtertype: 'checkedlist' },
                    { text: 'S. COMUNAL', dataField: 'COMUNAL', cellsalign: 'left', width: 250,filtertype: 'checkedlist' },
                    { text: 'ESTABLECIMIENTO', dataField: 'ESTABLECIMIENTO', cellsalign: 'left', width: 250,filtertype: 'checkedlist' },
                    { text: 'SECTOR_INTERNO', dataField: 'SECTOR_INTERNO', cellsalign: 'left', width: 250,filtertype: 'checkedlist' },
                    { text: 'CONTACTO', dataField: 'CONTACTO', cellsalign: 'left', width: 250},

                ]
            });
        $("#excelExport").click(function () {
            $("#table_grid").jqxGrid('exportdata', 'xls', '<?php echo $TITULO_GRAFICO; ?>', true,null,true, 'https://carahue.eh-open.com/exportar/save-file.php');
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
            try
            {
                document.write(pageContent);
                document.close();
                newWindow.print();
                newWindow.close();
            }
            catch (error) {
            }
        });
    });
</script>
<div id="div_imprimir">
    <div class="row right-align">
        <button class="btn" id="print">
            <i class="mdi-action-print left"></i>
            IMPRIMIR GRAFICO
        </button>
    </div>
    <div class="card-panel">
        <div class="row">
            <div class="col l12 m12 s12">
                <div id='pscv_cobertura' style="width: 100%;height: 500px;"></div>
            </div>
        </div>
    </div>
    <div class="card-panel" style="display: none;">
        <div class="row">
            <div class="col l4 m4 s12">
                <label for="desde">DESDE</label>
                <input type="date" name="desde" id="desde" value="<?php echo (date('Y')-1).'-'.date('m').'-'.date('d'); ?>" />
            </div>
            <div class="col l4 m4 s12">
                <label for="hasta">HASTA</label>
                <input type="date" name="hasta" id="hasta" value="<?php echo date('Y-m-d'); ?>" />
            </div>
        </div>
        <div class="row">
            <div class="col l12 m12 s12">
                <div id='pscv_tiempo' style="width: 100%;height: 500px;"></div>
            </div>
        </div>

    </div>
    <div class="card-panel">
        <div class="row">
            <div class="col l6 m12 s12">
                <button class="btn" id="print_grid">
                    <i class="mdi-action-print left"></i>
                    IMPRIMIR TABLA
                </button>
                <button class="btn" id="excelExport" >
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
