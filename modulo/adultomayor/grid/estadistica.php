<style type="text/css">
    .cursor_cell_link {
        cursor: pointer;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        load_pacientes__estadistica();
    });

    function load_pacientes__estadistica() {
        var id_centro = $("#id_centro_interno").val();
        var source =
            {
                url: 'json/estadistica.php',
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

                        {name: 'IMC', type: 'string'},
                        {name: 'ACTIVIDAD_FISICA', type: 'string'},
                        {name: 'RIESGO_CAIDA', type: 'string'},
                        {name: 'SOSPECHO_MALTRATO', type: 'string'},
                        {name: 'YESAVAGE', type: 'string'},
                        {name: 'MAS_ADULTO_MAYOR', type: 'string'},
                        {name: 'FUNCIONALIDAD', type: 'string'},
                        {name: 'CHILE_CUIDA', type: 'string'},
                        {name: 'MINIMENTAL', type: 'string'},
                        {name: 'ESTACION_UNIPODAL', type: 'string'},
                        {name: 'ELEAM', type: 'string'},
                        {name: 'ultimo_control', type: 'string'},


                    ],
                cache: false
            };

        var cellLinkRegistroTarjetero = function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            return '<i onclick="loadMenu_CardioVascular(\'menu_1\',\'registro_atencion\',\'' + value + '\')"  ' +
                'style="color: white;" class="mdi-hardware-keyboard-return"></i> IR';
        }
        var cellIrClass = function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            return "eh-open_principal white-text cursor_cell_link center";

        }
        var cellEditarPaciente = function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {

            return '<i class="mdi-editor-mode-edit" ' +
                'onclick="boxEditarPaciente_PSCV(\'' + value + '\')"></i>';

        }
        var cellEdadAnios = function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            var anios = parseInt(value / 12);
            var meses = value % 12;
            if (anios === 0) {
                return "<div style='padding-left: 10px;'>" + meses + " Meses</div>";
            } else {
                if (anios > 20) {
                    return "<div style='padding-left: 10px;'>" + anios + " Años</div>";
                } else {
                    return "<div style='padding-left: 10px;'>" + anios + " Años " + meses + " Meses</div>";
                }

            }

        }
        var cellSexo = function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            if (value == 'M') {
                return "light-blue lighten-1";
            } else {
                return "pink lighten-1 white-text";
            }

        }


        var dataAdapter = new $.jqx.dataAdapter(source);


        $("#grid_paciente").jqxGrid(
            {
                width: '98%',
                theme: 'eh-open',
                source: dataAdapter,
                height: alto-300,
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
                        text: '', datafield: 'link', width: 60,
                        cellclassname: cellIrClass,
                        cellsrenderer: cellLinkRegistroTarjetero, filterable: false
                    },
                    {text: 'RUT', datafield: 'rut', width: 100, cellsalign: 'right'},
                    {
                        text: 'Nombre Completo', datafield: 'nombre', width: 280,
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
                    {
                        text: 'SEXO',
                        datafield: 'sexo',
                        width: 80,
                        filtertype: 'checkedlist',
                        cellsalign: 'center',
                        cellclassname: cellSexo
                    },
                    {text: 'AÑOS', datafield: 'anios', width: 80, cellsalign: 'center', filtertype: 'checkedlist'},
                    {text: 'MESES', datafield: 'meses', width: 80, cellsalign: 'center', filtertype: 'checkedlist'},
                    {text: 'DIAS', datafield: 'dias', width: 80, cellsalign: 'center', filtertype: 'checkedlist'},
                    {text: 'SECTOR COMUNAL', datafield: 'sector_comunal', width: 150, filtertype: 'checkedlist'},
                    {text: 'ESTABLECIMIENTO', datafield: 'establecimiento', width: 300, filtertype: 'checkedlist'},
                    {text: 'SECTOR INTERNO', datafield: 'sector_interno', width: 150, filtertype: 'checkedlist'},

                    {text: 'IMC', datafield: 'IMC', width: 80, filtertype: 'checkedlist'},
                    {text: 'ACTIVIDAD_FISICA', datafield: 'ACTIVIDAD_FISICA', width: 50, filtertype: 'checkedlist'},
                    {text: 'RIESGO_CAIDA', datafield: 'RIESGO_CAIDA', width: 50, filtertype: 'checkedlist'},
                    {text: 'SOSPECHA_MALTRATO', datafield: 'SOSPECHA_MALTRATO', width: 50, filtertype: 'checkedlist'},
                    {text: 'YESAVAGE', datafield: 'YESAVAGE', width: 50, filtertype: 'checkedlist'},
                    {text: 'MAS_ADULTO_MAYOR', datafield: 'MAS_ADULTO_MAYOR', width: 50, filtertype: 'checkedlist'},
                    {text: 'FUNCIONALIDAD', datafield: 'FUNCIONALIDAD', width: 50, filtertype: 'checkedlist'},
                    {text: 'CHILE_CUIDA', datafield: 'CHILE_CUIDA', width: 50, filtertype: 'checkedlist'},
                    {text: 'MINIMENTAL', datafield: 'MINIMENTAL', width: 50, filtertype: 'checkedlist'},
                    {text: 'ESTACION_UNIPODAL', datafield: 'ESTACION_UNIPODAL', width: 50, filtertype: 'checkedlist'},
                    {text: 'ELEAM', datafield: 'ELEAM', width: 50, filtertype: 'checkedlist'},


                    {text: 'ULTIMO CONTROL', datafield: 'ultimo_control', width: 100},


                ]
            });
        $("#excelExport_estadistica").jqxButton();
        $("#excelExport_estadistica").click(function () {
            alertaLateral('EXPORTANDO INFORMACION');
            // $("#grid").jqxGrid('exportdata', 'xls', 'jqxGrid');
            $("#grid_paciente").jqxGrid('exportdata', 'xls', 'ESTADISTICA ADULTO MAYOR', true, null, true, 'export.php');
            // $("#grid_paciente").jqxGrid('exportdata', 'xls', 'Pacientes PSCV - DETALLE');
        });
    }

    function boxInfoEstablecimiento(id) {
        $.post('php/modal/establecimiento/informacion.php', {
            id: id
        }, function (data) {
            if (data !== 'ERROR_SQL') {
                $("#modal").html(data);
                document.getElementById("btn-modal").click();
            }
        });
    }

    function cargarListado() {
        // prepare the data

    }
</script>
<div class="row center-align">
    <div class="col l12">
        <div class="card-panel">
            <div class="row">
                <div class="col l4 m6 s6">
                    <button class="btn right-align eh-open_principal" id="excelExport_estadistica">
                        <i class="mdi-action-open-in-new left"></i>
                        EXPORTAR A EXCEL
                    </button>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col l12">
                    <div id="grid_paciente"></div>
                </div>
            </div>
            <div class="row">
                <div class="col l12 m12 s12">
                    <i class="mdi-hardware-keyboard-return"></i>PERMITE PODER INGRESAR LA FICHA CORRESPONDIENTE AL
                    USUARIO SELECCIONADO
                </div>
                <div class="col l12 m12 s12">
                    <i class="mdi-editor-mode-edit"></i>PERMITE EDITAR AL PACIENTE, PARA MODIFICAR SUS DATOS PERSONALES
                    Y ADEMAS CAMBIARLO DE ESTABLECIMIENTO.
                </div>
            </div>
        </div>
    </div>
</div>

