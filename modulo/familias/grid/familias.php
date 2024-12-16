<style type="text/css">
    .cursor_cell_link{
        cursor: pointer;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        var source =
            {
                url: 'json/familias.php',
                datatype: "json",
                root: 'Rows',
                datafields:
                    [
                        {name: 'codigo', type: 'string'},
                        {name: 'nombre', type: 'string'},
                        {name: 'color', type: 'string'},
                        {name: 'integrantes', type: 'number'},
                        {name: 'puntaje', type: 'number'},
                        {name: 'direccion', type: 'string'},
                        {name: 'fecha_plan', type: 'string'},
                        {name: 'fecha_vdi', type: 'string'},
                        {name: 'fecha_pauta', type: 'string'},
                        {name: 'estado_general', type: 'string'},
                        {name: 'vdi', type: 'string'},
                        {name: 'estado_evaluacion', type: 'string'},
                        {name: 'establecimiento', type: 'string'},
                        {name: 'sector_comunal', type: 'string'},
                        {name: 'plan', type: 'string'},
                        {name: 'sector_interno', type: 'string'},
                        {name: 'link', type: 'string'},
                        {name: 'editar', type: 'string'},
                    ],
                cache: false
            };

        var cellLinkRegistroTarjetero = function(row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            return '<i onclick="loadMenu_M(\'menu_3\',\'registro_familia\',\''+value+'\')" ' +
                '   class="mdi-hardware-keyboard-return"></i> ' +
                '<span onclick="loadMenu_M(\'menu_3\',\'registro_familia\',\''+value+'\')">IR</span>';
        }
        var cellIrClass = function(row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            return  "eh-open_principal white-text cursor_cell_link center";

        }
        var cellEditarPaciente = function(row, columnfield, value, defaulthtml, columnproperties, rowdata) {

            return '<i class="mdi-editor-mode-edit" ' +
                'onclick="boxEditarFamilia(\''+value+'\')"></i>';

        }
        var cellEdadAnios = function(row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            var anios = parseInt(value/12);
            var meses = value%12;
            if(anios===0){
                return  "<div style='padding-left: 10px;'>"+meses+" Meses</div>";
            }else{
                if(anios>20){
                    return  "<div style='padding-left: 10px;'>"+anios + " Años</div>";
                }else{
                    return  "<div style='padding-left: 10px;'>"+anios + " Años "+meses+" Meses</div>";
                }

            }

        }
        var cellColor = function(row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            if(value==='MEDIO'){
                return  "orange darken-3";
            }else{
                if(value==='ALTO'){
                    return  "red darken-4 white-text";
                }else{
                    if(value==='BAJO'){
                        return  "green darken-1 white-text";
                    }else{
                        return  "";
                    }
                }
            }

        }
        var cellEditarClass = function(row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            return  "eh-open_principal white-text cursor_cell_link center";


        }
        var deleteTEXT = function(row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            return  " ";


        }

        var dataAdapter = new $.jqx.dataAdapter(source);

        var addfilter = function () {
            var filtergroup = new $.jqx.filter();
            var filter_or_operator = 1;
            var filtervalue = '';
            var filtercondition = 'contains';
            var filter1 = filtergroup.createfilter('stringfilter', filtervalue, filtercondition);
            filtervalue = 'Andrew';
            filtercondition = 'contains';
            var filter2 = filtergroup.createfilter('stringfilter', filtervalue, filtercondition);
            filtergroup.addfilter(filter_or_operator, filter1);
            filtergroup.addfilter(filter_or_operator, filter2);
            // add the filters.
            $("#grid").jqxGrid('addfilter', 'edad', filtergroup);
            // apply the filters.
            $("#grid").jqxGrid('applyfilters');
        };

        $("#grid").jqxGrid(
            {
                width: '98%',
                theme: 'eh-open',
                source: dataAdapter,
                height:alto-200,
                columnsresize: true,
                sortable: true,
                filterable: true,
                autoshowfiltericon: true,
                showfilterrow: true,
                showstatusbar: true,
                statusbarheight: 40,
                showaggregates: true,
                selectionmode: 'multiplecellsextended',
                columns: [
                    { text: '', datafield: 'link', width: 60,
                        cellclassname:cellIrClass,
                        cellsrenderer:cellLinkRegistroTarjetero ,filterable:false},
                    { text: '', datafield: 'editar', width: 40,
                        cellsrenderer:cellEditarPaciente ,
                        cellclassname:cellEditarClass,
                        filterable:false},
                    { text: 'CODIGO', datafield: 'codigo', width: 100,cellsalign: 'right'},
                    { text: ' ', datafield: 'color', width: 20,cellclassname:cellColor,cellsrenderer:deleteTEXT ,filterable: false, cellsalign: 'center'},
                    { text: 'PTJE', datafield: 'puntaje', width: 40, cellsalign: 'center'},
                    { text: 'ESTADO EV.', datafield: 'estado_evaluacion', width: 100 ,filtertype: 'checkedlist', cellsalign: 'center'},
                    { text: 'FECHA PROX.', datafield: 'fecha_pauta', width: 100 , cellsalign: 'center'},
                    { text: 'PLAN INTV.', datafield: 'plan', width: 100 ,filtertype: 'checkedlist', cellsalign: 'center'},
                    { text: 'FECHA PROX.', datafield: 'fecha_plan', width: 100 , cellsalign: 'center'},
                    { text: 'VDI.', datafield: 'vdi', width: 100 ,filtertype: 'checkedlist', cellsalign: 'center'},
                    { text: 'FECHA PROX.', datafield: 'fecha_vdi', width: 100 , cellsalign: 'center'},

                    { text: 'NOMBRE FAMILIA', datafield: 'nombre', width: 280,
                        aggregates: ['count'],
                        aggregatesrenderer: function (aggregates, column, element, summaryData) {
                            var renderstring = "<div  style='float: left; width: 100%; height: 100%;'>";
                            $.each(aggregates, function (key, value) {
                                var name = 'Total Familias';
                                renderstring += '<div style="; position: relative; margin: 6px; text-align: right; overflow: hidden;">' + name + ': ' + value + '</div>';
                            });
                            renderstring += "</div>";
                            return renderstring;
                        }
                    },
                    { text: 'INTEGRANTES', datafield: 'integrantes', width: 100},
                    { text: 'DIRECCION', datafield: 'direccion', width: 300 , cellsalign: 'left'},
                    { text: 'SECTOR COMUNAL', datafield: 'sector_comunal', width: 150 ,filtertype: 'checkedlist'},
                    { text: 'ESTABLECIMIENTO', datafield: 'establecimiento', width: 300 ,filtertype: 'checkedlist'},
                    { text: 'SECTOR INTERNO', datafield: 'sector_interno', width: 150 ,filtertype: 'checkedlist'},


                ]
            });
        $("#excelExport").jqxButton();
        $("#newFamilia").jqxButton();
        $("#searchIntegrante").jqxButton();
        $("#excelExport").click(function () {
            // $("#grid").jqxGrid('exportdata', 'xls', 'jqxGrid');
            $("#grid").jqxGrid('exportdata', 'xls', 'Pacientes SIS Mujer', true,null,true, 'https://carahue.eh-open.com/exportar/save-file.php');
        });
        $("#newFamilia").click(function () {
            boxNuevaFamilia();
        });
        $("#searchIntegrante").click(function () {
            boxSearchIntegrante();
        });
    });
    function boxSearchIntegrante(){
        $.post('formulario/buscar_inegrante.php',{
            id:id
        },function(data){
            if(data !== 'ERROR_SQL'){
                $("#modal").html(data);
                document.getElementById("btn-modal").click();
            }
        });
    }
    function boxNuevaFamilia(id){
        $.post('formulario/nueva_familia.php',{
            id:id
        },function(data){
            if(data !== 'ERROR_SQL'){
                $("#modal").html(data);
                document.getElementById("btn-modal").click();
            }
        });
    }
    function boxInfoEstablecimiento(id){
        $.post('php/modal/establecimiento/informacion.php',{
            id:id
        },function(data){
            if(data !== 'ERROR_SQL'){
                $("#modal").html(data);
                document.getElementById("btn-modal").click();
            }
        });
    }
    function boxEditarPaciente_AM(rut) {
        $.post('../default/formulario/editar_paciente.php',{
            rut:rut,
        },function(data){
            if(data !== 'ERROR_SQL'){
                $("#modal").html(data);
                $("#modal").css({'width':'1100px'});
                document.getElementById("btn-modal").click();
            }
        });
    }
    function cargarListado(){
        // prepare the data

    }
    function boxEditarFamilia(id){
        $.post('formulario/editar_familia.php', {
            id_familia: id,
        }, function (data) {
            if (data !== 'ERROR_SQL') {
                $("#modal").html(data);
                $("#modal").css({'width': '1100px'});
                document.getElementById("btn-modal").click();
            }
        });
    }
</script>
<div class="row center-align">
    <div class="col l12">
        <div class="card-panel">
            <div class="row">
                <div class="col l6 left-align">
                    <input type="button" class="btn eh-open_principal"
                           value="NUEVA FAMILA" id='newFamilia' />
                    <input type="button" class="btn eh-open_principal"
                           value="BUSCAR INTEGRANTE" id='searchIntegrante' />
                </div>
                <div class="col l6 right-align">
                    <input type="button" class="btn eh-open_principal"
                           value="Exportar a Excel" id='excelExport' />
                </div>
            </div>
            <div class="row">
                <div class="col l12">
                    <div id="grid"></div>
                </div>
            </div>
            <div class="row left-align">
                <div class="col l12 m12 s12">
                    <i class="mdi-hardware-keyboard-return"></i>PERMITE PODER INGRESAR LA FICHA CORRESPONDIENTE DE LA FAMILIA SELECCIONADA
                </div>
                <div class="col l12 m12 s12">
                    <i class="mdi-editor-mode-edit"></i>PERMITE EDITAR LA FAMILIA, PARA MODIFICAR SUS DATOS ESPECIFICOS.
                </div>
            </div>
        </div>
    </div>
</div>

