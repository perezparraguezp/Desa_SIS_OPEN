<style type="text/css">
    .cursor_cell_link{
        cursor: pointer;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        load_pacientes_pscv_estadistica();
    });
    function load_pacientes_pscv_estadistica(){
        var id_centro = $("#id_centro_interno").val();
        var source =
            {
                url: 'json/pacientes_indicadores.php',
                datatype: "json",
                root: 'Rows',
                datafields:
                    [
                        {name: 'rut', type: 'string'},
                        {name: 'nombre', type: 'string'},
                        {name: 'sexo', type: 'string'},
                        {name: 'anios', type: 'number'},
                        {name: 'meses', type: 'number'},
                        {name: 'dias', type: 'number'},
                        {name: 'sector', type: 'string'},
                        {name: 'sector_comunal', type: 'string'},
                        {name: 'establecimiento', type: 'string'},
                        {name: 'sector_interno', type: 'string'},
                        {name: 'riesgo_cv', type: 'string'},
                        {name: 'hta', type: 'string'},
                        {name: 'hta_fecha', type: 'string'},
                        {name: 'dm', type: 'string'},
                        {name: 'dm_fecha', type: 'string'},
                        {name: 'dlp', type: 'string'},
                        {name: 'dlp_fecha', type: 'string'},
                        {name: 'pa', type: 'string'},
                        {name: 'pa_fecha', type: 'string'},
                        {name: 'ldl', type: 'string'},
                        {name: 'ldl_fecha', type: 'string'},
                        {name: 'rac', type: 'string'},
                        {name: 'rac_fecha', type: 'string'},
                        {name: 'imc', type: 'string'},
                        {name: 'imc_fecha', type: 'string'},
                        {name: 'vfg', type: 'string'},
                        {name: 'vfg_fecha', type: 'string'},
                        {name: 'erc', type: 'string'},
                        {name: 'erc_fecha', type: 'string'},
                        {name: 'electro', type: 'string'},
                        {name: 'hba1c', type: 'string'},
                        {name: 'hba1c_fecha', type: 'string'},
                        {name: 'ev_pie', type: 'string'},
                        {name: 'ev_pie_fecha', type: 'string'},
                        {name: 'fondo_ojo', type: 'string'},
                        {name: 'fondo_ojo_fecha', type: 'string'},
                        {name: 'insulina', type: 'string'},
                        {name: 'link', type: 'string'},
                    ],
                cache: false
            };

        var cellLinkRegistroTarjetero = function(row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            return '<i onclick="loadMenu_CardioVascular(\'menu_1\',\'registro_atencion\',\''+value+'\')"  ' +
                'style="color: white;" class="mdi-hardware-keyboard-return"></i> IR' ;
        }
        var cellIrClass = function(row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            return  "eh-open_principal white-text cursor_cell_link center";

        }
        var cellEditarPaciente = function(row, columnfield, value, defaulthtml, columnproperties, rowdata) {

            return '<i class="mdi-editor-mode-edit" ' +
                'onclick="boxEditarPaciente_PSCV(\''+value+'\')"></i>';

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
        var cellSexo = function(row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            if(value=='M'){
                return  "light-blue lighten-1";
            }else{
                return  "pink lighten-1 white-text";
            }

        }


        var dataAdapter = new $.jqx.dataAdapter(source);


        $("#grid_paciente").jqxGrid(
            {
                width: '98%',
                theme: 'eh-open',
                source: dataAdapter,
                height:400,
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
                    { text: '', datafield: 'link', width: 60,
                        cellclassname:cellIrClass,
                        cellsrenderer:cellLinkRegistroTarjetero ,filterable:false},
                    { text: 'RUT', datafield: 'rut', width: 100,cellsalign: 'right'},
                    { text: 'Nombre Completo', datafield: 'nombre', width: 280,
                        aggregates: ['count'],
                        aggregatesrenderer: function (aggregates, column, element, summaryData) {
                            var renderstring = "<div  style='float: left; width: 100%; height: 100%;'>";
                            $.each(aggregates, function (key, value) {
                                var name = 'Total Pacientes';
                                renderstring += '<div style="; position: relative; margin: 6px; text-align: right; overflow: hidden;">' + name + ': ' + value + '</div>';
                            });
                            renderstring += "</div>";
                            return renderstring;
                        }
                    },
                    { text: 'SEXO', datafield: 'sexo', width: 80 ,filtertype: 'checkedlist', cellsalign: 'center',cellclassname: cellSexo},
                    { text: 'AÑOS', datafield: 'anios', width: 80 , cellsalign: 'center',filtertype: 'checkedlist'},
                    { text: 'MESES', datafield: 'meses', width: 80 , cellsalign: 'center',filtertype: 'checkedlist'},
                    { text: 'DIAS', datafield: 'dias', width: 80 , cellsalign: 'center',filtertype: 'checkedlist'},
                    { text: 'SECTOR COMUNAL', datafield: 'sector_comunal', width: 150 ,filtertype: 'checkedlist'},
                    { text: 'ESTABLECIMIENTO', datafield: 'establecimiento', width: 300 ,filtertype: 'checkedlist'},
                    { text: 'SECTOR INTERNO', datafield: 'sector_interno', width: 150 ,filtertype: 'checkedlist'},

                    { text: 'RIESGO CV', datafield: 'riesgo_cv', width: 80 ,filtertype: 'checkedlist'},
                    { text: 'HTA', datafield: 'hta', width: 50 ,filtertype: 'checkedlist'},

                    { text: 'DM', datafield: 'dm', width: 50 ,filtertype: 'checkedlist'},
                    
                    { text: 'DLP', datafield: 'dlp', width: 50 ,filtertype: 'checkedlist'},
                    { text: 'IMC', datafield: 'imc', width: 80 ,filtertype: 'checkedlist'},
                    { text: 'IMC/FECHA', datafield: 'imc_fecha', width: 80 ,filtertype: 'checkedlist'},
                    { text: 'PA', datafield: 'pa', width: 100 ,filtertype: 'checkedlist'},
                    { text: 'PA/FECHA', datafield: 'pa_fecha', width: 100 ,filtertype: 'checkedlist'},
                    { text: 'LDL', datafield: 'ldl', width: 100 ,filtertype: 'checkedlist'},
                    { text: 'LDL/FECHA', datafield: 'ldl_fecha', width: 100 ,filtertype: 'checkedlist'},
                    { text: 'RAC', datafield: 'rac', width: 100 ,filtertype: 'checkedlist'},
                    { text: 'RAC/FECHA', datafield: 'rac_fecha', width: 100 ,filtertype: 'checkedlist'},
                    { text: 'VFG', datafield: 'vfg', width: 100 ,filtertype: 'checkedlist'},
                    { text: 'VFG/FECHA', datafield: 'vfg_fecha', width: 100 ,filtertype: 'checkedlist'},
                    { text: 'ERC/RAC', datafield: 'erc', width: 100 ,filtertype: 'checkedlist'},
                    { text: 'ERC/RAC/FECHA', datafield: 'erc_fecha', width: 100 ,filtertype: 'checkedlist'},
                    { text: 'ELECTROCARDIOGRAMA', datafield: 'electro', width: 100 ,filtertype: 'checkedlist'},
                    { text: 'HAB1C', datafield: 'hba1c', width: 100 ,filtertype: 'checkedlist'},
                    { text: 'HAB1C/FECHA', datafield: 'hba1c_fecha', width: 100 ,filtertype: 'checkedlist'},
                    { text: 'EV PIE', datafield: 'ev_pie', width: 100 ,filtertype: 'checkedlist'},
                    { text: 'EV PIE/FECHA', datafield: 'ev_pie_fecha', width: 100 ,filtertype: 'checkedlist'},
                    { text: 'FONDO OJO', datafield: 'fondo_ojo', width: 100 ,filtertype: 'checkedlist'},
                    { text: 'FONDO OJO/FECHA', datafield: 'fondo_ojo_fecha', width: 100 ,filtertype: 'checkedlist'},
                    { text: 'INSULINA', datafield: 'insulina', width: 50 ,filtertype: 'checkedlist'},


                ]
            });
        $("#excelExport_estadistica").jqxButton();
        $("#excelExport_estadistica").click(function () {
            alertaLateral('EXPORTANDO INFORMACION');
            // $("#grid").jqxGrid('exportdata', 'xls', 'jqxGrid');
            $("#grid_paciente").jqxGrid('exportdata', 'xls', 'Pacientes PSCV', true,null,true, 'https://carahue.eh-open.com/exportar/save-file.php');
            // $("#grid_paciente").jqxGrid('exportdata', 'xls', 'Pacientes PSCV - DETALLE');
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
    function cargarListado(){
        // prepare the data

    }
</script>
<div class="row center-align">
    <div class="col l12">
        <div class="card-panel">
            <div class="row">
                <div class="col l4 m6 s6">
                    <button class="btn right-align eh-open_principal" id="excelExport_estadistica" >
                        <i class="mdi-action-open-in-new left"></i>
                        EXPORTAR
                    </button>
                </div>
            </div>
            <hr />
            <div class="row">
                <div class="col l12">
                    <div id="grid_paciente"></div>
                </div>
            </div>
            <div class="row">
                <div class="col l12 m12 s12">
                    <i class="mdi-hardware-keyboard-return"></i>PERMITE PODER INGRESAR LA FICHA CORRESPONDIENTE AL USUARIO SELECCIONADO
                </div>
                <div class="col l12 m12 s12">
                    <i class="mdi-editor-mode-edit"></i>PERMITE EDITAR AL PACIENTE, PARA MODIFICAR SUS DATOS PERSONALES Y ADEMAS CAMBIARLO DE ESTABLECIMIENTO.
                </div>
            </div>
        </div>
    </div>
</div>

