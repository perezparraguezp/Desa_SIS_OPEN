<?php
include "../../../../php/config.php";
include "../../../../php/objetos/persona.php";

//session_start();

$id_establecimiento = $_SESSION['id_establecimiento'];


$sector_comunal = explode(",",$_POST['sector_comunal']);
$centro_interno = explode(",",$_POST['centro_interno']);
$sector_interno = explode(",",$_POST['sector_interno']);

$indicador      = $_POST['indicador'];//funcionalidad
$atributo       = $_POST['atributo'];//parametro
$valor_diagnostico       = $_POST['valores'];//parametro
$sql_extra = "select * from valor_diagnostico_sm inner join tipo_diagnostico_sm tds on valor_diagnostico_sm.id_tipo = tds.id_tipo
where nombre_tipo='$atributo'";
$res_extra = mysql_query($sql_extra);
$option_grafico = '<option>TODO</option>';
while($row_extra = mysql_fetch_array($res_extra)){
    $option_grafico .= '<option>'.$row_extra['valor'].'</option>';
}
if($valor_diagnostico==''){
    $valor_diagnostico = 'TODO';
}else{

}


$TITULO_GRAFICO = strtoupper(str_replace("_"," ",$indicador.'_'.$valor_diagnostico));


$filtro = '';

$sql_column = "";


$comunal = $establecimientos = $sectores = false;

if(in_array('TODOS',$sector_comunal)){
    $comunal = true;
}else{
    if(in_array('TODOS',$centro_interno)){
        $establecimientos = true;
    }else{
        if(in_array('TODOS',$sector_interno)){
            $sectores = true;
        }
    }
}

$rango = '';
$series = '';
$json = '';
$json_coma = 0;

$estado = '';
if($comunal==true){
    //total pacientes
    $sql_0 = "select *  from persona 
                                    inner join paciente_establecimiento using(rut) 
                                    inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                    inner join centros_internos on sectores_centros_internos.id_centro_interno=centros_internos.id_centro_interno
                                    inner join sector_comunal on centros_internos.id_sector_comunal=sector_comunal.id_sector_comunal
                                    where m_salud_mental='SI' and persona.rut!='' and paciente_establecimiento.id_establecimiento='$id_establecimiento' 
                                     ";
    $res_0  = mysql_query($sql_0);
    $total_pacientes = 0;
    $total_pendiente = 0;
    $total_vigente = 0;
    $hombres_pendientes = 0;
    $mujeres_pendientes = 0;
    $hombres = 0;
    $mujeres = 0;
    while ($row_0 = mysql_fetch_array($res_0)){
        $persona = new persona($row_0['rut']);
        if($json_coma>0){
            $json.=',';
        }
        if($valor_diagnostico!='TODO'){
            $sql_1 = "select * from paciente_diagnosticos_sm 
                    inner join tipo_diagnostico_sm on paciente_diagnosticos_sm.id_tipo=tipo_diagnostico_sm.id_tipo
                    inner join valor_diagnostico_sm on tipo_diagnostico_sm.id_tipo=valor_diagnostico_sm.id_tipo
                    where rut='$persona->rut' and ( fecha_egreso='' or  fecha_egreso is null)
                    and nombre_tipo='$atributo' and valor_tipo='$valor_diagnostico' 
                    limit 1";

        }else{
            $sql_1 = "select * from paciente_diagnosticos_sm 
                    inner join tipo_diagnostico_sm on paciente_diagnosticos_sm.id_tipo=tipo_diagnostico_sm.id_tipo 
                    where rut='$persona->rut' and ( fecha_egreso='' or  fecha_egreso is null)
                    and nombre_tipo='$atributo'
                    limit 1";
        }


        $row_1 = mysql_fetch_array(mysql_query($sql_1));
        if($row_1){
            $fecha = fechaNormal($row_1['fecha_inicio']);
            $indicador_json = $row_1['nombre_tipo'].' ['.$row_1['valor_tipo'].']';

            $total_vigente++;
            if($persona->sexo=='M'){
                $hombres++;
            }else{
                $mujeres++;
            }

        }else{
            $indicador_json = 'SIN REGISTRO';
            $total_pendiente++;
            if($persona->sexo=='M'){
                $hombres_pendientes++;
            }else{
                $mujeres_pendientes++;
            }
        }

        $json .= '{"IR":"'.$persona->rut.'","RUT":"'.$persona->rut.'","NOMBRE":"'.$persona->nombre.'","EDAD":"'.$persona->edad.'","COMUNAL":"'.$persona->nombre_sector_comunal.'","ESTABLECIMIENTO":"'.$persona->nombre_centro_medico.'","SECTOR_INTERNO":"'.$persona->nombre_sector_interno.'","INDICADOR":"'.$indicador_json.'","anios":"'.$persona->edad_anios.'","meses":"'.$persona->edad_meses.'","dias":"'.$persona->edad_dias.'"}';
        $total_pacientes++;
        $json_coma++;
    }
    //para todos los sectores comunales


    $porcentaje_indicador = number_format(($total_vigente*100/$total_pacientes),0,'.','');

    $rango .= "\n{ Rango:'GENERAL',GENERAL: ".$porcentaje_indicador."},";
    $series .=" \n{ dataField: 'GENERAL', displayText: '$estado',labels: {visible: true,verticalAlignment: 'top',offset: { x: 0, y: -20 } },formatFunction: function (value) {return value + ' %';} ,total_general:$total_pacientes,total_indicador:$total_vigente,hombres:$hombres,mujeres:$mujeres},";


}else{
    if($establecimientos==true){

        //para todos los establecimientos pero segun el sector comunal seleccionado
        $sql1 = "select sector_comunal.nombre_sector_comunal as nombre_base,
                        sector_comunal.id_sector_comunal as id 
                                    from persona
                                    inner join paciente_establecimiento using (rut)
                                    inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                    inner join centros_internos on sectores_centros_internos.id_centro_interno=centros_internos.id_centro_interno
                                    inner join sector_comunal on centros_internos.id_sector_comunal=sector_comunal.id_sector_comunal  
                                    where m_salud_mental='SI' 
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
        $rango .= "{ Rango:'".$estado."' ";
        $dato = 0;
        while($row1 = mysql_fetch_array($res1)){
            $nombre_base = $row1['nombre_base'];
            $id = trim($row1['id']); // id_sector_comunal

            //total pacientes
            $sql_0 = "select *  from persona 
                                    inner join paciente_establecimiento using(rut) 
                                    inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                    inner join centros_internos on sectores_centros_internos.id_centro_interno=centros_internos.id_centro_interno
                                    inner join sector_comunal on centros_internos.id_sector_comunal=sector_comunal.id_sector_comunal
                                    where m_salud_mental='SI' and persona.rut!='' and paciente_establecimiento.id_establecimiento='$id_establecimiento' 
                                    and sector_comunal.id_sector_comunal='$id' ";
            $res_0  = mysql_query($sql_0);
            $total_pacientes = 0;
            $total_pendiente = 0;
            $total_vigente = 0;
            $hombres_pendientes = 0;
            $mujeres_pendientes = 0;
            $hombres = 0;
            $mujeres = 0;
            while ($row_0 = mysql_fetch_array($res_0)){
                $persona = new persona($row_0['rut']);
                if($json_coma>0){
                    $json.=',';
                }
                if($valor_diagnostico!='TODO'){
                    $sql_1 = "select * from paciente_diagnosticos_sm 
                    inner join tipo_diagnostico_sm on paciente_diagnosticos_sm.id_tipo=tipo_diagnostico_sm.id_tipo
                    inner join valor_diagnostico_sm on tipo_diagnostico_sm.id_tipo=valor_diagnostico_sm.id_tipo
                    where rut='$persona->rut' and ( fecha_egreso='' or  fecha_egreso is null)
                    and nombre_tipo='$atributo' and valor_tipo='$valor_diagnostico' 
                    limit 1";

                }else{
                    $sql_1 = "select * from paciente_diagnosticos_sm 
                    inner join tipo_diagnostico_sm on paciente_diagnosticos_sm.id_tipo=tipo_diagnostico_sm.id_tipo 
                    where rut='$persona->rut' and ( fecha_egreso='' or  fecha_egreso is null)
                    and nombre_tipo='$atributo'
                    limit 1";
                }

                $row_1 = mysql_fetch_array(mysql_query($sql_1));
                if($row_1){
                    $fecha = fechaNormal($row_1['fecha_inicio']);
                    $indicador_json = $row_1['nombre_tipo'].' ['.$row_1['valor_tipo'].']';
                    $total_vigente++;
                    if($persona->sexo=='M'){
                        $hombres++;
                    }else{
                        $mujeres++;
                    }

                }else{
                    $indicador_json = 'SIN REGISTRO';
                    $total_pendiente++;
                    if($persona->sexo=='M'){
                        $hombres_pendientes++;
                    }else{
                        $mujeres_pendientes++;
                    }
                }

                $json .= '{"IR":"'.$persona->rut.'","RUT":"'.$persona->rut.'","NOMBRE":"'.$persona->nombre.'","EDAD":"'.$persona->edad.'","COMUNAL":"'.$persona->nombre_sector_comunal.'","ESTABLECIMIENTO":"'.$persona->nombre_centro_medico.'","SECTOR_INTERNO":"'.$persona->nombre_sector_interno.'","INDICADOR":"'.$indicador_json.'","anios":"'.$persona->edad_anios.'","meses":"'.$persona->edad_meses.'","dias":"'.$persona->edad_dias.'"}';
                $total_pacientes++;
                $json_coma++;
            }

            $porcentaje_indicador = number_format(($total_vigente*100/$total_pacientes),0,'.','');

            $series .=" { dataField: '$id', displayText: '$nombre_base',labels: {visible: true,verticalAlignment: 'top',offset: { x: 0, y: -20 } } ,formatFunction: function (value) {return value + ' %';},total_general:$total_pacientes,total_indicador:$total_vigente,hombres:$hombres,mujeres:$mujeres},";
            $rango .= ", $id:$porcentaje_indicador";

        }
        $rango .= "},";


    }else{
        if($sectores==true){
            //para todos los centros interno
            $sql1 = "select 
                                    centros_internos.nombre_centro_interno as nombre_base,
                                    sector_comunal.nombre_sector_comunal as nombre_establecimiento,
                                    centros_internos.id_centro_interno as id 
                                    from persona
                                    inner join paciente_establecimiento using (rut)
                                    inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                    inner join centros_internos on sectores_centros_internos.id_centro_interno=centros_internos.id_centro_interno
                                    inner join sector_comunal on centros_internos.id_sector_comunal=sector_comunal.id_sector_comunal
                                    where m_salud_mental='SI' 
                                    and (";
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

            $rango .= "{ Rango:'".$estado."'";

            while($row1 = mysql_fetch_array($res1)){
                $nombre_base = $row1['nombre_base']." [".$row1['nombre_establecimiento']."]";
                $id = trim($row1['id']); // id_sector_comunal
                //total pacientes
                $sql_0 = "select *  from persona 
                                    inner join paciente_establecimiento using(rut) 
                                    inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                    inner join centros_internos on sectores_centros_internos.id_centro_interno=centros_internos.id_centro_interno
                                    inner join sector_comunal on centros_internos.id_sector_comunal=sector_comunal.id_sector_comunal
                                    where m_salud_mental='SI' and persona.rut!='' and paciente_establecimiento.id_establecimiento='$id_establecimiento' 
                                    and centros_internos.id_centro_interno='$id' ";
                $res_0  = mysql_query($sql_0);
                $total_pacientes = 0;
                $total_pendiente = 0;
                $total_vigente = 0;
                $hombres_pendientes = 0;
                $mujeres_pendientes = 0;
                $hombres = 0;
                $mujeres = 0;
                while ($row_0 = mysql_fetch_array($res_0)){
                    $persona = new persona($row_0['rut']);
                    if($json_coma>0){
                        $json.=',';
                    }
                    if($valor_diagnostico!='TODO'){
                        $sql_1 = "select * from paciente_diagnosticos_sm 
                    inner join tipo_diagnostico_sm on paciente_diagnosticos_sm.id_tipo=tipo_diagnostico_sm.id_tipo
                    inner join valor_diagnostico_sm on tipo_diagnostico_sm.id_tipo=valor_diagnostico_sm.id_tipo
                    where rut='$persona->rut' and ( fecha_egreso='' or  fecha_egreso is null)
                    and nombre_tipo='$atributo' and valor_tipo='$valor_diagnostico' 
                    limit 1";

                    }else{
                        $sql_1 = "select * from paciente_diagnosticos_sm 
                    inner join tipo_diagnostico_sm on paciente_diagnosticos_sm.id_tipo=tipo_diagnostico_sm.id_tipo 
                    where rut='$persona->rut' and ( fecha_egreso='' or  fecha_egreso is null)
                    and nombre_tipo='$atributo'
                    limit 1";
                    }
                    $row_1 = mysql_fetch_array(mysql_query($sql_1));
                    if($row_1){
                        $fecha = fechaNormal($row_1['fecha_inicio']);
                        $indicador_json = $row_1['nombre_tipo'].' ['.$row_1['valor_tipo'].']';
                        $total_vigente++;
                        if($persona->sexo=='M'){
                            $hombres++;
                        }else{
                            $mujeres++;
                        }

                    }else{
                        $indicador_json = 'SIN REGISTRO';
                        $total_pendiente++;
                        if($persona->sexo=='M'){
                            $hombres_pendientes++;
                        }else{
                            $mujeres_pendientes++;
                        }
                    }

                    $json .= '{"IR":"'.$persona->rut.'","RUT":"'.$persona->rut.'","NOMBRE":"'.$persona->nombre.'","EDAD":"'.$persona->edad.'","COMUNAL":"'.$persona->nombre_sector_comunal.'","ESTABLECIMIENTO":"'.$persona->nombre_centro_medico.'","SECTOR_INTERNO":"'.$persona->nombre_sector_interno.'","INDICADOR":"'.$indicador_json.'","anios":"'.$persona->edad_anios.'","meses":"'.$persona->edad_meses.'","dias":"'.$persona->edad_dias.'"}';
                    $total_pacientes++;
                    $json_coma++;
                }
                $total_indicador = $total_vigente;

                $porcentaje_indicador = number_format(($total_indicador*100/$total_pacientes),0,'.','');

                $series .=" { dataField: '$id', displayText: '$nombre_base',labels: {visible: true,verticalAlignment: 'top',offset: { x: 0, y: -20 } } ,formatFunction: function (value) {return value + ' %';},total_general:$total_pacientes,total_indicador:$total_indicador,hombres:$hombres,mujeres:$mujeres},";
                $rango .= ", $id:$porcentaje_indicador";

            }
            $rango .= "},";





        }else{
            //para todos los sectores internos seleccionados
            $sql1 = "select 
                                    sectores_centros_internos.nombre_sector_interno as nombre_base,
                                    sectores_centros_internos.id_sector_centro_interno as id,
                                    centros_internos.nombre_centro_interno as nombre_establecimiento
                                    from persona
                                    inner join paciente_establecimiento using (rut)
                                    inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                    inner join centros_internos on sectores_centros_internos.id_centro_interno=centros_internos.id_centro_interno
                                    inner join sector_comunal on centros_internos.id_sector_comunal=sector_comunal.id_sector_comunal
                                    where  m_salud_mental='SI' 
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

            $rango .= "{ Rango:'".$estado."' ";
            while($row1 = mysql_fetch_array($res1)){
                $nombre_base = $row1['nombre_base']." [".$row1['nombre_establecimiento']."]";
                $id = trim($row1['id']); // id_sector_comunal
                //total pacientes
                $sql_0 = "select *  from persona 
                                    inner join paciente_establecimiento using(rut) 
                                    inner join sectores_centros_internos on paciente_establecimiento.id_sector=sectores_centros_internos.id_sector_centro_interno
                                    inner join centros_internos on sectores_centros_internos.id_centro_interno=centros_internos.id_centro_interno
                                    inner join sector_comunal on centros_internos.id_sector_comunal=sector_comunal.id_sector_comunal
                                    where m_salud_mental='SI' and persona.rut!='' and paciente_establecimiento.id_establecimiento='$id_establecimiento' 
                                    and sectores_centros_internos.id_sector_centro_interno='$id' ";
                $res_0  = mysql_query($sql_0);
                $total_pacientes = 0;
                $total_pendiente = 0;
                $total_vigente = 0;
                $hombres_pendientes = 0;
                $mujeres_pendientes = 0;
                $hombres = 0;
                $mujeres = 0;
                while ($row_0 = mysql_fetch_array($res_0)){
                    $persona = new persona($row_0['rut']);
                    if($json_coma>0){
                        $json.=',';
                    }
                    if($valor_diagnostico!='TODO'){
                        $sql_1 = "select * from paciente_diagnosticos_sm 
                    inner join tipo_diagnostico_sm on paciente_diagnosticos_sm.id_tipo=tipo_diagnostico_sm.id_tipo
                    inner join valor_diagnostico_sm on tipo_diagnostico_sm.id_tipo=valor_diagnostico_sm.id_tipo
                    where rut='$persona->rut' and ( fecha_egreso='' or  fecha_egreso is null)
                    and nombre_tipo='$atributo' and valor_tipo='$valor_diagnostico' 
                    limit 1";

                    }else{
                        $sql_1 = "select * from paciente_diagnosticos_sm 
                    inner join tipo_diagnostico_sm on paciente_diagnosticos_sm.id_tipo=tipo_diagnostico_sm.id_tipo 
                    where rut='$persona->rut' and ( fecha_egreso='' or  fecha_egreso is null)
                    and nombre_tipo='$atributo'
                    limit 1";
                    }
                    $row_1 = mysql_fetch_array(mysql_query($sql_1));
                    if($row_1){
                        $fecha = fechaNormal($row_1['fecha_inicio']);
                        $indicador_json = $row_1['nombre_tipo'].' ['.$row_1['valor_tipo'].']';
                        $total_vigente++;
                        if($persona->sexo=='M'){
                            $hombres++;
                        }else{
                            $mujeres++;
                        }

                    }else{
                        $indicador_json = 'SIN REGISTRO';
                        $total_pendiente++;
                        if($persona->sexo=='M'){
                            $hombres_pendientes++;
                        }else{
                            $mujeres_pendientes++;
                        }
                    }

                    $json .= '{"IR":"'.$persona->rut.'","RUT":"'.$persona->rut.'","NOMBRE":"'.$persona->nombre.'","EDAD":"'.$persona->edad.'","COMUNAL":"'.$persona->nombre_sector_comunal.'","ESTABLECIMIENTO":"'.$persona->nombre_centro_medico.'","SECTOR_INTERNO":"'.$persona->nombre_sector_interno.'","INDICADOR":"'.$indicador_json.'","anios":"'.$persona->edad_anios.'","meses":"'.$persona->edad_meses.'","dias":"'.$persona->edad_dias.'"}';
                    $total_pacientes++;
                    $json_coma++;
                }
                $total_indicador = $total_vigente;

                $porcentaje_indicador = number_format(($total_indicador*100/$total_pacientes),0,'.','');

                $series .=" { dataField: '$id', displayText: '$nombre_base',labels: {visible: true,verticalAlignment: 'top',offset: { x: 0, y: -20 } } ,formatFunction: function (value) {return value + ' %';},total_general:$total_pacientes,total_indicador:$total_indicador,hombres:$hombres,mujeres:$mujeres},";
                $rango .= ", $id:$porcentaje_indicador";


            }
            $rango .= "},";


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
                '<b>' +serie.displayText+'</b><br />'+
                'Porcentaje: <b>' +value+'%</b><br />'+
                'Datos: <b>' +serie.total_indicador+'/'+serie.total_general+'</b><br />'+
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
                    { name: 'RUT', type: 'string' },
                    { name: 'NOMBRE', type: 'string' },
                    { name: 'EDAD', type: 'string' },
                    { name: 'anios', type: 'string' },
                    { name: 'meses', type: 'string' },
                    { name: 'dias', type: 'string' },
                    { name: 'COMUNAL', type: 'string' },
                    { name: 'ESTABLECIMIENTO', type: 'string' },
                    { name: 'SECTOR_INTERNO', type: 'string' },
                    { name: 'CONTACTO', type: 'string' },
                    { name: 'INDICADOR', type: 'string' },

                ],
                localdata: data
            };
        var cellLinkRegistroTarjetero = function(row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            return '<i onclick="loadMenu_M(\'menu_1\',\'registro_atencion\',\''+value+'\')" class="mdi-hardware-keyboard-return"></i> IR' ;
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
                    { text: 'RUT', dataField: 'RUT', cellsalign: 'right', width: 150 },
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
                    { text: 'AÑO', datafield: 'anios', width: 80 ,filtertype: 'checkedlist', cellsalign: 'center'},
                    { text: 'MES', datafield: 'meses', width: 80 ,filtertype: 'checkedlist', cellsalign: 'center'},
                    { text: 'DIA', datafield: 'dias', width: 80 ,filtertype: 'checkedlist', cellsalign: 'center'},
                    { text: '<?php echo $TITULO_GRAFICO; ?>', dataField: 'INDICADOR', cellsalign: 'left', width: 250,filtertype: 'checkedlist' },
                    { text: 'S. COMUNAL', dataField: 'COMUNAL', cellsalign: 'left', width: 250,filtertype: 'checkedlist' },
                    { text: 'ESTABLECIMIENTO', dataField: 'ESTABLECIMIENTO', cellsalign: 'left', width: 250,filtertype: 'checkedlist' },
                    { text: 'SECTOR_INTERNO', dataField: 'SECTOR_INTERNO', cellsalign: 'left', width: 250,filtertype: 'checkedlist' },
                    { text: 'CONTACTO', dataField: 'CONTACTO', cellsalign: 'left', width: 250},

                ]
            });
        $("#excelExport").click(function () {
            $("#table_grid").jqxGrid('exportdata', 'xls', '<?php echo $TITULO_GRAFICO; ?>', true,null,true, 'excel/save-file.php');
        });
        $("#valores").val('<?php echo $valor_diagnostico ?>');
        $("#valores").on('change',function(){
            var sector_comunal  = $("#sector_comunal").val();
            var sector_comunal  = $("#sector_comunal").val();
            var centro_interno  = $("#centro_interno").val();
            var sector_interno  = $("#sector_interno").val();
            var indicador  = $("#indicador").val();
            var atributo  = $("#atributo").val();
            var valores  = $("#valores").val();

            loadGif_graficos('header_graficos');
            $.post('graficos/barra/diagnosticos.php',{
                sector_comunal:sector_comunal,
                centro_interno:centro_interno,
                sector_interno:sector_interno,
                indicador: indicador,
                atributo: atributo,
                valores:valores
            },function(data){

                $("#header_graficos").html(data);
            });
        })
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
<input type="hidden" name="atributo" value="<?php echo str_replace('','',$_POST['atributo']); ?>" />
<input type="hidden" name="sector_comunal" value="<?php echo $_POST['sector_comunal']; ?>" />
<input type="hidden" name="centro_interno" value="<?php echo $_POST['centro_interno']; ?>" />
<input type="hidden" name="sector_interno" value="<?php echo $_POST['sector_interno']; ?>" />
<div id="div_imprimir">
    <div class="row right-align">
       <div class="col l12">
           <button class="btn" id="print">
               <i class="mdi-action-print left"></i>
               IMPRIMIR GRAFICO
           </button>
       </div>
    </div>

    <div class="card-panel">
        <div class="row">
            <div class="col l12 m12 s12">
                <select name="valores" id="valores">
                    <?php
                    echo $option_grafico;
                    ?>
                </select>
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
